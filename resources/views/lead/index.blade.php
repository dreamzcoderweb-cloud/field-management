@php
    $title = 'Leads';
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <style>
        .widget-search .clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #aaa;
        }

        .widget-search input:focus+.clear-search,
        .widget-search input:not(:empty)+.clear-search {
            color: #000;
        }
    </style>
    {{-- <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{ $title }}</h4>
            </div>
        </div>
        <div class="col">
        <div class="float-end">
            <a href="{{route('task.create')}}" class="btn btn-phoenix-primary"><span
                    class="fa fa-plus-circle fa-fw me-2"></span>Create Task</a>
        </div>
    </div>
    </div> --}}

    {{-- Tab Navigation --}}
    {{-- <ul class="nav nav-pills mb-4 justify-content-start">
        <li class="nav-item">
            <a class="nav-link fw-semibold px-4 py-2 rounded-pill 
                {{ request()->routeIs('admin.task.index') ? 'active bg-primary text-white shadow' : 'text-primary border border-primary' }}"
                href="{{ route('admin.task.index') }}">
                <i class="fas fa-tasks me-2"></i> Tasks
            </a>
        </li>
        <li class="nav-item ms-2">
            <a class="nav-link fw-semibold px-4 py-2 rounded-pill 
                {{ request()->routeIs('admin.task.create') ? 'active bg-primary text-white shadow' : 'text-primary border border-primary' }}"
                href="{{ route('admin.task.create') }}">
                <i class="fas fa-plus-circle me-2"></i> Create
            </a>
        </li>
    </ul> --}}

    <div class="card">
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-2">
                    <div class="col-md-2 col-6">
                        <label for="from_date">From</label>
                        <input type="date" id="datepicker" name="from_date" class="form-control" onchange="form.submit()"
                            value="{{ request('from_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="to_date">To</label>
                        <input type="date" id="datepicker" name="to_date" class="form-control" onchange="form.submit()"
                            value="{{ request('to_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" onchange="form.submit()">
                            <option value="">Select status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Cold</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Warm</option>
                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Hot</option>
                            <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Convert to customer
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="productId">Product</label>
                        <select name="productId" class="form-control" onchange="form.submit()">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('productId') == $product->id ? 'selected' : '' }}>{{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
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
                        <a href="{{ route('admin.lead.index') }}" class="clear-search btn btn-danger">
                            &#10005;
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            {{-- <th>Type</th> --}}
                            <th>Enquiry details</th>
                            {{-- <th>Mobile</th> --}}
                            <th style="width: 10%">Address</th>
                            <th>Next Follow Up</th>
                            <th>Market Price / Estimation Price</th>
                            <th>Product</th>
                            <th>Enquiry Taken</th>
                            <th>Created at</th>
                            <th>Current Status</th>
                            {{-- <th>Status</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($leads) > 0)
                            @foreach ($leads as $lead)
                                <tr>
                                    <td class="ps-2">{{ $loop->iteration }}</td>
                                    <td>{{ $lead?->name }} <br> {{ $lead->mobile }}</td>
                                    <td style="width: 10%">{{ $lead?->address }} <br> {{ $lead?->city }}</td>
                                    <td>{{ $lead?->follow_up_date?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $lead?->market_price ?? 0 }} / {{ $lead->estimation_amount ?? 0 }}</td>
                                    <td>{{ $lead?->product?->name }}</td>
                                    <td>{{ isset($lead?->user?->user_name) ? $lead?->user?->user_name : $lead?->user?->first_name . '' . $lead?->user?->last_name }}
                                    </td>
                                    <td>{{ $lead?->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($lead->status == 1)
                                            <span class="badge bg-primary">Cold</span>
                                        @elseif ($lead->status == 2)
                                            <span class="badge bg-warning">Warm</span>
                                        @elseif ($lead->status == 3)
                                            <span class="badge bg-danger">Hot</span>
                                        @else
                                            <span class="badge bg-success">Convert to customer</span>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <div class="form-group">
                                        <select id="status" name="status" class="form-control"
                                            {{ $lead->status == 4 ? 'disabled' : '' }} data-id="{{ $lead?->id }}">
                                            <option value="1" {{ $lead->status == '1' ? 'selected' : '' }}>
                                                Cold
                                            </option>
                                            <option value="2" {{ $lead->status == '2' ? 'selected' : '' }}>Warm
                                            </option>
                                            <option value="3" {{ $lead->status == '3' ? 'selected' : '' }}>Hot
                                            </option>
                                            <option value="4" {{ $lead->status == '4' ? 'selected' : '' }}>Convert to customer
                                            </option>
                                        </select>
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">
                                    <center>No Records Found.</center>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $leads->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('change', '#status', function() {
            let id = $(this).data('id');
            let status = $(this).val();
            console.log(id, "id");
            $.ajax({
                url: "{{ route('admin.lead.create') }}",
                type: "GET",
                data: {
                    id: id,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        notyf.success('Status Updated!!!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        window.location.reload();
                    } else {
                        notyf.error('Something wentwrong', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        window.location.reload();
                    }
                }
            });
        });
    </script>
@endsection

