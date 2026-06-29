@php
    use App\Models\Settings;
    $title = 'Add advance';
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
                                    <h6 class="text-primary mt-3">EMI Details</h6>
                                    <p><strong>Due month:</strong> <span
                                            class="param">{{ $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count() }}
                                            / {{ $sale->emi_month }}</span></p>
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
                                        class="param">{{ $sale?->exchangable_amount }}</span></p>
                                <p><strong>Total EMI Amount:</strong> <span
                                        class="param">{{ $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->sum('amount') ?? 0 }}</span>
                                </p>

                            </div>
                        </div>
                        <hr>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($sale->is_completed != 1)
        @if ($sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count() > 0)
            <div class="card shadow mt-3">
                <div class="card-body">
                    <div class="mt-2">
                        <center class="text-muted">
                            <h6>Unable to pay the advance now, EMI has started.</h6>
                        </center>
                    </div>
                </div>
            </div>
        @else
            <form action="{{ route('storeaddadvance', ['sale' => $sale->id]) }}" method="post"
                enctype="multipart/form-data" id="formValidation">
                @csrf
                <div class="card shadow mt-3">
                    <div class="card-body">
                        <div class="mt-2">
                            <h6> Addvance calculation Details</h6>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <div class="form-group col-md-8 mb-3 advance_amount">
                                        <label for="advance_amount" class="control-label">Advance Amount </label>
                                        <input id="advance_amount" name="advance_amount" class="form-control"
                                            value="{{ old('advance_amount') }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                        <span class="text-danger">{{ $errors->first('advance_amount', ':message') }}</span>
                                    </div>
                                    <input name="direct" value="1" id="direct" hidden>
                                    <input name="emi_month" value="{{ $sale?->emi_month }}" id="emi_month" hidden>
                                    {{-- <input name="advance" value="{{ $sale?->advance?->sum('amount') }}" id="advance" hidden> --}}
                                    <input name="balance" value="{{ $sale?->balance }}" id="balance" hidden>
                                    <input name="paid_amount" value="{{ $sale?->paid_amount }}" id="paid_amount" hidden>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row" id="payment_detail" hidden>
                                    <div class="col-md-4">
                                        Total Paid Amount : <span class="text-success" id="total_paid_amount"></span>
                                    </div>
                                    <div class="col-md-4">
                                        Balance : <span class="text-danger" id="total_balance"></span>
                                    </div>
                                    <div class="col-md-4">
                                        EMI amount<small class="text-danger">(monthly)</small> : <span class="text-success"
                                            id="emi_amount"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Add advance</button>
                    </div>

                </div>

            </form>
        @endif
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Amount</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->advance as $advance)
                            <tr>
                                <td class="ps-2">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $advance?->amount }}</td>
                                <td>{{ $advance?->created_at->format('d-m-Y') }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script defer src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        $('#formValidation').validate({
            rules: {
                advance_amount: "required",
            },
            messages: {
                advance_amount: "The advance amount is required",
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $('#advance_amount').on('input', function() {
            let advance_amount = parseFloat($(this).val()) || 0;
            // let advance = parseFloat($("#advance").val()) || 0;
            let balance = parseFloat($("#balance").val()) || 0;
            let emi_month = parseInt($("#emi_month").val()) || 1; // Avoid division by zero
            let paid_amount = parseFloat($("#paid_amount").val()) || 0;

            // console.log(advance_amount, "advance amount", advance, balance, emi_month,
            //     exchangable_amount);

            let total_paid = paid_amount + advance_amount;
            let total_balance = balance - advance_amount;
            let emi_amount = (total_balance / emi_month).toFixed(2);

            console.log(total_paid, total_balance, emi_amount);

            $("#total_paid_amount").text(total_paid);
            $("#total_balance").text(total_balance);
            $("#emi_amount").text(emi_amount);

            // Show or hide payment_detail based on advance_amount value
            if (advance_amount > 0) {
                $("#payment_detail").removeAttr("hidden");
            } else {
                $("#payment_detail").attr("hidden", true);
            }
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
