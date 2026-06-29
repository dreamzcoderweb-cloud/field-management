@php
    $title = 'Outstanding Customer Report';
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
    </div>
    <div class="card">
        <div class="card-body">
            <form action="" method="GET">
                @csrf
                <div class="row g-2 justify-content-center">
                    <div class="col-md-2 col-6">
                        <label for="from">From</label>
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}"
                            max="{{ now()->format('Y-m-d') }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="to">To</label>
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}"
                            max="{{ now()->format('Y-m-d') }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="product_id">Product</label>
                        <select name="product_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="team_id">Team</label>
                        <select name="team_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ request('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="search">Search</label>
                        <input type="text" value="{{ request('search') }}" class="form-control" name="search"
                            placeholder="Search">
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto d-grid">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="col-auto d-grid">
                            <label>&nbsp;</label>
                            <a href="{{ route('admin.outstandingreport.index') }}" class="clear-search btn btn-danger">
                                &#10005;
                            </a>
                        </div>
                        <div class="col-auto d-grid">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success"
                                formaction="{{ route('admin.outstandingreport.export') }}" formmethod="POST">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Product</th>
                            <th>Client</th>
                            <th>Team</th>
                            <th>Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td class="ps-2">{{ $loop->iteration }}</td>
                                <td>{{ $sale?->product?->name }}</td>
                                <td>{{ $sale?->client?->name }} <br>{{ $sale?->client?->mobile }}</td>
                                <td>{{ $sale?->client?->employee?->team?->name }}</td>
                                <td>{{ number_format($sale->amount, 0, '.', '') }}</td>
                                <td>{{ number_format($sale->paid_amount, 0, '.', '') }}</td>
                                <td>{{ number_format($sale->balance, 0, '.', '') }}</td>
                                <td>
                                    @if ($sale?->is_completed == 1)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-warning">On Going</span>
                                    @endif
                                </td>
                                <td>{{ $sale->created_at?->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
