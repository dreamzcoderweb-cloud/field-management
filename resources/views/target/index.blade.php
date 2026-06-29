@php
    $title = 'Targets';
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
                <a href="{{ route('admin.target.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create Target</a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <div class="col-12 col-md-12 col-sm-12 col-xl-12 mb-3">
            <div class="card shadow radius-10">
                <div class="card-body">
                    <form action="">
                        <div class="row g-2 align-items-end">

                            <div class="col-12 col-md-2">
                                <input id="search" name="search" placeholder="Search here" class="form-control"
                                    value="{{ request('search') }}" />
                            </div>

                            <div class="col-6 col-md-2">
                                <select name="team_id" class="form-select" id="team_id" onchange="this.form.submit()">
                                    <option value="">Select Team</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}"
                                            {{ request('team_id') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 col-md-2">
                                <select name="userId" class="form-select" id="userId" onchange="this.form.submit()">
                                    <option value="">Select Employee</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('userId') == $user->id ? 'selected' : '' }}>
                                            {{ $user->user_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 col-md-2">
                                <select name="status" class="form-select" id="status" onchange="this.form.submit()">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Processing
                                    </option>
                                    <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Completed
                                    </option>
                                    <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Incompleted
                                    </option>
                                </select>
                            </div>

                            <div class="col-6 col-md-2">
                                <label for="from" class="control-label">From</label>
                                <input id="from" name="from" type="date" max="{{ now()->format('Y-m-d') }}"
                                    onchange="form.submit()" class="form-control" value="{{ request('from') }}" />
                            </div>

                            <div class="col-6 col-md-2">
                                <label for="to" class="control-label">To</label>
                                <input id="to" name="to" type="date" max="{{ now()->format('Y-m-d') }}"
                                    onchange="form.submit()" class="form-control" value="{{ request('to') }}" />
                            </div>

                            <div class="col-md-10"></div>

                            <div class="col-12 col-md-2 d-flex gap-2">
                                <button class="btn btn-success w-100" type="submit">Filter</button>
                                <a class="btn btn-danger w-100" href="{{ route('admin.target.index') }}">Clear</a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Target Name</th>
                            <th>Team</th>
                            <th>Employee</th>
                            <th>Duration</th>
                            {{-- <th>Incentive</th> --}}
                            <th>Target</th>
                            <th>Created At</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($targets))
                            @foreach ($targets as $target)
                                <tr>
                                    <td class="ps-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $target?->name }}</td>
                                    <td>{{ isset($target?->team) ? $target?->team?->name : '-' }}</td>
                                    @php
                                        $popoverContent = '<ul class="mb-0">';
                                        foreach ($target?->targetproduct as $product) {
                                            $popoverContent .=
                                                '<li>' .
                                                e($product?->incentive) .
                                                '<br>' .
                                                // e($product?->updated_at->format('d-m-Y')) .
                                                // '<br>' .
                                                ($product?->is_completed ? '✅ Done' : '❌ Not Yet') .
                                                '</li>';
                                        }
                                        $popoverContent .= '</ul>';
                                    @endphp

                                    <td>
                                        {{ $target?->user?->user_name }}
                                        <span class="bi bi-info-circle text-primary fs-1 ms-1" role="button" tabindex="0"
                                            title="{{ $target->name }}" data-bs-toggle="popover" data-bs-trigger="focus"
                                            data-bs-html="true" data-bs-placement="top"
                                            data-bs-content="{{ $popoverContent }}">
                                        </span>
                                        <br>
                                        <span class="badge bg-success">{{ $target?->user?->designation }}</span>
                                    </td>

                                    <td>{{ $target?->from->format('d-m-Y') }} /
                                        {{ $target?->to->format('d-m-Y') }}
                                    </td>
                                    {{-- <td>{{ $target->incentive }}</td> --}}
                                    @php
                                        $isCompleted = App\Models\Targetproduct::where('target_id', $target->id)
                                            ->where('is_completed', 1)
                                            ->get();
                                    @endphp
                                    <td>{{ count($isCompleted) }} / {{ count($target->targetproduct) }}</td>
                                    <td>{{ $target->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($target->status == 1)
                                            <span class="badge bg-warning">processing</span>
                                        @elseif($target->status == 2)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-danger">Incompleted</span>
                                        @endif
                                    </td>
                                    {{-- <td>
                                    <a href="{{ route('sale.show', $sale->id) }}" class="btn btn-primary btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Full details">
                                        <i class="fa fa-info"></i>
                                    </a>
                                    <a href="{{ route('getaddadvance', $sale->id) }}" class="btn btn-secondary btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="View Advance Payments">
                                        <i class="fa fa-list"></i>
                                    </a>                                   
                                    <form id="delete-form-{{ $sale->id }}"
                                        action="{{ route('sale.destroy', $sale->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete sale detail"
                                            onclick="confirmDelete({{ $sale->id }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td> --}}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">
                                    <center class="text-danger">No record found</center>
                                </td>
                            </tr>
                        @endif
                        {{ $targets->links('pagination::bootstrap-5') }}
                    </tbody>
                </table>
            </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            popoverTriggerList.forEach(function(popoverTriggerEl) {
                new bootstrap.Popover(popoverTriggerEl)
            });
        });
    </script>
@endsection
