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
                <h4 class="mt-2">{{ $title }} of {{ $stockhistories[0]?->product?->name }}</h4>
            </div>
        </div>
        <div class="col">
            <div class="float-end">
                {{-- <a href="{{ route('admin.stock.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Add Stock</a> --}}
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-2">
                    <input type="hidden" name="stock_id" value="{{ $stock_id }}">
                    <div class="col-md-2 col-6">
                        <label for="from_date">From</label>
                        <input type="date" id="datepicker" onchange="form.submit()" name="from_date" class="form-control"
                            value="{{ request('from_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="to_date">To</label>
                        <input type="date" id="datepicker" onchange="form.submit()" name="to_date" class="form-control"
                            value="{{ request('to_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 col-6">
                        <label for="type">Type</label>
                        <select name="type" class="form-control" onchange="form.submit()">
                            <option value="">Select type</option>
                            <option value="1" {{ request('type') == 1 ? 'selected' : '' }}>
                                IN
                            </option>
                            <option value="2" {{ request('type') == 2 ? 'selected' : '' }}>
                                OUT
                            </option>
                            <option value="3" {{ request('type') == 3 ? 'selected' : '' }}>
                                RETURN
                            </option>
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
                        <a href="{{ route('admin.stockhistory.index', ['stock_id' => $stock_id]) }}"
                            class="clear-search btn btn-danger">
                            <i class="fas fa-times"></i>
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
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Date</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($stockhistories) > 0)
                            @foreach ($stockhistories as $stockhistory)
                                <tr>
                                    <td class="ps-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $stockhistory->product->name }}</td>
                                    <td>{{ $stockhistory->quantity }}</td>
                                    <td>{{ $stockhistory->amount }}</td>
                                    <td>
                                        @if ($stockhistory->type == 1)
                                            <span class="badge bg-success">IN</span>
                                        @elseif($stockhistory->type == 2)
                                            <span class="badge bg-danger">OUT</span>
                                        @else
                                            <span class="badge bg-warning">Return</span>
                                        @endif
                                    </td>
                                    <td>{{ $stockhistory->created_at->format('d-m-Y') }}</td>
                                    {{-- <td>
                                        <a href="" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit details">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a href="" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete details">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">
                                    <center class="text-danger">No Record Found</center>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $stockhistories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
