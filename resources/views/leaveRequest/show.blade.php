<@php
    $title = 'Leave Requests Details'
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
<div class="row">
    <div class="col">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td class="ps-2">Employee</td>
                <td>{{$leaveRequest->user->getFullName()}}</td>
            </tr>
            <tr>
                <td class="ps-2">Leave Type</td>
                <td>{{$leaveRequest->leaveType->name}}</td>
            </tr>
            <tr>
                <td class="ps-2">From Date</td>
                <td>{{$leaveRequest->from_date}}</td>
            </tr>
            <tr>
                <td class="ps-2">To Date</td>
                <td>{{$leaveRequest->to_date}}</td>
            </tr>
            <tr>
                <td class="ps-2">Requested on</td>
                <td>{{$leaveRequest->created_at}}</td>
            </tr>
            <tr>
                <td class="ps-2">Remarks</td>
                <td>{{$leaveRequest->remarks}}</td>
            </tr>
            <tr>
                <td class="ps-2">Status</td>
                <td>
                    <div class="text-start">
                        @if($leaveRequest->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($leaveRequest->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($leaveRequest->status == 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td class="ps-2">Approver Remarks</td>
                <td>{{$leaveRequest->approver_remarks}}</td>
            </tr>
            <tr>
                <td class="ps-2">Action taken on</td>
                <td>{{$leaveRequest->approved_at}}</td>
            </tr>
            <tr>
                <td class="ps-2">Proof</td>
                <td>
                    @if(empty($leaveRequest->document))
                        <span class="badge bg-danger">No Proof</span>
                    @else
                        <img width="200" src="{{$leaveRequest->document}}" alt="proof image">
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    @if($leaveRequest->status == 'pending')
    <div class="col">
        <form action="{{route('leaveRequest.action')}}" method="post">
            @csrf
            <input type="hidden" id="id" name="id" value="{{$leaveRequest->id}}">
            <label for="approverRemarks" class="control-label">Remarks</label>
            <textarea  id="approverRemarks" name="approverRemarks" class="form-control" type="text"></textarea>

           <div class="form-group mt-3">
                    <label for="status" class="control-label">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>
            <button type="submit" class="btn btn-success btn-sm mt-3">Save</button>
        </form>
    </div>
    @endif
</div>

    </div>
    <div class="card-footer">

    </div>
</div>
@endsection
