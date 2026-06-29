@php
    $title = 'Sales';
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
                <a href="{{ route('sale.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create Sale</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-2">
                    <div class="col-md-2 col-6">
                        <label for="from">From</label>
                        <input type="date" id="datepicker" name="from" class="form-control"
                            value="{{ request('from') }}" max="{{ now()->format('Y-m-d') }}" onchange="form.submit()">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="to">To</label>
                        <input type="date" id="datepicker" name="to" class="form-control"
                            value="{{ request('to') }}" max="{{ now()->format('Y-m-d') }}" onchange="form.submit()">
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" onchange="form.submit()">
                            <option value="">Select status</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <label for="product_id">Product</label>
                        <select name="product_id" class="form-control" onchange="form.submit()">
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
                        <select name="team_id" class="form-control" onchange="form.submit()">
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
                            <a href="{{ route('sale.index') }}" class="clear-search btn btn-danger">
                                &#10005;
                            </a>
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
                            <th>Loan Bank</th>
                            <th>Interest <small class="text-danger">in %</small> </th>
                            <th>Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            {{-- <th>EMI Applicable</th> --}}
                            <th>Exchangable</th>
                            <th>Referrence</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sales) > 0)
                            @foreach ($sales as $sale)
                                <tr>
                                    <td class="ps-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $sale?->product?->name }}</td>
                                    <td>{{ $sale?->client?->name }} <br>
                                        {{ $sale?->client?->mobile }}
                                    </td>
                                    <td>{{ isset($sale?->bank) ? $sale->bank->name : '-' }}</td>
                                    <td>{{ $sale?->interest != '' ? $sale?->interest : '-' }}</td>
                                    <td>{{ $sale->amount }}</td>
                                    <td>{{ $sale->paid_amount }}</td>
                                    <td>{{ $sale->balance }}</td>
                                    {{-- <td>
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
                                    </td> --}}
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
                                    @php
                                        $employee = App\Models\User::with('team')
                                            ->where('id', $sale?->client?->created_by_id)
                                            ?->first();
                                    @endphp
                                    <td>
                                        @if ($sale?->client?->employee != '')
                                            {{ $sale?->client?->employee?->user_name }}
                                            {{-- {{ $sale?->client?->employee?->last_name }} --}}
                                            @if (isset($sale?->client?->employee?->team))
                                                <br>
                                                <span
                                                    class="badge bg-success">{{ $sale?->client?->employee?->team?->name }}</span>
                                            @endif
                                        @else
                                            -
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

                                        <a href="{{ route('sale.show', $sale->id) }}" class="btn btn-primary btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Full details">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        <a href="{{ route('getaddadvance', $sale->id) }}" class="btn btn-secondary btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View Advance Payments">
                                            <i class="fa fa-list"></i>
                                        </a>
                                        {{-- <a href="{{ route('sale.show', $sale->id) }}" class="btn btn-warning btn-sm"><i
                                            class="fa fa-eye"></i> </a> --}}
                                        {{-- <a href="{{ route('sale.edit', $sale->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a> --}}
                                        <form id="delete-form-{{ $sale->id }}"
                                            action="{{ route('sale.destroy', $sale->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete sale detail"
                                                onclick="confirmDelete({{ $sale->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12">
                                    <center><span class="text-danger">No data found</span></center>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $sales->links() }}
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script>
        function changeStatus(id) {
            $.ajax({
                'csrf-token': '{{ csrf_token() }}',
                url: "{{ route('product.changeStatus') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    notyf.success(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(saleId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This will delete all related records permanently!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + saleId).submit();
                }
            });
        }
    </script>
@endsection

