@php
    use App\Models\Settings;
    $title = 'Sales detail';
    $settings = Settings::first();
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <style>
        .param {
            font-weight: 600;
        }
    </style>
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{ $title }}</h4>
            </div>
        </div>
        <div class="col">

        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h5 class="mb-4">Sale Summary</h5>

            <div class="row">
                <!-- Client Details -->
                <div class="col-md-4">
                    <div class="border p-3 rounded">
                        <h6 class="text-primary">Client Details</h6>
                        <p><strong>Name:</strong> <span class="param">{{ $sale?->client?->name }}</span></p>
                        <p><strong>Mobile:</strong> <span class="param">{{ $sale?->client?->phone }}</span></p>
                        <p><strong>Email:</strong> <span class="param">{{ $sale?->client?->email }}</span></p>
                        <p><strong>Address:</strong> <span class="param">{{ $sale?->client?->address }}</span></p>
                    </div>
                </div>

                <!-- Product & Bank Details -->
                <div class="col-md-4">
                    <div class="border p-3 rounded">
                        <h6 class="text-primary">Product Details</h6>
                        <p><strong>Product Name:</strong> <span class="param">{{ $sale?->product?->name }}</span></p>
                        <p><strong>Amount:</strong> <span class="param">{{ $sale?->product_amount }}</span></p>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mt-3">Bank Details</h6>
                                <p><strong>Bank Name:</strong> <span class="param">{{ $sale?->bank?->name }}</span></p>
                                <p><strong>Interest:</strong> <span class="param">{{ $sale?->interest }}</span></p>
                            </div>
                            <div class="col-md-6">
                                @if ($sale->emi_applicable == 1)
                                    <h6 class="text-primary mt-3">Due Count</h6>
                                    <p><strong>Duration:</strong> <span
                                            class="param">{{ $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count() }}
                                            / {{ $sale?->emi_month }}</span></p>
                                    <p><strong>EMI Amount:</strong> <span class="param">{{ $sale?->emi_amount }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Details -->
                <div class="col-md-4">
                    <div class="border p-3 rounded">
                        <h6 class="text-primary">Price Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Product Price:</strong> <span class="param">{{ $sale?->product_amount }}</span>
                                </p>
                                <p><strong>Interst Price:</strong> <span
                                        class="param">{{ $sale?->amount - $sale?->product_amount }}</span></p>
                                <p><strong>Total Cost:</strong> <span class="param">{{ $sale?->amount }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Advance:</strong> <span
                                        class="param">{{ $sale?->advance?->sum('amount') }}</span></p>
                                <p><strong>Exchangeable Amount:</strong> <span
                                        class="param">{{ $sale?->exchangable_amount != '' ? $sale?->exchangable_amount : 0 }}</span>
                                </p>
                                <p><strong>Total EMI Amount:</strong> <span
                                        class="param">{{ $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->sum('amount') ?? 0 }}</span>
                                </p>
                            </div>
                        </div>
                        <hr>
                        {{-- <center> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Paid Amount:</strong> <span
                                        class="param text-success">{{ $sale?->paid_amount }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Balance Amount:</strong> <span
                                        class="param text-danger">{{ $sale?->balance }}</span>
                                </p>
                            </div>
                        </div>
                        {{-- </center> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h4 class="text-muted"> <u>Addvance paid list</u> </h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Amount</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sale->advance) > 0)
                            @foreach ($sale->advance as $advance)
                                <tr>
                                    <td class="ps-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $advance?->amount }}</td>
                                    <td>{{ $advance?->created_at->format('d-m-Y') }}</td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">
                                    <center>No Records.</center>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- {{ dd($sale) }} --}}
    @if ($sale?->emi_applicable == 1)
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="text-muted"> <u>EMI paid list</u> </h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Amount</th>
                                <th>Claimed By</th>
                                <th>Claimed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($sale?->due->isNotEmpty())
                                @foreach ($sale->due as $due)
                                    {{-- {{ dd($due->sale); }} --}}
                                    @if ($due?->duty?->status == 1)
                                        <tr>
                                            <td class="ps-2">{{ $loop->iteration }}</td>
                                            <td>{{ $due->amount }}</td>
                                            {{-- {{ dd($due->duty); }} --}}
                                            <td>{{ $due?->duty?->user?->first_name }}
                                                {{ $due?->duty?->user?->last_name }}</td>
                                            <td>{{ $due?->duty?->updated_at?->format('d-m-Y') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No Records.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
