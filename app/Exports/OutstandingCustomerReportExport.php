<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OutstandingCustomerReportExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    public function __construct(protected array $filters = [])
    {
    }

    public function collection()
    {
        return Sale::with(['product', 'client', 'client.employee.team'])
            ->where('balance', '>', 0)
            ->when($this->filters['from'] ?? null, function ($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($this->filters['to'] ?? null, function ($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->when($this->filters['product_id'] ?? null, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when($this->filters['team_id'] ?? null, function ($query, $teamId) {
                $query->whereRelation('client.employee', 'team_id', $teamId);
            })
            ->when($this->filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('amount', 'LIKE', "%$search%")
                        ->orWhere('paid_amount', 'LIKE', "%$search%")
                        ->orWhere('balance', 'LIKE', "%$search%")
                        ->orWhereRelation('client', 'name', 'LIKE', "%$search%")
                        ->orWhereRelation('client', 'mobile', 'LIKE', "%$search%");
                });
            })
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Product',
            'Client Name',
            'Client Mobile',
            'Team',
            'Amount',
            'Paid Amount',
            'Balance',
            'Status',
            'Date',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale?->product?->name,
            $sale?->client?->name,
            $sale?->client?->phone,
            $sale?->client?->employee?->team?->name,
            $sale->amount,
            $sale->paid_amount,
            $sale->balance,
            (int) $sale->is_completed === 1 ? 'Completed' : 'On Going',
            optional($sale->created_at)->format('d-m-Y'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
        ];
    }
}
