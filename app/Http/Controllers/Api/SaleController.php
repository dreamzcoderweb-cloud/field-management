<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sale\StoreSaleRequest;
use App\Models\Advance;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Ledger;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Stock;
use App\Models\Stockhistory;
use App\Models\Target;
use App\Models\Targetproduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $sales = Sale::whereHas('client', function ($query) {
    //         $query->where('created_by_id', Auth::id());
    //     })
    //         ->when(request('search'), function ($query, $search) {
    //             $query->whereRelation('client', 'name', 'LIKE', "$search%")
    //                 ->orWhereRelation('client', 'phone', 'LIKE', "$search%")
    //                 ->orWhereRelation('product', 'name', 'LIKE', "$search%")
    //                 ->orWhereRelation('saleProducts.product', 'name', 'LIKE', "$search%")
    //                 ->orWhereRelation('bank', 'name', 'LIKE', "$search%");
    //         })
    //         ->when(request('from'), function ($query, $from) {
    //             $query->whereDate('created_at', '>=', "$from");
    //         })
    //         ->when(request('to'), function ($query, $to) {
    //             $query->whereDate('created_at', '<=', "$to");
    //         })
    //         ->with(['product', 'saleProducts.product', 'client', 'bank'])
    //         ->latest()
    //         ->get();
    //         $sales->map(function($sale){
    //             $sale->balance = ($sale->product_amount ?? 0) - ($sale->exchangable_amount ?? 0) - ($sale->paid_amount ?? 0);
    //             return $sale;
    //         });

    //     return new JsonResponse([
    //         'success' => true,
    //         'sales' => $sales
    //     ]);
    // }
    public function index()
    {
        $sales = Sale::whereHas('client', function ($query) {
            $query->where('created_by_id', Auth::id());
        })
        ->when(request('search'), function ($query, $search) {
            $query->whereRelation('client', 'name', 'LIKE', "$search%")
                ->orWhereRelation('client', 'phone', 'LIKE', "$search%")
                ->orWhereRelation('product', 'name', 'LIKE', "$search%")
                ->orWhereRelation('saleProducts.product', 'name', 'LIKE', "$search%")
                ->orWhereRelation('bank', 'name', 'LIKE', "$search%");
        })
        ->when(request('from'), function ($query, $from) {
            $query->whereDate('created_at', '>=', $from);
        })
        ->when(request('to'), function ($query, $to) {
            $query->whereDate('created_at', '<=', $to);
        })
        ->with(['product', 'saleProducts.product', 'client', 'bank'])
        ->latest()
        ->get();

        $sales->map(function ($sale) {
            $sale->balance =
                ($sale->product_amount ?? 0)
                - ($sale->exchangable_amount ?? 0)
                - ($sale->paid_amount ?? 0);

            return $sale;
        });
        
        // Group by client
        $groupedSales = $sales->groupBy('client_id')->map(function ($items) {

            $client = $items->first()->client;

            return [
                'client' => $client,

                'products' => $items->map(function ($sale) {
                    return [
                        'sale_id' => $sale->id,
                        'product' => $sale->product,
                        'sale_products' => $sale->saleProducts,
                        'payment_method' => $sale->payment_method,
                        "is_exchangable" => $sale->is_exchangable,
                        "exchangable_item" => $sale->exchangable_item,
                        "exchangable_amount" => $sale->exchangable_amount,
                        "vehicle_number" => $sale->vehicle_number,
                        "vehicle_year" => $sale->vehicle_year,
                        "bank_name" => $sale->bank->name ?? null,
                        'interest' => $sale->interest,
                        'amount' => $sale->amount,
                        'emi_applicable' => $sale->emi_applicable,  
                        'emi_amount' => $sale->emi_amount,
                        'emi_month' => $sale->emi_month,
                        'emi_date' => $sale->emi_date,
                        'product_amount' => $sale->product_amount,
                        'paid_amount' => $sale->paid_amount,
                        'balance' => $sale->balance,
                        'created_at' => $sale->created_at,
                    ];
                })->values()
            ];
        })->values();

        return response()->json([
            'success' => true,
            'sales' => $groupedSales
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $ongoingSalesClientId = Sale::where('is_completed', 0)
    //         ->pluck('client_id');
    //     $clients = Client::where('created_by_id', Auth::id())
    //         ->whereNotIn('id', $ongoingSalesClientId)
    //         ->latest()
    //         ->get();
    //     $banks = Bank::all();
    //     $products = Product::whereHas('stock', function ($query) {
    //         $query->where('quantity', '>=', 1);
    //     })
    //         ->with('stock')
    //         ->get();
    //     return new JsonResponse([
    //         'success' => true,
    //         'clients' => $clients,
    //         'banks' => $banks,
    //         'products' => $products
    //     ]);
    // }
    // public function create()
    // {
       
    //     $clients = Client::where('created_by_id', Auth::id())
    //         ->latest()
    //         ->get();

    //     $banks = Bank::all();

    //     $products = Product::whereHas('stock', function ($query) {
    //         $query->where('quantity', '>=', 1);
    //     })
    //         ->with('stock')
    //         ->get();

    //     return new JsonResponse([
    //         'success' => true,
    //         'clients' => $clients,
    //         'banks' => $banks,
    //         'products' => $products
    //     ]);
    // }

    public function create(Request $request)
    {
        $clients = Client::where('created_by_id', Auth::id())
            ->latest()
            ->get();

        $banks = Bank::all();

        $productType = $request->product_type;

        // validation
        if ($productType !== null && !in_array($productType, [0, 1, '0', '1'])) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid product type. Allowed values: 0 or 1'
            ], 422);
        }

        // convert value
        $type = null;

        if ($productType !== null) {
            $type = $productType == 0 ? 'old' : 'new';
        }

        $products = Product::whereHas('stock', function ($query) {
                $query->where('quantity', '>=', 1);
            })
            ->with('stock')
            ->when($type !== null, function ($query) use ($type) {
                $query->where('product_type', $type);
            })
            ->get();

        

        return response()->json([
        'success' => true,
        'message' => $products->isEmpty()
            ? 'No products found'
            : 'Products retrieved successfully',
        'clients' => $clients,
        'banks' => $banks,
        'products' => $products
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        $validator = $request->validated();

        // Build products list from validated payload.
        $productsInput = $validator['products'] ?? [];
        // Fallback: if validator didn't populate `products`, normalize from raw input.
        if (empty($productsInput) && $request->has('products')) {
            $productsInput = $request->input('products');
        }

        // Normalize possible shapes:
        // - [{product_id, quantity}, ...]
        // - {product_id, quantity}
        // - JSON-decoded string/object (rare, but handle defensively)
        if (is_string($productsInput)) {
            $decoded = json_decode($productsInput, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $productsInput = $decoded;
            }
        }

        if (is_object($productsInput)) {
            $productsInput = (array) $productsInput;
        }

        if (!is_array($productsInput)) {
            $productsInput = [];
        }

        // If a single product object is sent (not wrapped in an array), convert it.
        if (!isset($productsInput[0]) && (isset($productsInput['product_id']) || isset($productsInput['quantity']))) {
            $productsInput = [$productsInput];
        }

        $products = collect(is_array($productsInput) ? $productsInput : [])
            ->map(fn($row) => [
                'product_id' => (int) ($row['product_id'] ?? 0),
                'quantity' => max((int) ($row['quantity'] ?? 1), 1),
            ])
            ->filter(fn($row) => $row['product_id'] > 0);


        // Backward compatibility: allow single product_id payload.
        if ($products->isEmpty() && !empty($validator['product_id'])) {
            $products = collect([[
                'product_id' => (int) $validator['product_id'],
                'quantity' => 1,
            ]]);
        }

        if ($products->isEmpty()) {
            return new JsonResponse([
                'success' => false,
                'message' => "At least one product is required.",
                // 'debug' => [
                //     'received_products' => $request->input('products'),
                //     'validator_products' => $validator['products'] ?? null,
                //     'received_product_id' => $request->input('product_id'),
                // ],
            ], 422);
        }


        foreach ($products as $item) {
            $stock = Stock::where('product_id', $item['product_id'])->first();
            if (!$stock || $stock->quantity < $item['quantity']) {
                return new JsonResponse([
                    'success' => false,
                    'message' => "Product is out of stock."
                ]);
            }
        }

        $validator['payment_method'] = (int) $request->payment_method;
       // dd($validator['payment_method']);
        // Keep bank fields only for bank payments.
        if ($validator['payment_method'] === 1) {
            $validator['bank_id'] = null;
            $validator['interest'] = null;
        }

        $validator['product_amount'] = (float) ($validator['product_amount'] ?? $validator['amount'] ?? 0);
        $validator['amount'] = (float) ($validator['amount'] ?? $validator['product_amount']);
        $validator['paid_amount'] = (int) ($validator['paid_advance'] ?? 0) === 1
            ? (float) ($validator['advance_amount'] ?? 0)
            : 0;
        $validator['balance'] = max($validator['product_amount'] - $validator['paid_amount'], 0);
        $validator['cash_amount'] = $validator['payment_method'] === 1 ? $validator['paid_amount'] : 0;
        $validator['bank_amount'] = $validator['payment_method'] === 0 ? $validator['paid_amount'] : 0;

        if (($validator['product_amount'] ?? 0) == ($validator['paid_amount'] ?? 0)) {
            $validator['is_completed'] = 1;
        }

        $validator['product_id'] = $products->first()['product_id'];

        $sale = DB::transaction(function () use ($products, $request, $validator) {
            $sale = Sale::create($validator);

            foreach ($products as $item) {
                $product = Product::find($item['product_id']);
                $stock = Stock::where('product_id', $item['product_id'])->first();
                $this->deductStockIfAvailable($stock, [
                    'product_id' => $item['product_id'],
                    'amount' => (($product?->price ?? 0) * $item['quantity']),
                    'quantity' => $item['quantity'],
                ]);

                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_amount' => (float) ($product?->price ?? 0),
                    'total_amount' => (float) (($product?->price ?? 0) * $item['quantity']),
                ]);
            }

            $this->addadvance($request, $sale);
            $this->checkTarget($validator);
            $this->makeLedger($sale, $validator);

            return $sale;
        });

        return new JsonResponse([
            'success' => true,
            'message' => "Saled Completed",
           // 'sale' => $sale->load(['product', 'saleProducts.product', 'client', 'bank'])
        ]);
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
        $quantity = max((int) ($validator['quantity'] ?? 1), 1);
        if (isset($currentStock) && $currentStock->quantity >= $quantity) {
            $currentStock->quantity -= $quantity;
            $currentStock->update();
            $this->makeStockHistory($stock, $validator);
            return $stock = true;
        }
        return $stock = false;
    }

    public function makeStockHistory($stock, $validator)
    {
        $quantity = max((int) ($validator['quantity'] ?? 1), 1);
        Stockhistory::create([
            'product_id' => $validator['product_id'],
            'stock_id' => $stock->id,
            'amount' => $validator['amount'],
            'quantity' => $quantity,
            'type' => 2
        ]);
        return true;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}

