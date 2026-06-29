@php
    $title = 'Collection Details';
    $advanceAmount = $collection->emi_amount > 0 && $collection->status != 'completed'
        ? max($collection->paid_amount - ($collection->paid_months * $collection->emi_amount), 0)
        : 0;
    $nextPayableAmount = $collection->status != 'completed'
        ? min($collection->balance_amount, max($collection->emi_amount - $advanceAmount, 0))
        : 0;
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{ $title }}</h4>
            </div>
        </div>
        <div class="col">
            <div class="float-end">
                <!-- <a href="{{ route('collections.edit', $collection->id) }}" class="btn btn-primary">
                    <span class="fa fa-edit fa-fw me-2"></span>Edit
                </a> -->
                <a href="{{ route('collections.index') }}" class="btn btn-danger">Back</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <h6>Client</h6>
                    <p>{{ $collection?->client?->name }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>Product</h6>
                    <p>{{ $collection?->product?->name }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>EMI Amount</h6>
                    <p>{{ $collection->emi_amount }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>EMI Date</h6>
                    <p>{{ $collection->emi_date }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>Total Amount</h6>
                    <p>{{ $collection->total_amount }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>Paid Amount</h6>
                    <p>{{ $collection->paid_amount }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>Balance</h6>
                    <p>{{ $collection->balance_amount }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>Months</h6>
                    <p>{{ $collection->paid_months }} / {{ $collection->total_months }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>Extra Paid Amount</h6>
                    <p>{{ $advanceAmount }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6>Next Payable Amount</h6>
                    <p>{{ $nextPayableAmount }}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($collection->status != 'completed')
        <div class="card mt-3">
            <div class="card-body">
                <h6>Add EMI Payment</h6>
                <form action="{{ route('collections.transactions.store', $collection->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3 mb-3">
                            <label for="amount" class="control-label">Amount</label>
                            <input id="amount" name="amount" class="form-control" value="{{ old('amount', $nextPayableAmount) }}" />
                            <span class="text-danger">{{ $errors->first('amount', ':message') }}</span>
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label for="payment_date" class="control-label">Payment Date</label>
                            <input type="date" id="payment_date" name="payment_date" class="form-control" value="{{ old('payment_date', now()->format('Y-m-d')) }}" />
                            <span class="text-danger">{{ $errors->first('payment_date', ':message') }}</span>
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label for="emi_month" class="control-label">EMI Month</label>
                            <input id="emi_month" name="emi_month" class="form-control" value="{{ old('emi_month', $collection->paid_months + 1) }}" />
                            <span class="text-danger">{{ $errors->first('emi_month', ':message') }}</span>
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label for="notes" class="control-label">Notes</label>
                            <input id="notes" name="notes" class="form-control" value="{{ old('notes') }}" />
                            <span class="text-danger">{{ $errors->first('notes', ':message') }}</span>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <h6>Transactions</h6>
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>EMI Month</th>
                            <th>Amount</th>
                            <th>Extra Amount</th>
                            <th>Payment Date</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection->transactions as $transaction)
                            <tr>
                                <td class="ps-2">{{ $loop->iteration }}</td>
                                <td>{{ $transaction->emi_month ?? '-' }}</td>
                                <td>{{ $transaction->amount }}</td>
                                @php
                                    $coveredMonths = $collection->emi_amount > 0 ? floor($transaction->amount / $collection->emi_amount) : 0;
                                    $transactionExtraAmount = $collection->emi_amount > 0
                                        ? max($transaction->amount - ($coveredMonths * $collection->emi_amount), 0)
                                        : 0;
                                @endphp
                                
                                <td>{{ $transactionExtraAmount }}</td>
                                <td>{{ $transaction->payment_date?->format('d-m-Y') }}</td>
                                <td>{{ $transaction->notes ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('collections.transactions.destroy', $transaction->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
