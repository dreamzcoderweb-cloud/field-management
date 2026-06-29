@php
    use App\Models\Settings;
    $title = 'Staff Vehicle';
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
                <h4 class="mt-2">{{ $staffvehicle?->user?->user_name }} | Staff Vehicle</h4>
            </div>
        </div>
        <div class="col">

        </div>
    </div>
    <form action="{{ route('admin.staffvehicle.update', $staffvehicle->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow">
            <div class="card-body">

                <div class="mt-2">
                    <h6>Update Staff Vehicle</h6>
                    <div class="card-body">

                        <div class="form-group row">

                            <div class="form-group col-md-4 mb-3">
                                <label for="bike_model" class="control-label">Bike Model</label>
                                <input id="bike_model" name="bike_model" class="form-control"
                                    value="{{ old('bike_model', $staffvehicle) }}" />
                                <span class="text-danger">{{ $errors->first('bike_model', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="number" class="control-label">Number</label>
                                <input id="number" name="number" class="form-control"
                                    value="{{ old('number', $staffvehicle) }}" />
                                <span class="text-danger">{{ $errors->first('number', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="current_kilometer" class="control-label">Current Kilometer</label>
                                <input id="current_kilometer" name="current_kilometer" class="form-control"
                                    value="{{ old('current_kilometer', $staffvehicle) }}" />
                                <span class="text-danger">{{ $errors->first('current_kilometer', ':message') }}</span>
                            </div>
                            <div class="row justify-content-center">
                                <div class="form-group col-md-4 mb-3">
                                    <label for="kilometer_image" class="control-label">Kilometer Imgae</label>
                                    <input type="file" name="kilometer_image" class="form-control" accept="image/*" />
                                    <span class="text-danger">{{ $errors->first('kilometer_image', ':message') }}</span>
                                    @if (isset($staffvehicle->kilometer_image))
                                        <img src="{{ url('public/staff/vehicle/' . $staffvehicle->kilometer_image) }}"
                                            alt="Img-KM" style="width: 400px;height: 400px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-center mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.staffvehicle.index', ['userId' => $staffvehicle->user_id]) }}"
                    style="margin-left: 4px;" class="btn btn-danger">Back</a>
            </div>

        </div>

    </form>
@endsection

