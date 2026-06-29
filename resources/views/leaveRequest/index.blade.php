<@php
    $title = 'Leave Requests'
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

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class=" table-responsive">
            <table class="table table-bordered table-striped" id="datatable1" >
                <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Proof</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Requested on</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leaveRequests as $key => $leaveRequest)
                    <tr>
                        <td class="ps-2">{{$key + 1}}</td>
                        <td>{{$leaveRequest->user->getFullName()}}</td>
                        <td>{{$leaveRequest->leaveType->name}} </td>
                        <td>
                            @if(empty($leaveRequest->document))
                                <span class="badge bg-danger">No Proof</span>
                            @else
                                <img src="{{asset($leaveRequest->document)}}" alt="" width="100px">
                            @endif
                        </td>
                        <td>{{$leaveRequest->from_date}}</td>
                        <td>{{$leaveRequest->to_date}}</td>
                        <td>{{$leaveRequest->created_at}}</td>
                        <td>{{$leaveRequest->remarks}}</td>
                        <td>
                            <div class="text-center">
                                @if($leaveRequest->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($leaveRequest->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($leaveRequest->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </div>
                        </td>
                        <td class="pe-2">
                            <a href="{{route('leaveRequest.show', $leaveRequest->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>

        $(document).ready(function () {

            var table = $('#datatable1').DataTable({
                autoWidth: false,
                lengthChange: true,
                responsive: false,
                scrollX: true,
                //buttons: ["copy", "csv", "excel", "pdf", "print"]
            });

            table.buttons().container()
                .appendTo('#datatable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
