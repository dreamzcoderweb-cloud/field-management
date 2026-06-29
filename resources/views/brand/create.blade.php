@php
    use App\Models\Settings;
    $title = 'Create Brand';
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
    <form action="{{ route('admin.brand.store') }}" method="post" id="productCategoryForm">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6>Brand</h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-12 mb-3">
                                <label for="name" class="control-label">Brand Name</label>
                                <input id="name" name="name" class="form-control" value="{{ old('name') }}" />
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.brand.index') }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>


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
