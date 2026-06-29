@php
    use App\Models\Settings;
    $title = 'Create Vehicle';
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
    <form action="{{ route('admin.vehicle.store') }}" method="post" id="formValidation">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6>Fill the following details<span class="text-danger">*</span></h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name" class="control-label">Name</label>
                                <input id="name" name="name" class="form-control" value="{{ old('name') }}" />
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="vehicle_number" class="control-label">Vehicle Number</label>
                                <input id="vehicle_number" name="vehicle_number" class="form-control"
                                    value="{{ old('vehicle_number') }}" />
                                <span class="text-danger">{{ $errors->first('vehicle_number', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.vehicle.index') }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>


            </div>

        </div>

    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#formValidation').validate({
                rules: {
                    name: "required",
                    vehicle_number: "required",
                },
                messages: {
                    name: "The vehicle name field is required.",
                    vehicle_number: "The vehicle number field is required.",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
