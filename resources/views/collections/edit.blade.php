@php
    $title = 'Edit Collection';
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
        <div class="col"></div>
    </div>

    <form action="{{ route('collections.update', $collection->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6>{{ $collection?->client?->name }} - {{ $collection?->product?->name }}</h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="total_amount" class="control-label">Total Amount</label>
                                <input id="total_amount" name="total_amount" class="form-control"
                                    value="{{ old('total_amount', $collection->total_amount) }}" />
                                <span class="text-danger">{{ $errors->first('total_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="paid_amount" class="control-label">Paid Amount</label>
                                <input id="paid_amount" name="paid_amount" class="form-control"
                                    value="{{ old('paid_amount', $collection->paid_amount) }}" />
                                <span class="text-danger">{{ $errors->first('paid_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="balance_amount" class="control-label">Balance Amount</label>
                                <input id="balance_amount" name="balance_amount" class="form-control"
                                    value="{{ old('balance_amount', $collection->balance_amount) }}" />
                                <span class="text-danger">{{ $errors->first('balance_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="emi_amount" class="control-label">EMI Amount</label>
                                <input id="emi_amount" name="emi_amount" class="form-control"
                                    value="{{ old('emi_amount', $collection->emi_amount) }}" />
                                <span class="text-danger">{{ $errors->first('emi_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="total_months" class="control-label">Total Months</label>
                                <input id="total_months" name="total_months" class="form-control"
                                    value="{{ old('total_months', $collection->total_months) }}" />
                                <span class="text-danger">{{ $errors->first('total_months', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="paid_months" class="control-label">Paid Months</label>
                                <input id="paid_months" name="paid_months" class="form-control"
                                    value="{{ old('paid_months', $collection->paid_months) }}" />
                                <span class="text-danger">{{ $errors->first('paid_months', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="emi_date" class="control-label">EMI Date</label>
                                <select id="emi_date" name="emi_date" class="form-control">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('emi_date', $collection->emi_date) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <span class="text-danger">{{ $errors->first('emi_date', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="status" class="control-label">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="pending" {{ old('status', $collection->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ old('status', $collection->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $collection->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('status', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('collections.index') }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>
            </div>
        </div>
    </form>
@endsection
