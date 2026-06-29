@php
    use App\Models\Settings;
    $title = 'Create Vehicle Management';
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
    <form action="{{ route('admin.vehiclemanagement.store') }}" method="post" id="formValidation">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6>Fill the following details<span class="text-danger">*</span></h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name" class="control-label">Vehicle</label>
                                <select name="vehicle_id" class="form-control">
                                    <option value="">Select Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->name }} -
                                            {{ $vehicle->vehicle_number }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('vehicle_id', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="driver_name" class="control-label">Driver Name</label>
                                <input id="driver_name" name="driver_name" class="form-control"
                                    value="{{ old('driver_name') }}" />
                                <span class="text-danger">{{ $errors->first('driver_name', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="location" class="control-label">Location</label>
                                <input id="location" name="location" class="form-control" value="{{ old('location') }}" />
                                <span class="text-danger">{{ $errors->first('location', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="distance" class="control-label">Distance <small class="text-danger">in
                                        km</small></label>
                                <input id="distance" name="distance" class="form-control" value="{{ old('distance') }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                <span class="text-danger">{{ $errors->first('distance', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="fuel" class="control-label">Fuel <small class="text-danger">in
                                        Liter</small></label>
                                <input id="fuel" name="fuel" class="form-control" value="{{ old('fuel') }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);" />
                                <span class="text-danger">{{ $errors->first('fuel', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="notes" class="control-label">Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                                <span class="text-danger">{{ $errors->first('notes', ':message') }}</span>
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
