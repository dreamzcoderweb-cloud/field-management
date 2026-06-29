@php
    $title = 'Create Leave Type';
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <form id="clientForm" method="post" action="{{ route('client.update', $client->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow">
            <div class="card-body">
                <div class="form-group row">
                    <div class="form-group col-md-5 mb-3">
                        <label for="name" class="control-label">Name</label>
                        <input id="name" name="name" class="form-control" value="{{ old('name', $client) }}" />
                        <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="email" class="control-label">Email</label>
                        <input id="email" email="email" class="form-control" value="{{ old('email', $client) }}" />
                        <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="address" class="control-label">address</label>
                        <input id="address" name="address" class="form-control" value="{{ old('address', $client) }}" />
                        <span class="text-danger">{{ $errors->first('address', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="phone" class="control-label">phone</label>
                        <input id="phone" name="phone" class="form-control" value="{{ old('phone', $client) }}" />
                        <span class="text-danger">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="latitude" class="control-label">latitude</label>
                        <input id="latitude" name="latitude" class="form-control"
                            value="{{ old('latitude', $client) }}" />
                        <span class="text-danger">{{ $errors->first('latitude', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="longitude" class="control-label">longitude</label>
                        <input id="longitude" name="longitude" class="form-control"
                            value="{{ old('longitude', $client) }}" />
                        <span class="text-danger">{{ $errors->first('longitude', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="contact_person_name" class="control-label">contact_person_name</label>
                        <input id="contact_person_name" name="contact_person_name" class="form-control"
                            value="{{ old('contact_person_name', $client) }}" />
                        <span class="text-danger">{{ $errors->first('contact_person_name', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="radius" class="control-label">radius</label>
                        <input id="radius" name="radius" class="form-control" value="{{ old('radius', $client) }}" />
                        <span class="text-danger">{{ $errors->first('radius', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="city" class="control-label">city</label>
                        <input id="city" name="city" class="form-control" value="{{ old('city', $client) }}" />
                        <span class="text-danger">{{ $errors->first('city', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="remarks" class="control-label">remarks</label>
                        <input id="remarks" name="remarks" class="form-control" value="{{ old('remarks', $client) }}" />
                        <span class="text-danger">{{ $errors->first('remarks', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="image_url" class="control-label">Image_url</label>
                        <input id="image_url" name="image_url" class="form-control"
                            value="{{ old('image_url', $client) }}" />
                        <span class="text-danger">{{ $errors->first('image_url', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5 mb-3">
                        <label for="bank" class="control-label">Bank</label>
                        <select id="bank" name="bank_id" class="form-control chosen-select">
                             <option value="" disabled selected>Select Bank</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}" 
                                    {{ isset($client->bank_id) && $bank->id == $client->bank_id ? 'selected' : '' }}>
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('bank_id', ':message') }}</span>
                    </div>
                    

                   

                    <div class="row">
                        <div class="form-group col-md-4 mb-3">
                            <label for="category" class="control-label">Category</label>
                            <select id="category" name="category_id" class="form-control chosen-select">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ isset($client->category_id) && $category->id == $client->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group col-md-4">
                            <label for="subcategory" class="control-label">Subcategory</label>
                            <select id="subcategory" name="subcategory_id" class="form-control chosen-select">
                                <option value="" disabled selected>Select Subcategory</option>
                                @if ($client->subcategory_id)
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" 
                                            {{ isset($client->subcategory_id) && $subcategory->id == $client->subcategory_id ? 'selected' : '' }}>
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    
                        <div class="form-group col-md-4">
                            <label for="product" class="control-label">Product</label>
                            <select id="product" name="product_id" class="form-control chosen-select">
                                <option value="" disabled selected>Select Product</option>
                                @if ($client->product_id)
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" 
                                            {{ isset($client->product_id) && $product->id == $client->product_id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="total_amount" class="control-label">Total Amount</label>
                            <input type="number" min="1" id="total_amount" name="total_amount"
                                class="form-control" readonly value="{{ old('total_amount', $client) }}" />
                            <span class="text-danger">{{ $errors->first('total_amount', ':message') }}</span>
                        </div>
                        <div class="form-group col-md-4  mb-3">
                            <label for="paid_amount" class="control-label">Paid Amount</label>
                            <input type="number" min="1" id="paid_amount" name="paid_amount"
                                class="form-control" value="{{ old('paid_amount', $client) }}" />
                            <span class="text-danger">{{ $errors->first('paid_amount', ':message') }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="balance_amount" class="control-label">Balance Amount</label>
                            <input type="number" min="1" id="balance_amount" name="balance_amount"
                                class="form-control" readonly  value="{{ old('balance_amount', $client) }}" />
                            <span class="text-danger">{{ $errors->first('balance_amount', ':message') }}</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="{{ route('client.index') }}" class="btn btn-danger">Back</a>

                </div>
            </div>
        </div>
    </form>
@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js "></script>
<script defer src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<script>
    $(document).ready(function () {
        // Initialize Chosen
        $(".chosen-select").chosen();

        // Validate Form
        $('#clientForm').validate({
            ignore: [], // Ensures hidden fields (like chosen-select) are included
            rules: {
                category_id: {
                    required: true,
                },
                subcategory_id: {
                    required: true,
                },
                product_id: {
                    required: true,
                },
                bank_id: {
                    required: true,
                },
                total_amount: {
                    required: true,
                    number: true,
                    min: 1,
                },
                paid_amount: {
                    required: true,
                    number: true,
                    min: 0,
                },
                balance_amount: {
                    required: true,
                    number: true,
                    min: 0,
                },
            },
            messages: {
                category_id: {
                    required: 'Please select a category.',
                },
                bank_id: {
                    required: 'Please select a Bank.',
                },
                subcategory_id: {
                    required: 'Please select a category.',
                },
                product_id: {
                    required: 'Please select a category.',
                },
                total_amount: {
                    required: 'Total amount is required.',
                    number: 'Please enter a valid number.',
                    min: 'Total amount must be at least 1.',
                },
                paid_amount: {
                    required: 'Paid amount is required.',
                    number: 'Please enter a valid number.',
                    min: 'Paid amount cannot be less than 0.',
                },
                balance_amount: {
                    required: 'Balance amount is required.',
                    number: 'Please enter a valid number.',
                    min: 'Balance amount cannot be less than 0.',
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('text-danger');
                if (element.hasClass("chosen-select")) {
                    // Append error to Chosen container
                    element.next('.chosen-container').append(error);
                } else {
                    element.closest('.form-group').append(error);
                }
            },
            highlight: function (element) {
                if ($(element).hasClass("chosen-select")) {
                    $(element).next('.chosen-container').find('.chosen-single').addClass('is-invalid');
                } else {
                    $(element).addClass('is-invalid');
                }
            },
            unhighlight: function (element) {
                if ($(element).hasClass("chosen-select")) {
                    $(element).next('.chosen-container').find('.chosen-single').removeClass('is-invalid');
                } else {
                    $(element).removeClass('is-invalid');
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        // Trigger validation when Chosen fields change
        $(".chosen-select").on("change", function () {
            $(this).valid();
        });
    });
</script>

 <script>
    $(document).ready(function() {
        function calculateBalance() {
            let totalAmount = parseFloat($('#total_amount').val()) || 0;
            let paidAmount = parseFloat($('#paid_amount').val()) || 0;

            if (paidAmount > totalAmount) {
                $('#paid_error').text('Paid amount cannot be greater than Total amount.');
                $('#paid_amount').val(''); // Clear invalid Paid Amount
                $('#balance_amount').val(totalAmount); // Reset Balance to Total Amount
            } else {
                $('#paid_error').text(''); // Clear error message
                let balanceAmount = totalAmount - paidAmount;
                $('#balance_amount').val(balanceAmount > 0 ? balanceAmount : 0); // Ensure non-negative balance
            }
        }

        // Attach change and input event listeners
        $('#total_amount, #paid_amount').on('input', function() {
            calculateBalance();
        });
    });
</script>

<script>
    $(document).ready(function() {
    // Initialize Chosen
    $(".chosen-select").chosen({
        width: "100%",
        no_results_text: "No results found!",
        placeholder_text_single: "Select an option"
    });

    // Fetch Subcategories Based on Category
    $('#category').on('change', function() {
        let categoryId = $(this).val();
        $('#subcategory').html('<option value="">Select Subcategory</option>').trigger("chosen:updated");
        $('#product').html('<option value="">Select Product</option>').trigger("chosen:updated");
        $('#price').val('');

        if (categoryId) {
            $.ajax({
                url: '{{ route('getSubcategories') }}',
                type: 'GET',
                data: { category_id: categoryId },
                success: function(data) {
                    data.forEach(function(subcategory) {
                        $('#subcategory').append(
                            `<option value="${subcategory.id}">${subcategory.name}</option>`
                        );
                    });
                    $('#subcategory').trigger("chosen:updated");
                },
            });
        }
    });

    // Fetch Products Based on Subcategory
    $('#subcategory').on('change', function() {
        let categoryId = $('#category').val();
        let subcategoryId = $(this).val();
        $('#product').html('<option value="">Select Product</option>').trigger("chosen:updated");
        $('#price').val('');

        if (subcategoryId) {
            $.ajax({
                url: '{{ route('getProducts') }}',
                type: 'GET',
                data: { category_id: categoryId, subcategory_id: subcategoryId },
                success: function(data) {
                    data.forEach(function(product) {
                        $('#product').append(
                            `<option value="${product.id}">${product.name}</option>`
                        );
                    });
                    $('#product').trigger("chosen:updated");
                },
            });
        }
    });

    // Fetch Product Price Based on Selected Product
    $('#product').on('change', function() {
        let productId = $(this).val();
        $('#total_amount').val('');

        if (productId) {
            $.ajax({
                url: '{{ route('getProductPrice') }}',
                type: 'GET',
                data: { product_id: productId },
                success: function(data) {
                    $('#total_amount').val(data.price);
                },
            });
        }
    });
});

</script>