<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sale Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #333;
        }

        h1, h2, h3, h4, h5 {
            color: #2E3B4E;
            margin-bottom: 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h2 {
            border-bottom: 1px solid #2E3B4E;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .param {
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .status-paid {
            color: green;
            font-weight: bold;
        }

        .status-unpaid {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Sale Summary (Outstanding)</h1>

    {{-- Client Details --}}
    <div class="section">
        <h2>Client Details</h2>
        <p><strong>Name:</strong> <span class="param">{{ $sale?->client?->name }}</span></p>
        <p><strong>Mobile:</strong> <span class="param">{{ $sale?->client?->phone }}</span></p>
        <p><strong>Email:</strong> <span class="param">{{ $sale?->client?->email }}</span></p>
        <p><strong>Address:</strong> <span class="param">{{ $sale?->client?->address }}</span></p>
    </div>

    {{-- Product & Bank Details --}}
    <div class="section">
        <h2>Product & Bank Details</h2>
        <p><strong>Product Name:</strong> <span class="param">{{ $sale?->product?->name }}</span></p>
        <p><strong>Product Amount:</strong> <span class="param">{{ $sale?->product_amount }}</span></p>
        <p><strong>Bank Name:</strong> <span class="param">{{ $sale?->bank?->name }}</span></p>
        <p><strong>Interest:</strong> <span class="param">{{ $sale?->interest }}</span></p>

        @if ($sale->emi_applicable == 1)
        <p><strong>EMI Duration:</strong> <span class="param">{{ $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count() }}/{{ $sale?->emi_month }}</span></p>
        <p><strong>EMI Amount:</strong> <span class="param">{{ $sale?->emi_amount }}</span></p>
        @endif
    </div>

    {{-- Price & Payment Details --}}
    <div class="section">
        <h2>Price & Payment Details</h2>
        <table>
            <tr>
                <th>Product Price</th>
                <td>{{ $sale?->product_amount }}</td>
            </tr>
            <tr>
                <th>Interest Amount</th>
                <td>{{ $sale?->amount - $sale?->product_amount }}</td>
            </tr>
            <tr>
                <th>Total Cost</th>
                <td>{{ $sale?->amount }}</td>
            </tr>
            <tr>
                <th>Total Advance</th>
                <td>{{ $sale?->advance?->sum('amount') ?? 0 }}</td>
            </tr>
            <tr>
                <th>Total Paid</th>
                <td class="status-paid">{{ $sale?->paid_amount ?? 0 }}</td>
            </tr>
            <tr>
                <th>Balance</th>
                <td class="status-unpaid">{{ $sale?->balance ?? 0 }}</td>
            </tr>
            @if ($sale->is_exchangable == 1)
            <tr>
                <th>Exchangeable Item</th>
                <td>{{ $sale?->exchangable_item }} ({{ $sale?->exchangable_amount }})</td>
            </tr>
            <tr>
                <th>Vehicle Number/Year</th>
                <td>{{ $sale?->vehicle_number }}/{{ $sale?->vehicle_year }}</td>
            </tr>
            @endif
        </table>
    </div>

    {{-- Advance List --}}
    <div class="section">
        <h2>Advance Paid List</h2>
        <table>
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Amount</th>
                    <th>Paid At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sale?->advance as $advance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $advance->amount }}</td>
                    <td>{{ $advance->created_at?->format('d-m-Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center">No Records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- EMI Paid List --}}
    @if ($sale?->emi_applicable == 1)
    <div class="section">
        <h2>EMI Paid List</h2>
        <table>
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Amount</th>
                    <th>Claimed By</th>
                    <th>Claimed At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sale?->due->where(fn($d) => optional($d->duty)->status == 1) as $due)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $due->amount }}</td>
                    <td>{{ $due->duty?->user?->first_name }} {{ $due->duty?->user?->last_name }}</td>
                    <td>{{ $due->duty?->updated_at?->format('d-m-Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center">No Records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

</body>
</html>
