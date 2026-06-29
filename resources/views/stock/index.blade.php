@php
    $title = 'Stock Management';
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
                {{-- <a href="{{ route('admin.stock.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Add Stock</a> --}}
            </div>
        </div>
    </div>

    {{-- <div class="card">
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
                        <a href="{{ route('admin.stock.index') }}" class="clear-search btn btn-danger">
                            &#10005;
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="card">
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-2">
                    <div class="col-md-2 col-6">
                        {{-- <label for="from_date">From</label>
                        <input type="date" id="datepicker" name="from_date" class="form-control"
                            value="{{ request('from_date') }}" max="{{ now()->format('Y-m-d') }}"> --}}
                    </div>
                    <div class="col-md-2 col-6">
                        {{-- <label for="to_date">To</label>
                        <input type="date" id="datepicker" name="to_date" class="form-control"
                            value="{{ request('to_date') }}" max="{{ now()->format('Y-m-d') }}"> --}}
                    </div>
                    <div class="col-md-3 col-6">
                        {{-- <label for="vehicle_id">Vehicle</label>
                        <select name="vehicle_id" class="form-control">
                            <option value="">Select Vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->name }} -
                                    {{ $vehicle->vehicle_number }}
                                </option>
                            @endforeach
                        </select> --}}
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
                        <a href="{{ route('admin.stock.index') }}" class="clear-search btn btn-danger">
                            &#10005;
                        </a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table id="" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($stocks) > 0)
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td class="ps-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $stock->product->name }}</td>
                                    <td>{{ $stock->quantity }}</td>
                                    <td>
                                        <a href="{{ route('admin.stockhistory.index', ['stock_id' => $stock->id]) }}"
                                            class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="More details">
                                            <i class="fa fa-info"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <center class="text-danger">No Record Found</center>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $stocks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
