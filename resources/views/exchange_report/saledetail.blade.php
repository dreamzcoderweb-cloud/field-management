@php
    use App\Models\Settings;
    $title = 'Sales Report';
    $settings = Settings::first();
@endphp

@extends('layout')
@section('title', $title)

@section('main-content')
    <style>
        .report-card {
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            background: #fff;
            min-height: 230px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .report-title {
            border-bottom: 3px solid #0056b3;
            padding-bottom: 8px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #0056b3;
            text-transform: uppercase;
            font-size: 18px;
        }

        .param {
            font-weight: bold;
            color: #333;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #0056b3;
            margin-bottom: 10px;
            border-bottom: 3px solid #0056b3;
            padding-bottom: 5px;
            text-transform: uppercase;
        }
    </style>

    <div class="container mt-4">
        <div class="text-center mb-4">
            <h2 class="text-uppercase text-primary">{{ $title }}</h2>
            <p class="text-muted">Generated on: {{ now()->format('d-m-Y') }}</p>
        </div>

        <div class="row g-3">
            <!-- Client Details -->
            <div class="col-md-4">
                <div class="report-card">
                    <h5 class="report-title">Client Details</h5>
                    <p><strong>Name:</strong> <span class="param">{{ $sale?->client?->name }}</span></p>
                    <p><strong>Mobile:</strong> <span class="param">{{ $sale?->client?->phone }}</span></p>
                    <p><strong>Email:</strong> <span class="param">{{ $sale?->client?->email }}</span></p>
                    <p><strong>Address:</strong> <span class="param">{{ $sale?->client?->address }}</span></p>
                </div>
            </div>

            <!-- Product & Bank Details -->
            <div class="col-md-4">
                <div class="report-card">
                    <h5 class="report-title">Product & Bank Details</h5>
                    <p><strong>Product Name:</strong> <span class="param">{{ $sale?->product?->name }}</span></p>
                    <p><strong>Amount:</strong> <span class="param">{{ number_format($sale?->product_amount, 2) }}</span>
                    </p>
                    <p><strong>Bank Name:</strong> <span class="param">{{ $sale?->bank?->name }}</span></p>
                    <p><strong>Interest:</strong> <span class="param">{{ number_format($sale?->interest, 2) }}%</span></p>
                </div>
            </div>

            <!-- Price Details -->
            <div class="col-md-4">
                <div class="report-card">
                    <h5 class="report-title">Price Details</h5>
                    <p><strong>Product Price:</strong> <span
                            class="param">{{ number_format($sale?->product_amount, 2) }}</span></p>
                    <p><strong>Interest Price:</strong> <span
                            class="param">{{ number_format($sale?->amount - $sale?->product_amount, 2) }}</span></p>
                    <p><strong>Total Cost:</strong> <span class="param">{{ number_format($sale?->amount, 2) }}</span></p>
                    <p><strong>Paid Amount:</strong> <span
                            class="param text-success">{{ number_format($sale?->paid_amount, 2) }}</span></p>
                    <p><strong>Balance Amount:</strong> <span
                            class="param text-danger">{{ number_format($sale?->balance, 2) }}</span></p>
                </div>
            </div>
            @if ($sale->is_exchangable == 1)
                <div class="row mt-2">
                    <h5>Exchangable Item</h5>
                    <div class="col-md-3">
                        <p><strong>Exchangable Item:</strong> <span class="param">{{ $sale?->exchangable_item }}</span>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Exchangable Amount:</strong> <span
                                class="param">{{ $sale?->exchangable_amount }}</span>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Vehicle Registration Number:</strong> <span
                                class="param">{{ $sale?->vehicle_number }}</span>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Vehicle Registration Year:</strong> <span
                                class="param">{{ $sale?->vehicle_year }}</span>
                        </p>
                    </div>
                </div>
            @endif
        </div>

        @if ($sale?->emi_applicable == 1)
            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h4 class="text-primary text-center">EMI Payment Summary</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Claimed By</th>
                                    <th>Claimed At</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalEmiPaid = 0;
                                @endphp
                                @if ($sale?->due->isNotEmpty())
                                    @foreach ($sale->due as $due)
                                        @if ($due?->duty?->status == 1)
                                            @php $totalEmiPaid += $due->amount; @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $due?->duty?->user?->first_name }}
                                                    {{ $due?->duty?->user?->last_name }}</td>
                                                <td>{{ $due?->duty?->updated_at?->format('d-m-Y') }}</td>
                                                <td>{{ number_format($due->amount, 2) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr class="table-primary">
                                        <td colspan="3" class="text-end"><strong>Total EMI Amount Paid:</strong></td>
                                        <td><strong>{{ number_format($totalEmiPaid, 2) }}</strong></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No EMI records available.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

