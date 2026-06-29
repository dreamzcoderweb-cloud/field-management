@php
    use App\Models\Settings;
    $title = 'Create Product Category';
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
    <form action="{{ route('productcategory.store') }}" method="post" id="productCategoryForm">
        @csrf
        <div class="card shadow">
            <div class="card-body">


                <div class="mt-2">

                    <h6>Product Category</h6>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="brand_id" class="control-label">Brand</label>
                                <select id="brand_id" name="brand_id" class="form-control">
                                    <option value="">-- Select a Brand --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('brand_id', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="name" class="control-label">Name</label>
                                <input id="name" name="name" class="form-control" value="{{ old('name') }}" />
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('productcategory.index') }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>


            </div>

        </div>

    </form>
@endsection

@section('scripts')
    <script>
        $("#productCategoryForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                name: {
                    required: "The name field is required.",
                    minlength: "The name must be at least 3 characters long."
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endsection
