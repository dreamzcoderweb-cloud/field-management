@php
$title = 'Customer Ledger';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2E3B4E;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
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

    <h1>{{ $title }}</h1>

    <table>
        <thead>
            <tr>
                <th>Sl.No</th>
                <th>Client Name</th>
                <th>Product Name</th>
                <th>Sale Date</th>
                <th>Amount</th>
                <th>Paid Amount</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
            @foreach ($client->sale as $sale)
            <tr>
                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $sale->product?->name }}</td>
                <td>{{ $sale->created_at?->format('d-m-Y') }}</td>
                <td>{{ $sale->amount }}</td>
                <td class="status-paid">{{ $sale->paid_amount ?? 0 }}</td>
                <td class="status-unpaid">{{ $sale->balance ?? $sale->amount }}</td>
            </tr>
            @endforeach
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No outstanding clients.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
