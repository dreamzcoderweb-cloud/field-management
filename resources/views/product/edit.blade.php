@php
    use App\Models\Settings;
    $title = 'Edit Product';
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
    <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow">
            <div class="card-body">


                <div class="mt-2">
                    <div class="">
                        <h6> Product Details</h6>
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="brand_id" class="control-label">Brand</label>
                                <select id="brand_id" name="brand_id" class="form-select mb-3">
                                    <option value="">Please select a brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('brand_id') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="category_id" class="control-label">Category</label>
                                <select id="category_id" name="category_id" class="form-select mb-3">
                                    <option value="">Please select a category</option>
                                    @foreach ($productcategorys as $productcategory)
                                        <option value="{{ $productcategory->id }}"
                                            @if ($product->category_id == $productcategory->id) selected @endif>{{ $productcategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="subcategory_id" class="control-label">Subcategory</label>
                                <select id="subcategory_id" name="subcategory_id" class="form-select mb-3">
                                    <option value="">Please select a varient</option>
                                    @foreach ($productsubcategorys as $productsubcategory)
                                        <option value="{{ $productsubcategory->id }}"
                                            @if ($product->subcategory_id == $productsubcategory->id) selected @endif>
                                            {{ $productsubcategory->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('subcategory_id') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="designation" class="control-label">name</label>
                                <input id="name" name="name" class="form-control"
                                    value="{{ old('name', $product->name) }}" />
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="price" class="control-label">Price</label>
                                <input id="price" name="price" class="form-control"
                                    value="{{ old('price', $product->price) }}" oninput="validatePriceInput(this)"
                                    placeholder="Enter price (e.g., 123.45)" />
                                <span class="text-danger">{{ $errors->first('price', ':message') }}</span>
                            </div>
                        </div>

                        <h6 class="mt-2">Voucher</h6>

                        <div class="form-group row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="english" class="control-label">English Pdf</label>
                                <input type="file" class="form-control mb-3" name="english" accept="application/pdf">
                                <span class="text-danger">{{ $errors->first('english') }}</span>
                                @if (isset($product->english))
                                    <embed src="{{ url('public/product/voucher/' . $product->english) }}" type="application/pdf"
                                        width="100%" height="250px">
                                @endif
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="tamil" class="control-label">Tamil Pdf</label>
                                <input type="file" class="form-control mb-3" name="tamil" accept="application/pdf">
                                <span class="text-danger">{{ $errors->first('tamil') }}</span>
                                @if (isset($product->tamil))
                                    <embed src="{{ url('public/product/voucher/' . $product->tamil) }}" type="application/pdf"
                                        width="100%" height="250px">
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Edit</button>
                <a href="{{ route('productList') }}" class="btn btn-danger" style="margin-left: 4px;">Back</a>

            </div>

        </div>

    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#brand_id').change(function() {
            let brandId = $(this).val();
            console.log(brandId);
            // Clear the subcategory dropdown
            $('#category_id').empty().append(
                '<option value="">Please select a Category</option>');

            if (brandId) {
                $.ajax({
                    url: '{{ route('admin.brandscategory') }}',
                    type: 'GET',
                    data: {
                        brandId: brandId,
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            data.forEach(function(category) {
                                $('#category_id').append(
                                    `<option value="${category.id}">${category.name}</option>`
                                );
                            });
                        }
                    },
                    error: function() {
                        alert('Unable to fetch categories.');
                    }
                });
            }
        });
        $('#category_id').change(function() {
            let categoryId = $(this).val();
            // Clear the subcategory dropdown
            $('#subcategory_id').empty().append(
                '<option value="">Please select a subcategory</option>');

            if (categoryId) {
                $.ajax({
                    url: '{{ route('get.subcategories', ':categoryId') }}'.replace(
                        ':categoryId', categoryId),
                    type: 'GET',
                    success: function(data) {
                        if (data.length > 0) {
                            data.forEach(function(subcategory) {
                                $('#subcategory_id').append(
                                    `<option value="${subcategory.id}">${subcategory.name}</option>`
                                );
                            });
                        }
                    },
                    error: function() {
                        alert('Unable to fetch subcategories.');
                    }
                });
            }
        });
    });

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

