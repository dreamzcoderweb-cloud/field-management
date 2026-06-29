@php
    $title = 'Visits'
@endphp
@section('title')
    {{$title}}
@endsection
@extends('layout')
@section('main-content')
    <div class="row">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{$title}}</h4>
            </div>
        </div>
        <div class="col">
            <form method="get" action="{{route('visit.index')}}">
                <div class="row m-0">
                    <div class="col">
                        <div class="input-group date">
                            <input type="date" class="form-control datetimepicker-input" id="date" name="date" value="{{ $date ?? date("Y-m-d")}}" />
                        </div>
                    </div>
                    <div class="col">
                        <select class="form-control" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}' id="employeeId" name="employeeId">
                            <option value="">Select an employee</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}" {{$employeeId != null && $employee->id == $employeeId ? 'selected' : ''}}>{{$employee->first_name.' '.$employee->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable">
                    <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Employee</th>
                        <th>Client</th>
                        <th>Remarks</th>
                        <th>Image</th>
                        <th>Address</th>
                        <th>Visited On</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($visits as $visit)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$visit->remarks}}</td>
                            <td>{{$visit->client->name}}</td>
                            <td>{{$visit->remarks}}</td>
                            <td>
                                <img src="{{asset($visit->img_url)}}" alt="" width="100px" height="100px">
                            </td>
                            <td>
                                @if(empty($visit->address))
                                    <a href="{{'https://www.google.com/maps/search/?api=1&query='.$visit->latitude.','.$visit->longitude}}" target="_blank"><i class="fa fa-share"></i> Open in maps</a>
                                @else
                                {{$visit->address}}
                                @endif
                            </td>
                            <td>{{$visit->created_at}}</td>
                            <td>
                                <form action="{{route('visit.destroy', $visit->id)}}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you you want to delete?');"><span class="fa fa-trash fa-fw"></span></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
