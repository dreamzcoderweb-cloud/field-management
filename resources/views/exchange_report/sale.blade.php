@php
    $title = 'Exchange Sales Report';
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
                        <input type="date" id="datepicker" name="from" class="form-control"
                            value="{{ request('from') }}" max="{{ now()->format('Y-m-d') }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="to">To</label>
                        <input type="date" id="datepicker" name="to" class="form-control"
                            value="{{ request('to') }}" max="{{ now()->format('Y-m-d') }}" onchange="this.form.submit()">
                    </div>
                    {{-- <div class="col-md-2 col-6">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" onchange="form.submit()">
                            <option value="">Select status</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div> --}}
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
                            <a href="{{ route('admin.exchangesale.index') }}" class="clear-search btn btn-danger">
                                &#10005;
                            </a>
                        </div>
                        <div class="col-auto d-grid">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success"
                                formaction="{{ route('admin.exchangesale.export') }}" formmethod="POST">
                                Generate Report
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Product</th>
                            <th>Client</th>
                            <th>Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>EMI Applicable</th>
                            <th>Exchangable</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td class="ps-2">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $sale?->product?->name }}</td>
                                <td>{{ $sale?->client?->name }} <br>
                                    {{ $sale?->client?->mobile }}
                                </td>
                                <td>{{ $sale->amount }}</td>
                                <td>{{ $sale->paid_amount }}</td>
                                <td>{{ $sale->balance }}</td>
                                <td>
                                    @if ($sale->emi_applicable == 1)
                                        <span class="badge bg-success">Yes</span>
                                        <br>
                                        <span>Month :
                                            {{ $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count() }}
                                            / {{ $sale?->emi_month }}</span>
                                        <br>
                                        <span>Amount : {{ $sale?->emi_amount }}</span>
                                        <br>
                                        <span>Due Date : {{ $sale?->emi_date }}</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($sale->is_exchangable == 1)
                                        <span class="badge bg-success">Yes</span>
                                        <br>
                                        <span>Item : {{ $sale->exchangable_item }}</span>
                                        <br>
                                        <span>Amount : {{ $sale->exchangable_amount }}</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($sale?->is_completed == 1)
                                        <span class="badge bg-success" style="cursor: context-menu;">Completed</span>
                                    @else
                                        <span class="badge bg-warning" style="cursor: context-menu;">On Going</span>
                                    @endif
                                </td>
                                <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.exchangesale.show', $sale?->id) }}"
                                        class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Full details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


