@php
    $title = 'Shifts'
@endphp
@section('title') {{$title}} @endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{$title}}</h4>
            </div>
        </div>
        <div class="col">
            <div class="float-end">
                <a href="{{route('shift.create')}}" class="btn btn-phoenix-primary"><span class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div>
        </div>
    </div>

    <div class="card mt-2">
        <dic class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Shift Days</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($shifts as $shift)
                        <tr>
                            <td class="ps-2">{{$loop->iteration}}</td>
                            <td>{{$shift->title}}</td>
                            <td>{{$shift->start_time}}</td>
                            <td>{{$shift->end_time}}</td>
                            <td>
                                <div class="d-flex justify-content-start">
                                    <h3 class="badge {{$shift->sunday?'bg-success' : 'bg-secondary'}} me-2">Sun</h3>
                                    <h3 class="badge {{$shift->monday?'bg-success' : 'bg-secondary'}} me-2">Mon</h3>
                                    <h3 class="badge {{$shift->tuesday?'bg-success' : 'bg-secondary'}} me-2">Tue</h3>
                                    <h3 class="badge {{$shift->wednesday?'bg-success' : 'bg-secondary'}} me-2">Wed</h3>
                                    <h3 class="badge {{$shift->thursday?'bg-success' : 'bg-secondary'}} me-2">Thu</h3>
                                    <h3 class="badge {{$shift->friday?'bg-success' : 'bg-secondary'}} me-2">Fri</h3>
                                    <h3 class="badge {{$shift->saturday?'bg-success' : 'bg-secondary'}} me-2">Sat</h3>
                                </div>
                            </td>
                            <td>
                                @if($shift->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                               <div class="d-flex">
                                   <a href="{{route('shift.edit', $shift->id)}}" class="btn btn-sm btn-primary me-2"><span class="fa fa-edit fa-fw"></span></a>
                                   <a href="{{route('shift.destroy', $shift->id)}}" class="btn btn-sm btn-danger me-2"  onclick="return confirm('Are you sure you want to delete?')"><span class="fa fa-trash fa-fw"></span></a>
                               </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </dic>
    </div>
@endsection
