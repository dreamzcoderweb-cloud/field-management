@php
    use App\Models\Settings;
    $title = 'Edit sale';
    $settings = Settings::first();
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

        </div>
    </div>
    <form action="{{ route('sale.update', ['sale' => $sale?->id]) }}" method="post" enctype="multipart/form-data"
        id="formValidation">
        @csrf
        @method('PUT')
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6> Sale Details</h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="product_id" class="control-label">Product</label>
                                <select id="product_id" name="product_id" class="form-select mb-3">
                                    <option value="">Please select a product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product_id', $sale) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('product_id') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="client_id" class="control-label">Client</label>
                                <select id="client_id" name="client_id" class="form-select mb-3">
                                    <option value="">Please select a client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ old('client_id', $sale) == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('client_id') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="bank_id" class="control-label">Bank</label>
                                <select id="bank_id" name="bank_id" class="form-select mb-3">
                                    <option value="">Please select a bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}"
                                            {{ old('bank_id', $sale) == $bank->id ? 'selected' : '' }}>
                                            {{ $bank->name }}
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="interest" class="control-label">Interest <small class="text-danger">(in
                                        %)</small></label>
                                <input id="interest" name="interest" class="form-control"
                                    value="{{ old('interest', $sale) }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); 
                                             if ((this.value.match(/\./g) || []).length > 1) this.value = this.value.replace(/\.+$/, ''); 
                                             if (this.value.includes('.')) {
                                                 let parts = this.value.split('.');
                                                 if (parseFloat(this.value) > 100) this.value = '100';
                                                 if (parts[1].length > 2) this.value = parts[0] + '.' + parts[1].slice(0, 2);
                                             } else {
                                                 if (parseFloat(this.value) > 100) this.value = '100';
                                             }" />
                                <span class="text-danger">{{ $errors->first('interest', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-2 mb-3">
                                <label for="product_amount" class="control-label">Product Amount </label>
                                <input id="product_amount" name="product_amount" class="form-control" value=""
                                    readonly
                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                <span class="text-danger">{{ $errors->first('product_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-2 mb-3">
                                <label for="interest_amount" class="control-label">Interest Amount </label>
                                <input id="interest_amount" name="interest_amount" class="form-control" value=""
                                    readonly
                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                <span class="text-danger">{{ $errors->first('interest_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-2 mb-3">
                                <label for="amount" class="control-label">Total Amount </label>
                                <input id="amount" name="amount" class="form-control" value="" readonly
                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                <span class="text-danger">{{ $errors->first('amount', ':message') }}</span>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="paid_advance" class="control-label">Paid Advance</label>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input paid_advance" type="radio"
                                                    name="paid_advance" id="paid_advance_yes" value="1"
                                                    {{ old('paid_advance') === '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="paid_advance_yes">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input paid_advance" type="radio"
                                                    name="paid_advance" id="paid_advance_no" value="0"
                                                    {{ old('paid_advance') === '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="paid_advance_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger">{{ $errors->first('paid_advance', ':message') }}</span>
                                </div>

                                <div class="form-group col-md-6 mb-3 advance_amount" hidden>
                                    <label for="advance_amount" class="control-label">Advance Amount </label>
                                    <input id="advance_amount" name="advance_amount" class="form-control"
                                        value="{{ old('advance_amount') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                    <span class="text-danger">{{ $errors->first('advance_amount', ':message') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="is_exchangable" class="control-label">Exchange Applicable</label>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input is_exchangable" type="radio"
                                                    name="is_exchangable" id="is_exchangable" value="1"
                                                    {{ old('is_exchangable') === '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_exchangable">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input is_exchangable" type="radio"
                                                    name="is_exchangable" id="is_exchangable" value="0"
                                                    {{ old('is_exchangable') === '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_exchangable">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger">{{ $errors->first('is_exchangable', ':message') }}</span>
                                </div>

                                <div class="form-group col-md-3 mb-3 exchangable_item" hidden>
                                    <label for="exchangable_item" class="control-label">Exchangable Item </label>
                                    <input id="exchangable_item" name="exchangable_item" class="form-control"
                                        value="{{ old('exchangable_item') }}" />
                                    <span class="text-danger">{{ $errors->first('exchangable_item', ':message') }}</span>
                                </div>

                                <div class="form-group col-md-3 mb-3 exchangable_item" hidden>
                                    <label for="exchangable_amount" class="control-label">Exchange Amount </label>
                                    <input id="exchangable_amount" name="exchangable_amount" class="form-control"
                                        value="{{ old('exchangable_amount') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                    <span
                                        class="text-danger">{{ $errors->first('exchangable_amount', ':message') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="emi_applicable" class="control-label">EMI Applicable</label>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input emi_applicable" type="radio"
                                                    name="emi_applicable" id="emi_applicable" value="1"
                                                    {{ old('emi_applicable') === '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="emi_applicable">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input emi_applicable" type="radio"
                                                    name="emi_applicable" id="emi_applicable" value="0"
                                                    {{ old('emi_applicable') === '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="emi_applicable">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger">{{ $errors->first('emi_applicable', ':message') }}</span>
                                </div>

                                <div class="form-group col-md-3 mb-3 paid_amount">
                                    <label for="paid_amount" class="control-label">Paid Amount </label>
                                    <input id="paid_amount" name="paid_amount" class="form-control"
                                        value="{{ old('paid_amount') }}" readonly
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                    <span class="text-danger">{{ $errors->first('paid_amount', ':message') }}</span>
                                </div>

                                <div class="form-group col-md-3 mb-3 balance">
                                    <label for="balance" class="control-label">Balance </label>
                                    <input id="balance" name="balance" class="form-control"
                                        value="{{ old('balance') }}" readonly
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                    <span class="text-danger">{{ $errors->first('balance', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-3 emi_month" hidden>
                                <label for="emi_month" class="control-label">EMI Duration <small class="text-danger">(in
                                        month)</small></label>
                                <input id="emi_month" name="emi_month" class="form-control"
                                    value="{{ old('emi_month') }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 2) this.value = this.value.slice(0, 2);" />
                                <span class="text-danger">{{ $errors->first('emi_month', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3 emi_amount" hidden>
                                <label for="emi_amount" class="control-label">EMI Amount <small class="text-danger">(in
                                        month)</small> </label>
                                <input id="emi_amount" name="emi_amount" class="form-control"
                                    value="{{ old('emi_amount') }}" readonly />
                                <span class="text-danger">{{ $errors->first('emi_amount', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3 emi_date" hidden>
                                <label for="emi_date" class="control-label">EMI Date
                                    <small class="text-danger">(for monthly)</small>
                                </label>
                                <select id="emi_date" name="emi_date" class="form-control">
                                    <option value="">Select EMI Date</option>
                                    @for ($i = 1; $i <= 15; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('emi_date') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <span class="text-danger">{{ $errors->first('emi_date', ':message') }}</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('product.index') }}" class="btn btn-danger" style="margin-left: 4px;">Back</a>
            </div>

        </div>

    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script defer src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        $('#formValidation').validate({
            rules: {
                product_id: "required",
                client_id: "required",
                bank_id: "required",
                interest: "required",
                paid_advance: "required",
                advance_amount: {
                    required: function(element) {
                        return $('.paid_advance').val() === '1'; // Check if paid_advance is 1
                    }
                },
                is_exchangable: "required",
                exchangable_item: {
                    required: function(element) {
                        return $('#is_exchangable').val() === '1'; // Check if is_exchangable is 1
                    }
                },
                exchangable_amount: {
                    required: function(element) {
                        return $('#is_exchangable').val() === '1'; // Check if is_exchangable is 1
                    }
                },
                emi_applicable: "required",
                emi_month: {
                    required: function(element) {
                        return $('#emi_applicable').val() === '1'; // Check if emi_applicable is 1
                    }
                },
                emi_date: {
                    required: function(element) {
                        return $('#emi_applicable').val() === '1'; // Check if emi_applicable is 1
                    }
                },
            },
            messages: {
                product_id: "Select a product",
                client_id: "Select a client",
                bank_id: "Select a bank",
                interest: "The interest feild is required",
                paid_advance: "Select a paid advance type",
                advance_amount: "The advance amount is required",
                is_exchangable: "Select a exchangable type",
                exchangable_item: "The exchangable item is required",
                exchangable_amount: "The exchangable amount is required",
                emi_applicable: "Select a EMI applicable type",
                emi_month: "The EMI duration is required",
                emi_date: "The EMI date is required",
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $('#product_id').on('change', function() {
            let id = $(this).val();
            console.log(id, "product ID");
            $.ajax({
                url: "{{ route('productAmount') }}",
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#product_amount').val(data.amount);

                    // After updating the product amount, calculate the interest
                    calculateInterest();
                },
                error: function() {
                    alert('Unable to fetch amount.');
                }
            });
        });

        $('#interest').on('input', function() {
            calculateInterest();
        });

        function calculateInterest() {
            let product_amount = parseFloat($("#product_amount").val()) || 0;
            let interest = parseFloat($("#interest").val()) || 0;

            console.log(interest, "Interest", product_amount, "Product Amount");

            let interest_amount = (product_amount * interest) / 100;
            $("#interest_amount").val(interest_amount.toFixed(2));

            let total_amount = product_amount + interest_amount;
            $("#amount").val(total_amount);
        }

        $('.paid_advance').on('change', function() {
            let is_paid_advance = $(this).val();
            console.log(is_paid_advance, "paid advance");
            if (is_paid_advance == 1) {
                $(".advance_amount").attr('hidden', false);
            } else {
                $(".advance_amount").attr('hidden', true);
            }
        });

        $('.is_exchangable').on('change', function() {
            let is_exchangeble = $(this).val();
            console.log(is_exchangeble, "exchangable item");
            if (is_exchangeble == 1) {
                $(".exchangable_item").attr('hidden', false);
            } else {
                $(".exchangable_item").attr('hidden', true);
            }
        });

        $('.emi_applicable').on('change', function() {
            let emi_applicable = $(this).val();
            console.log(emi_applicable, "emi applicable");
            if (emi_applicable == 1) {
                $(".emi_month").attr('hidden', false);
                $(".emi_amount").attr('hidden', false);
                $(".emi_date").attr('hidden', false);
            } else {
                $(".emi_month").attr('hidden', true);
                $(".emi_amount").attr('hidden', true);
                $(".emi_date").attr('hidden', true);
            }
        });

        function calculateAmounts() {
            let amount = parseFloat($("#amount").val()) || 0;
            let advance_amount = parseFloat($("#advance_amount").val()) || 0;
            let exchangable_amount = parseFloat($("#exchangable_amount").val()) || 0;

            let paid_amount = advance_amount + exchangable_amount;
            $("#paid_amount").val(paid_amount);

            let balance = amount - paid_amount;
            $("#balance").val(balance);
        }

        $("#advance_amount, #exchangable_amount").on('input', calculateAmounts);

        $('#emi_month').on('input', function() {
            let emi_month = $(this).val();
            let balance = $("#balance").val();
            console.log(emi_month, "emi month");

            let emi_amount = Math.round(balance / emi_month); // Rounds to the nearest integer
            $("#emi_amount").val(emi_amount);

        });
    });
</script>


<script>
    function validatePriceInput(input) {
        // Allow only numbers and a single decimal point
        input.value = input.value.replace(/[^0-9.]/g, ''); // Remove invalid characters
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.slice(0, -1); // Remove extra decimal points
        }
    }
</script>
@section('scripts')
@endsection
