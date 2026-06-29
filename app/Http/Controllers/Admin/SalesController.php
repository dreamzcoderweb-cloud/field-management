<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sale\StoreSaleRequest;
use App\Http\Requests\Admin\Sale\UpdateSaleRequest;
use App\Models\Advance;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Ledger;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Stockhistory;
use App\Models\Target;
use App\Models\Targetproduct;
use App\Models\Team;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['product', 'client', 'client.employee.team', 'bank'])
            ->when(request('from'), function ($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when(request('to'), function ($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->when(request('product_id'), function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when(request('client_id'), function ($query, $clientId) {
                $query->where('client_id', $clientId);
            })
            ->when(request('status'), function ($query, $status) {
                if (request('status') == 2) {
                    $status = 0;
                }
                $query->where('is_completed', $status);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where('amount', "LIKE", "%$search")
                    ->orWhere('paid_amount', "LIKE", "%$search")
                    ->orWhere('balance', "LIKE", "%$search")
                    ->orWhereRelation('client', 'name', "LIKE", "%$search")
                    ->orWhereRelation('bank', 'name', "LIKE", "%$search")
                    ->orWhereRelation('client.employee', "user_name", "LIKE", "%$search");
            })
            ->when(request('team_id'), function ($query, $teamId) {
                $query->whereRelation('client.employee', 'team_id', $teamId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $products = Product::get();
        $clients = Client::get();
        $teams = Team::get();
        // dd($sales);
        return view('sale.index', ['sales' => $sales, 'products' => $products, 'clients' => $clients, 'teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();
        $clients = Client::get();
        $banks = Bank::where('status', "active")
            ->get();
        return view('sale.create', ['banks' => $banks, 'clients' => $clients, 'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        // dd($request->validated());
        $validator = $request->validated();
        // dd($validator);
        $stock = Stock::where('product_id', $validator['product_id'])
            ->first();
        // dd($stock?->quantity);
        if ($stock?->quantity < 0) {
            return back()->with('error', "Product is out of stock.");
        }
        $existingSale = Sale::where('client_id', $validator['client_id'])
            ?->latest()
            ?->first();
        if (isset($existingSale) && $existingSale->is_completed == 0) {
            return back()->with('error', "Unable to proceed with the purchase as a buying process is already in progress.");
        }
        $validator = $request->validated();
        $stockDeduction = $this->deductStockIfAvailable($stock, $validator);
        // dd($stockDeduction);
        if ($stockDeduction == false) {
            return back()->with('error', "Product is out of stock.");
        }
        $paymentMethodInput = (string) ($validator['payment_method'] ?? '1');
        $validator['payment_method'] = in_array($paymentMethodInput, ['bank', '0'], true) ? 0 : 1;

        $validator['product_amount'] = (float) ($validator['product_amount'] ?? $validator['amount'] ?? 0);
        $validator['amount'] = (float) ($validator['amount'] ?? $validator['product_amount']);
        $validator['paid_amount'] = (int) ($validator['paid_advance'] ?? 0) === 1
            ? (float) ($validator['advance_amount'] ?? 0)
            : 0;
        $validator['balance'] = max($validator['product_amount'] - $validator['paid_amount'], 0);
        $validator['cash_amount'] = $validator['payment_method'] === 1 ? $validator['paid_amount'] : 0;
        $validator['bank_amount'] = $validator['payment_method'] === 0 ? $validator['paid_amount'] : 0;

        if ($validator['product_amount'] == $validator['paid_amount']) {
            $validator['is_completed'] = 1;
        }
        $sale = Sale::create($validator);
        $result = $this->addadvance($request, $sale);
        $response = $this->checkTarget($validator);
        $ledgerResponse = $this->makeLedger($sale, $validator);

        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $data = $response->getData(true);
            Log::info("Target check", $data);
        }
        return to_route('sale.index')->with('success', "Saled Added");
    }

    public function checkTarget($validator)
    {
        $client = Client::where('id', $validator['client_id'])->first();
        if (!isset($client)) {
            return response()->json(['success' => false, 'message' => 'Client not found']);
        }

        $employee = User::where('id', $client->created_by_id)->first();
        if (!isset($employee)) {
            return response()->json(['success' => false, 'message' => 'Employee not found']);
        }

        $target = Target::where('user_id', $employee->id)
            ->where('status', 1)
            ->whereDate('from', '<=', Carbon::today())
            ->whereDate('to', '>=', Carbon::today())
            ->with('targetproduct')
            ->first();

        if (!$target) {
            return response()->json(['success' => false, 'message' => 'Active target not found']);
        }

        $targetProduct = Targetproduct::where('target_id', $target->id)
            // ->where('product_id', $validator['product_id'])
            ->where('is_completed', 0)
            ->first();

        if (!$targetProduct) {
            return response()->json(['success' => false, 'message' => 'Target product not found or already completed']);
        }

        $targetProduct->update(['is_completed' => 1]);

        $completedCount = Targetproduct::where('target_id', $target->id)
            ->where('is_completed', 1)
            ->count();

        if (count($target->targetproduct) === $completedCount) {
            $target->update(['status' => 2]); // Assuming you meant status 2 for completed?
            return response()->json(['success' => true, 'message' => 'Target Completed']);
        }

        return response()->json(['success' => false, 'message' => 'Target not Completed']);
    }

    public function makeLedger($sale, $validator)
    {
        $client = Client::where('id', $validator['client_id'])->first();
        if (!isset($client)) {
            return response()->json(['success' => false, 'message' => 'Client not found']);
        }

        $employee = User::where('id', $client->created_by_id)->first();
        if (!isset($employee)) {
            return response()->json(['success' => false, 'message' => 'Employee not found']);
        }

        $checkLedger = Ledger::where('user_id', $employee->id)
            ?->whereMonth('created_at', now()->month)
            ?->whereYear('created_at', now()->year)
            ?->count();

        Ledger::create([
            'sale_id' => $sale->id,
            'user_id' => $employee->id,
            'status' => $validator['amount'] == $validator['paid_amount'] ? 1 : 2,
            'amount' => $checkLedger > 0 ? 7000 : 5000
        ]);
    }


    public function deductStockIfAvailable($stock, $validator)
    {
        $currentStock = Stock::where('id', $stock->id)
            ->first();
        if (isset($currentStock) && $currentStock->quantity > 0) {
            $currentStock->quantity -= 1;
            $currentStock->update();
            $this->makeStockHistory($stock, $validator);
            return $stock = true;
        }
        return $stock = false;
    }

    public function makeStockHistory($stock, $validator)
    {
        Stockhistory::create([
            'product_id' => $validator['product_id'],
            'stock_id' => $stock->id,
            'amount' => $validator['amount'],
            'quantity' => 1,
            'type' => 2
        ]);
        return true;
    }

    public function getaddadvance(Sale $sale)
    {
        // dd($sale);
        $sales = Sale::with(['product', 'client', 'bank'])
            ->latest()
            ->get();
        return view('advacnce.create', ['sale' => $sale->load(['advance', 'client', 'product', 'bank']), 'sales' => $sales]);
    }

    public function addadvance(Request $request, Sale $sale)
    {
        // dd($request->all(), $sale);
        if (isset($sale) && $request->advance_amount != "") {
            $sale = Sale::where('id', $sale->id)
                ->first();
            Advance::create([
                'sale_id' => $sale->id,
                'amount' => $request?->advance_amount
            ]);
            if ($request?->direct == 1) {
                $advanceAmount = $sale->advance?->sum('amount');
                $exchangableAmount = $sale->exchangable_amount;
                $paid_amount = $advanceAmount + $exchangableAmount;
                $balance_amount = $sale->balance - $request->advance_amount;
                $emi_amount = $sale->emi_month > 0 ? round($balance_amount / $sale->emi_month) : 0;
                if ((now() < $sale->created_at->addDays(180)) && ($paid_amount >= $sale->amount)) {
                    $ledger = $this->checkLedger($sale);
                }
                $sale->update([
                    'is_completed' => $paid_amount == $sale->amount ? 1 : 0,
                    'paid_amount' => $paid_amount,
                    'balance' => $balance_amount,
                    'emi_amount' => $emi_amount
                ]);
                return to_route('sale.index')->with('success', "Advance added!!!");
            }
            return 1;
        } else {
            return 0;
        }
    }
    
    public function checkLedger($sale)
    {
        $ledger = Ledger::where('sale_id', $sale->id)
            ->first();
        if (isset($ledger)) {
            $ledger->status = 1;
            $ledger->save();
        }
        return true;
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('sale.show', ['sale' => $sale->load(['product', 'client', 'bank', 'due', 'advance', 'duty'])]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $products = Product::get();
        $clients = Client::get();
        $banks = Bank::where('status', "active")
            ->get();
        return view('sale.edit', ['sale' => $sale, 'products' => $products, 'clients' => $clients, 'banks' => $banks]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $sale->update($request->validated());
        return to_route('sale.index')->with('success', "Sales updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if ($sale->due()->exists() || $sale->duty()->exists()) {
            return back()->with('error', "Unable to delete this sale.");
        }
        // Delete the sale
        $stock = Stock::where('product_id', $sale->product_id)
            ->first();
        if (isset($stock)) {
            $stock->quantity += 1;
            Stockhistory::create([
                'stock_id' => $stock->id,
                'quantity' => 1,
                'product_id' => $sale->product_id,
                'amount' => $sale->amount,
                'type' => 3
            ]);
            $stock->update();
        }
        $ledger = Ledger::where('sale_id', $sale->id)?->first();
        $ledger?->delete();
        $sale->delete();

        return back()->with('success', "Sale deleted successfully!");
    }

    public function productAmount(Request $request)
    {
        $product = Product::where('id', $request->id)
            ->with('stock')
            ->first();
        // dd($product);
        $quantity = Stock::where('product_id', $product->id)
            ->first();
        $quantity = isset($quantity) ? $quantity->quantity : 0;
        if (isset($product)) {
            return new JsonResponse([
                'amount' => $product->price,
                'quantity' => $quantity
            ]);
        } else {
            return new JsonResponse([
                'amount' => 0,
                'quantity' => $quantity
            ]);
        }
    }

    public function CompleteSale()
    {
        $success = false;
        $sales = Sale::where('is_completed', 0)
            ->with(['duty', 'due'])
            ->get();
        // dd($sales[0]?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count());

        foreach ($sales as $sale) {
            $sale->emi_month == $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count();
            $sale->is_completed = 1;
            $sale->update();
            $success = true;
        }

        return response()->json($success);
    }
}

