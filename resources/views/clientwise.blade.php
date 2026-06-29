@php
    $title = 'Customer Ledger';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <!-- <style>
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
    </style> -->
    <style>

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
        font-size: 11px;
        word-wrap: break-word;
        vertical-align: top;
    }

    th {
        background: #f2f2f2;
        text-align: center;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .status-paid {
        color: green;
        font-weight: bold;
    }

    .status-unpaid {
        color: red;
        font-weight: bold;
    }

    .nested-table th,
    .nested-table td {
        font-size: 10px;
        padding: 4px;
    }

</style>
</head>

<body>

    <h1>{{ $title }}</h1>

    <!-- <table>
        <thead>
            <tr>
                <th>Sl.No</th>
                <th>Client Name</th>
                <th>Product Name</th>
                <th>Exchangable Details</th>
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
                        @if ($sale->is_exchangable == 1)
                            <td>{{ $sale->exchangable_item }} <br> {{ $sale->exchangable_amount }} </td>
                        @else
                            <td>N/A</td>
                        @endif

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
    </table> -->
     @forelse ($clients as $client)
     <table width="100%" border="1" cellspacing="0" cellpadding="6" style="margin-bottom:20px;">

        <tr>
            <th width="20%">Client Name</th>
            <td>{{ $client->name }}</td>

            <th width="20%">Phone</th>
            <td>{{ $client->phone }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $client->email ?? '-' }}</td>

            <th>City</th>
            <td>{{ $client->city ?? '-' }}</td>
        </tr>

        <tr>
            <th>Address</th>
            <td colspan="3">
                {{ $client->address ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Contact Person</th>
            <td>{{ $client->contact_person_name ?? '-' }}</td>

            <th>Status</th>
            <td>{{ ucfirst($client->status) }}</td>
        </tr>

    </table>

    <table>
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Client Name</th>
            <th>Product Name</th>
            <th>Exchangable Details</th>
            <th>Sale Date</th>
            <th>Amount</th>
            <th>Advance Amount</th>
            <th>Paid Amount</th>
            <th>Balance</th>
            <th>Emi Month</th>
            <th>Emi Amount</th>
        </tr>
    </thead>

    <tbody>

       

            @foreach ($client->sale as $sale)

                {{-- SALE ROW --}}
                <tr>
                    <td>
                        {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                    </td>

                    <td>{{ $client->name }}</td>

                    <td>
                        {{ $sale->product?->name }}
                    </td>

                    @if ($sale->is_exchangable == 1)

                        <td>
                            {{ $sale->exchangable_item }}
                            <br>
                            {{ $sale->exchangable_amount }}
                        </td>

                    @else

                        <td>N/A</td>

                    @endif

                    <td>
                        {{ $sale->created_at?->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ number_format($sale->amount, 2) }}
                    </td>
                    <td>
                        {{ number_format($sale->advance->sum('amount') ?? 0, 2) }}
                    </td>
                    <td class="status-paid">
                        {{ number_format($sale->paid_amount ?? 0, 2) }}
                    </td>

                    <td class="status-unpaid">
                        {{ number_format($sale->balance ?? $sale->amount, 2) }}
                    </td>
                    <td>
                        {{ $sale->emi_month ?? '-' }}
                    </td>
                    <td>
                        {{ number_format($sale->emi_amount ?? 0, 2) }}
                    </td>
                </tr>

                {{-- COLLECTIONS --}}
                @if($sale->collections->count())

                    <tr>
                        <td colspan="11">

                            <table width="100%" border="1" cellspacing="0" cellpadding="5">

                                <thead>
                                    <tr style="background:#f2f2f2;">
                                        <th>Collection Date</th>
                                        <th>Paid Months</th>
                                        <th>Transaction Amount</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($sale->collections as $collection)

                                        @if($collection->collectionTransactions->count())

                                            @foreach($collection->collectionTransactions as $transaction)

                                                <tr>

                                                    <td>
                                                        {{ \Carbon\Carbon::parse($collection->created_at)->format('d-m-Y') }}
                                                    </td>

                                                    

                                                    <td>
                                                        {{ $transaction->emi_month ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ number_format($transaction->amount ?? 0, 2) }}
                                                    </td>

                                                    <td>
                                                        {{ $transaction->notes ?? '-' }}
                                                    </td>

                                                </tr>

                                            @endforeach

                                        @else

                                            <tr>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($collection->created_at)->format('d-m-Y') }}
                                                </td>

                                                <td>
                                                    {{ number_format($collection->amount, 2) }}
                                                </td>

                                                <td colspan="3">
                                                    No transaction found
                                                </td>

                                            </tr>

                                        @endif

                                    @endforeach

                                </tbody>

                            </table>

                        </td>
                    </tr>

                @endif

            @endforeach

        @empty

            <tr>
                <td colspan="8" style="text-align: center;">
                    No outstanding clients.
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

</body>

</html>
