<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OutstandingCustomerReportExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Team;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OutstandingCustomerReportController extends Controller
{
    public function index()
    {
        $sales = $this->query(request()->all())
            ->paginate(10)
            ->withQueryString();

        $products = Product::get();
        $teams = Team::get();

        return view('outstanding_report.index', compact('sales', 'products', 'teams'));
    }

    public function export(Request $request)
    {
        return Excel::download(
            new OutstandingCustomerReportExport($request->all()),
            now()->format('Ymd_His') . '_outstanding_customer_report.xlsx'
        );
    }

    private function query(array $filters)
    {
        return Sale::with(['product', 'client', 'client.employee.team'])
            ->where('balance', '>', 0)
            ->when($filters['from'] ?? null, function ($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($filters['to'] ?? null, function ($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->when($filters['product_id'] ?? null, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when($filters['team_id'] ?? null, function ($query, $teamId) {
                $query->whereRelation('client.employee', 'team_id', $teamId);
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('amount', 'LIKE', "%$search%")
                        ->orWhere('paid_amount', 'LIKE', "%$search%")
                        ->orWhere('balance', 'LIKE', "%$search%")
                        ->orWhereRelation('client', 'name', 'LIKE', "%$search%")
                        ->orWhereRelation('client', 'mobile', 'LIKE', "%$search%");
                });
            })
            ->latest();
    }
}
