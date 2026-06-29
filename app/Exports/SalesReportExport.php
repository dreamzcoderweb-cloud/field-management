<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    public function __construct(
        protected array $filters = [],
        protected int $isExchangable = 0
    ) {}

    public function collection()
    {
        return Sale::with(['product', 'client', 'client.employee.team', 'bank'])
            ->where('is_exchangable', $this->isExchangable)
            ->when($this->filters['from'] ?? null, function ($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($this->filters['to'] ?? null, function ($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->when($this->filters['product_id'] ?? null, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when($this->filters['client_id'] ?? null, function ($query, $clientId) {
                $query->where('client_id', $clientId);
            })
            ->when($this->filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('amount', 'LIKE', "%$search%")
                        ->orWhere('paid_amount', 'LIKE', "%$search%")
                        ->orWhere('balance', 'LIKE', "%$search%")
                        ->orWhereRelation('client', 'name', 'LIKE', "%$search%")
                        ->orWhereRelation('bank', 'name', 'LIKE', "%$search%")
                        ->orWhereRelation('client.employee', 'user_name', 'LIKE', "%$search%");
                });
            })
            ->when($this->filters['team_id'] ?? null, function ($query, $teamId) {
                $query->whereRelation('client.employee', 'team_id', $teamId);
            })
            ->where('is_completed', 1)
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
            'EMI Applicable',
            'Exchangable',
            'Status',
            'Date',
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
            'H' => 50,
            'I' => 50,
            'J' => 15,
            'K' => 15,
        ];
    }

    public function map($sale): array
    {
        $emiValue = 'No';
        if ((int) $sale->emi_applicable === 1) {
            $paidMonths = $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count() ?? 0;
            $emiValue = 'Yes | Month: ' . $paidMonths . '/' . ($sale->emi_month ?? 0)
                . ' | Amount: ' . ($sale->emi_amount ?? 0)
                . ' | Due Date: ' . ($sale->emi_date ?? '-');
        }

        $exchangeValue = 'No';
        if ((int) $sale->is_exchangable === 1) {
            $exchangeValue = 'Yes | Item: ' . ($sale->exchangable_item ?? '-')
                . ' | Amount: ' . ($sale->exchangable_amount ?? 0);
        }

        return [
            $sale?->product?->name,
            $sale?->client?->name,
            $sale?->client?->phone,
            $sale?->client?->employee?->team?->name,
            $sale->amount,
            $sale->paid_amount,
            $sale->balance,
            $emiValue,
            $exchangeValue,
            $sale?->is_completed == 1 ? 'Completed' : 'On Going',
            optional($sale->created_at)->format('d-m-Y'),
        ];
    }

}
