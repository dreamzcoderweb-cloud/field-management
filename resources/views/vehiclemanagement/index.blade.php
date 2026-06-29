@php
    $title = 'Vehicle Management';
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
            <div class="float-end">
                <a href="{{ route('admin.vehiclemanagement.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create Vehicle Management</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-2">
                    <div class="col-md-2 col-6">
                        <label for="from_date">From</label>
                        <input type="date" id="datepicker" name="from_date" class="form-control"
                            value="{{ request('from_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="to_date">To</label>
                        <input type="date" id="datepicker" name="to_date" class="form-control"
                            value="{{ request('to_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 col-6">
                        <label for="vehicle_id">Vehicle</label>
                        <select name="vehicle_id" class="form-control">
                            <option value="">Select Vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->name }} -
                                    {{ $vehicle->vehicle_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-6">
                        <label for="search">Search</label>
                        <input type="text" value="{{ request('search') }}" class="form-control" name="search"
                            placeholder="Search">
                    </div>
                    <div class="col-md-1 col-6 d-grid">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1 col-6 d-grid">
                        <label>&nbsp;</label>
                        <a href="{{ route('admin.vehiclemanagement.index') }}" class="clear-search btn btn-danger">
                            &#10005;
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Location</th>
                            <th>Fuel <small class="text-danger">in Liter</small> </th>
                            <th>Distance <small class="text-danger">in Km</small></th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiclemanagements as $vehiclemanagement)
                            <tr>
                                <td class="ps-2">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $vehiclemanagement?->vehicle?->name }} <br>
                                    {{ $vehiclemanagement?->vehicle?->vehicle_number }}</td>
                                <td>{{ $vehiclemanagement->driver_name }}</td>
                                <td>{{ $vehiclemanagement->location }}</td>
                                <td>{{ $vehiclemanagement->fuel }}</td>
                                <td>{{ $vehiclemanagement->distance }}</td>
                                <td>{{ $vehiclemanagement->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.vehiclemanagement.edit', $vehiclemanagement->id) }}"
                                        class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Edit details">
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.vehiclemanagement.destroy', $vehiclemanagement?->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $vehiclemanagements->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
