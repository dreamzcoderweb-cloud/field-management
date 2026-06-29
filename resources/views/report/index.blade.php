@php
    $title = 'Reports'
@endphp
@section('title')
    {{$title}}
@endsection
@section('styles')
@endsection
@extends('layout')
@section('main-content')
    <div class="row mb-4">
        <div class="col text-start">
            <h4 class="mt-4">{{$title}}</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        @foreach(['Attendance', 'Visit', 'Leave', 'Expense'] as $report)
            <div class="col-sm-6 col-lg-4 col-xl-3 mt-3">
                <div class="card h-100">
                    <div class="card-header text-center bg-light">
                        <h4 class="card-title mb-0">{{ $report }} Report</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <form action="{{ route('report.get'. $report . 'Report') }}" method="post" class="mt-auto">
                            @csrf

                            @if($report === 'Attendance')
                                <div class="form-group">
                                    <label for="from_date">From Date</label>
                                    <input type="date" class="form-control" id="from_date" name="from_date"/>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="to_date">To Date</label>
                                    <input type="date" class="form-control" id="to_date" name="to_date"/>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="employeeId">Employee</label>
                                    <select class="form-control" id="employeeId" name="employeeId">
                                        <option value="">All employees</option>
                                        @foreach(($employees ?? []) as $employee)
                                            <option value="{{$employee->id}}" {{($employeeId ?? null) == $employee->id ? 'selected' : ''}}>
                                                {{$employee->first_name.' '.$employee->last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="period">Period (optional)</label>
                                    <input type="month" class="form-control" id="period" name="period"/>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="period">Period</label>
                                    <input type="month" class="form-control" id="period" name="period" required/>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary btn-block mt-4">Generate Report</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Sales reports
        <div class="col-sm-6 col-lg-4 col-xl-3 mt-3">
            <div class="card h-100">
                <div class="card-header text-center bg-light">
                    <h4 class="card-title mb-0">Salesman Wise Report</h4>
                </div>
                <div class="card-body d-flex flex-column">
                    <form action="{{ route('report.getSalesmanWiseReport') }}" method="post" class="mt-auto">
                        @csrf

                        <div class="form-group">
                            <label for="from_date_salesman_wise">From Date</label>
                            <input type="date" class="form-control" id="from_date_salesman_wise" name="from_date"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="to_date_salesman_wise">To Date</label>
                            <input type="date" class="form-control" id="to_date_salesman_wise" name="to_date"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="salesman_id">Salesman</label>
                            <select class="form-control" id="salesman_id" name="salesman_id">
                                <option value="">All salesmen</option>
                                @foreach(($employees ?? []) as $employee)
                                    <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-4">Generate Report</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4 col-xl-3 mt-3">
            <div class="card h-100">
                <div class="card-header text-center bg-light">
                    <h4 class="card-title mb-0">Sales Report Excel</h4>
                </div>
                <div class="card-body d-flex flex-column">
                    <form action="{{ route('report.getSalesExcelReport') }}" method="post" class="mt-auto">
                        @csrf

                        <div class="form-group">
                            <label for="from_date_sales">From Date</label>
                            <input type="date" class="form-control" id="from_date_sales" name="from_date"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="to_date_sales">To Date</label>
                            <input type="date" class="form-control" id="to_date_sales" name="to_date"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="salesman_id_excel">Salesman</label>
                            <select class="form-control" id="salesman_id_excel" name="salesman_id">
                                <option value="">All salesmen</option>
                                @foreach(($employees ?? []) as $employee)
                                    <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-4">Generate Report</button>
                    </form>
                </div>
            </div>
        </div> --}}

    </div>
@endsection

