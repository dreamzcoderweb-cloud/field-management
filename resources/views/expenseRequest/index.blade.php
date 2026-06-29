@php
    $title = 'Expense Requests'
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
       <div class="table-responsive">
           <table class="table table-striped" id="datatable1">
               <thead>
               <tr>
                   <th>Sl.no</th>
                   <th>Employee</th>
                   <th>Type</th>
                   <th>Amount</th>
                   <th>Proof</th>
                   <th>Expense Date</th>
                   <th>Remarks</th>
                   <th>Status</th>
                   <th>Actions</th>
               </tr>
               </thead>
               <tbody>
               @foreach($expenseRequests as $expenseRequest)
                   <tr>
                       <td class="ps-2">{{$expenseRequest->id}}</td>
                       <td>{{$expenseRequest->user->getFullName()}}</td>
                       <td>{{$expenseRequest->expenseType->name}}</td>
                       <td>{{$expenseRequest->amount}}</td>
                       <td>
                           @if(empty($expenseRequest->document))
                               <span class="badge bg-danger">No Proof</span>
                           @else
                               <img src="{{asset($expenseRequest->document)}}" alt="" width="100px">
                           @endif
                       </td>
                       <td>{{$expenseRequest->created_at}}</td>
                       <td>{{$expenseRequest->remarks}}</td>
                       <td>
                           <div class="text-start">
                               @if($expenseRequest->status == 'pending')
                                   <span class="badge bg-warning">Pending</span>
                               @elseif($expenseRequest->status == 'approved')
                                   <span class="badge bg-success">Approved</span>
                               @elseif($expenseRequest->status == 'rejected')
                                   <span class="badge bg-danger">Rejected</span>
                               @endif
                           </div>
                       </td>
                       <td class="pe-2">
                           <a href="{{route('expenseRequest.show', $expenseRequest->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
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
