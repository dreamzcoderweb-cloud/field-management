@php
    $title = 'Holidays'
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
                <a href="{{route('holiday.create')}}" class="btn btn-phoenix-primary"><span class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
           <div class="table-responsive">
               <table id="datatable" class="table table-striped">
                   <thead>
                          <tr>
                            <th>Sl.No</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                   </thead>
                     <tbody>
                          @foreach($holidays as $holiday)
                            <tr>
                                 <td class="ps-2">
                                      {{$loop->iteration}}
                                 </td>
                                 <td>{{$holiday->name}}</td>
                                 <td>{{$holiday->date}}</td>
                                 <td>
                                        @if($holiday->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($holiday->status == 'inactive')
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                 </td>
                                 <td>
                                    <div class="d-flex">
                                        <a href="{{route('holiday.edit', $holiday->id)}}" class="btn btn-sm btn-primary me-3"><i class="fa fa-edit"></i></a>
                                        <form action="{{route('holiday.destroy', $holiday->id)}}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')" ><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                 </td>
                            </tr>
                          @endforeach
               </table>
           </div>
        </div>
    </div>
@endsection
