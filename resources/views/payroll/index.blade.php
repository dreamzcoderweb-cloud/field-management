@php
    use App\Models\Settings;
    $title = 'Payroll';
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
            {{-- <div class="float-end">
                <a href="{{route('employee.create')}}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div> --}}
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <div class="col-12 col-md-12 col-sm-12 col-xl-12 mb-3">
            <div class="card shadow radius-10">
                <div class="card-body">
                    <form action="">
                        {{-- <div class="d-flex align-items-center"> --}}
                        <div class="row">
                            <div class="form-group col-md-4 ml-2">
                                {{-- <label for="search" class="control-label">Search</label> --}}
                                <input id="search" name="search" placeholder="search here" class="form-control"
                                    value="{{ request('search') }}" />
                            </div>
                            <div class="form-group col-md-3">
                                {{-- <label for="search" class="control-label">Select Month</label> --}}
                                <select name="year" class="form-control" onchange="form.submit()">
                                    <option value="">Select Year</option>
                                    @for ($year = 2020; $year <= \Carbon\Carbon::now()->year; $year++)
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                {{-- <label for="search" class="control-label">Search</label> --}}
                                <select name="month" class="form-control" onchange="form.submit()">
                                    <option value="">Select Month</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                            {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                            <!-- Full month name -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-success" type="submit">Generate</button>
                                <a class="btn btn-danger" href="{{ route('admin.payroll.index') }}">Clear</a>
                            </div>
                        </div>
                        {{-- </div> --}}
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
                            <th>#</th>
                            <th>User</th>
                            <th>Base Salary</th>
                            <th>Present Days</th>
                            <th>Sundays</th>
                            <th>Leaves Taken</th>
                            <th>Paid Leaves</th>
                            <th>Unpaid Leaves</th>
                            <th>Final Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payrollData as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['user_name'] }}</td>
                                <td>{{ number_format($data['base_salary'], 2) }}</td>
                                <td>{{ $data['present_days'] }}</td>
                                <td>{{ $data['sundays'] }}</td>
                                <td>{{ $data['total_leaves_taken'] }}</td>
                                <td>{{ $data['paid_leaves_used'] }}</td>
                                <td>{{ $data['unpaid_leaves'] }}</td>
                                <td><strong>{{ number_format($data['calculated_salary'], 2) }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-danger">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    {{ $payrollData->links('pagination::bootstrap-5') }}

                </table>
            </div>
        </div>
    </div>
@endsection
