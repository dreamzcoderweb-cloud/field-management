<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SalesReportExport;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Team;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SaleReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = $this->salesQuery(request()->all(), 0)
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $products = Product::get();
        $clients = Client::get();
        $teams = Team::get();
        return view('report.sale', ['sales' => $sales, 'products' => $products, 'clients' => $clients, 'teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('report.saledetail', ['sale' => $sale->load(['product', 'client', 'bank', 'due', 'duty'])]);
    }

    public function export(Request $request)
    {
        return Excel::download(
            new SalesReportExport($request->all(), 0),
            now()->format('Ymd_His') . '_sale_report.xlsx'
        );
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

    private function salesQuery(array $filters, int $isExchangable)
    {
        return Sale::with(['product', 'client', 'client.employee.team', 'bank'])
            ->where('is_exchangable', $isExchangable)
            ->when($filters['from'] ?? null, function ($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($filters['to'] ?? null, function ($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->when($filters['product_id'] ?? null, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when($filters['client_id'] ?? null, function ($query, $clientId) {
                $query->where('client_id', $clientId);
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('amount', 'LIKE', "%$search%")
                        ->orWhere('paid_amount', 'LIKE', "%$search%")
                        ->orWhere('balance', 'LIKE', "%$search%")
                        ->orWhereRelation('client', 'name', 'LIKE', "%$search%")
                        ->orWhereRelation('bank', 'name', 'LIKE', "%$search%")
                        ->orWhereRelation('client.employee', 'user_name', 'LIKE', "%$search%");
                });
            })
            ->when($filters['team_id'] ?? null, function ($query, $teamId) {
                $query->whereRelation('client.employee', 'team_id', $teamId);
            })
            ->where('is_completed', 1);
    }
}


