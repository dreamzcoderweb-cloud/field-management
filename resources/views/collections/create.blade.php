@php
    $title = 'Create Collection';
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

    <form action="{{ route('collections.store') }}" method="post">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6>Collection Details</h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-12 mb-3">
                                <label for="sale_id" class="control-label">Client Product Sale</label>
                                <select id="sale_id" name="sale_id" class="form-control">
                                    <option value="">-- Select Client Product --</option>
                                    @foreach ($sales as $sale)
                                        <option value="{{ $sale->id }}"
                                            data-total="{{ $sale->balance }}"
                                            data-paid="0"
                                            data-balance="{{ $sale->balance }}"
                                            data-emi="{{ $sale->emi_amount }}"
                                            data-date="{{ $sale->emi_date }}"
                                            data-months="{{ $sale->emi_month }}"
                                            {{ old('sale_id') == $sale->id ? 'selected' : '' }}>
                                            {{ $sale?->client?->name }} - {{ $sale?->product?->name }} - EMI Balance: {{ $sale->balance }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('sale_id', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="total_amount" class="control-label">Total Amount</label>
                                <input id="total_amount" name="total_amount" class="form-control"
                                    value="{{ old('total_amount') }}" />
                                <span class="text-danger">{{ $errors->first('total_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="paid_amount" class="control-label">Paid Amount</label>
                                <input id="paid_amount" name="paid_amount" class="form-control"
                                    value="{{ old('paid_amount', 0) }}" />
                                <span class="text-danger">{{ $errors->first('paid_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="balance_amount" class="control-label">Balance Amount</label>
                                <input id="balance_amount" name="balance_amount" class="form-control"
                                    value="{{ old('balance_amount') }}" />
                                <span class="text-danger">{{ $errors->first('balance_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="emi_amount" class="control-label">EMI Amount</label>
                                <input id="emi_amount" name="emi_amount" class="form-control"
                                    value="{{ old('emi_amount') }}" />
                                <span class="text-danger">{{ $errors->first('emi_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="total_months" class="control-label">Total Months</label>
                                <input id="total_months" name="total_months" class="form-control"
                                    value="{{ old('total_months') }}" />
                                <span class="text-danger">{{ $errors->first('total_months', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="emi_date" class="control-label">EMI Date</label>
                                <select id="emi_date" name="emi_date" class="form-control">
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ old('emi_date') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <span class="text-danger">{{ $errors->first('emi_date', ':message') }}</span>
                            </div>

                            <input type="hidden" name="paid_months" value="{{ old('paid_months', 0) }}">
                            <input type="hidden" name="status" value="{{ old('status', 'pending') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('collections.index') }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        function fillSaleAmounts() {
            const selected = $('#sale_id option:selected');
            if (!selected.val()) {
                return;
            }
            $('#total_amount').val(selected.data('total') || 0);
            $('#paid_amount').val(selected.data('paid') || 0);
            $('#balance_amount').val(selected.data('balance') || 0);
            $('#emi_amount').val(selected.data('emi') || 0);
            $('#total_months').val(selected.data('months') || 0);
            $('#emi_date').val(selected.data('date') || 1);
        }

        $('#sale_id').on('change', fillSaleAmounts);
        fillSaleAmounts();
    </script>
@endsection
