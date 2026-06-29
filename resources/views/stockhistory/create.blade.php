@php
    use App\Models\Settings;
    $title = 'Add Stock';
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
    <form action="{{ route('admin.stockhistory.store') }}" method="post" id="formValidation">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6>Fill the following details<span class="text-danger">*</span></h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-12 mb-3">
                                <label for="name" class="control-label">Product</label>
                                <select name="product_id" class="form-control">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} - {{ $product->brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('product_id', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="quantity" class="control-label">Quantity</label>
                                <input id="quantity" name="quantity" class="form-control" value="{{ old('quantity') }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                <span class="text-danger">{{ $errors->first('quantity', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="amount" class="control-label">Amount</label>
                                <input id="amount" name="amount" class="form-control" value="{{ old('amount') }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                <span class="text-danger">{{ $errors->first('amount', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Add</button>
                <a href="{{ url()->previous() }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        // $(document).ready(function() {
        //     $('#formValidation').validate({
        //         rules: {
        //             name: "required",
        //             vehicle_number: "required",
        //         },
        //         messages: {
        //             name: "The vehicle name field is required.",
        //             vehicle_number: "The vehicle number field is required.",
        //         },
        //         submitHandler: function(form) {
        //             form.submit();
        //         }
        //     });
        // });
    </script>
@endsection
