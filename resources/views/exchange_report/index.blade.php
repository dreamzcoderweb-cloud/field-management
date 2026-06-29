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
                            <div class="form-group">
                                <label for="period">Period</label>
                                <input type="month" class="form-control" id="period" name="period" required/>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-4">Generate Report</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
