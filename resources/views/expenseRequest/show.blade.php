@php
    $title = 'Expense Request Details'
@endphp
@section('title')
    {{$title}}
@endsection
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
                        <tr>
                            <td class="ps-2">Employee</td>
                            <td>{{$expenseRequest->user->getFullName()}}</td>
                        </tr>
                        <tr>
                            <td class="ps-2">Expense Type</td>
                            <td>{{$expenseRequest->expenseType->name}}</td>
                        </tr>
                        <tr>
                            <td class="ps-2">Amount</td>
                            <td>{{$expenseRequest->amount}}</td>
                        </tr>
                        <tr>
                            <td class="ps-2">Expense Date</td>
                            <td>{{$expenseRequest->created_at}}</td>
                        </tr>
                        <tr>
                            <td class="ps-2">Remarks</td>
                            <td>{{$expenseRequest->remarks}}</td>
                        </tr>
                        <tr>
                            <td class="ps-2">Status</td>
                            <td>
                                @if($expenseRequest->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($expenseRequest->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($expenseRequest->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-2">Approved On</td>
                            <td>{{$expenseRequest->approved_at == null ? 'N/A' : $expenseRequest->approved_at->format(Constants::DateTimeFormat) ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <td class="ps-2">Approved Amount</td>
                            <td>{{$expenseRequest->approved_amount == null ? 'N/A' : $expenseRequest->approved_amount}}</td>
                        </tr>
                        <tr>
                            <td class="ps-2">Proof</td>
                            <td>
                                @if(empty($expenseRequest->document))
                                    <span class="badge bg-danger">No Proof</span>
                                @else
                                    <img width="200" src="{{$expenseRequest->document}}" alt="proof image"></td>
                            @endif
                        </tr>
                    </table>
                </div>
                @if($expenseRequest->status == 'pending')
                    <div class="col">
                        <form action="{{route('expenseRequest.action', $expenseRequest->id)}}" method="post">
                            <input type="hidden" id="id" name="id" value="{{$expenseRequest->id}}">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                            </div>
                            <div class="mb-3" id="approveDiv">
                                <label for="approvedAmount" class="form-label">Approved Amount</label>
                                <input name="approvedAmount" id="approvedAmount" type="number" class="form-control"/>
                                <span class="text-danger">@error('approvedAmount') {{$message}} @enderror</span>
                            </div>
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea name="remarks" id="remarks" cols="30" rows="5"
                                          class="form-control"></textarea>
                                <span class="text-danger">@error('remarks') {{$message}} @enderror</span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#status').change(function () {
                if ($(this).val() == 'approved') {
                    $('#approveDiv').show();
                } else {
                    $('#approveDiv').hide();
                }
            });
        });
    </script>

@endsection
