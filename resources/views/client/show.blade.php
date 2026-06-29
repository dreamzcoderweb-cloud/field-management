@php
    $title = 'Client Details'
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
<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <tr>
                        <th>Client Name</th>
                        <td>{{$client->name}}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{$client->phone}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$client->email}}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{$client->address}}</td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>{{$client->city}}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{$client->state}}</td>
                    </tr>
                    <tr>
                        <th>Contact Person</th>
                        <td>{{$client->contact_person_name}}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{$client?->category?->name}}</td>
                    </tr>
                    <tr>
                        <th>Sub Category</th>
                        <td>{{$client?->subcategory?->name}}</td>
                    </tr>
                    <tr>
                        <th>Product </th>
                        <td>{{$client?->product?->name}}</td>
                    </tr>
                    <tr>
                        <th>Bank </th>
                        <td>{{$client?->bank?->name}}</td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td>{{$client->total_amount}}</td>
                    </tr>
                    <tr>
                        <th>Paid Amount</th>
                        <td>{{$client->paid_amount}}</td>
                    </tr>
                    <tr>
                        <th>Balance Amount</th>
                        <td>{{$client->balance_amount}}</td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td>{{$client->remarks}}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{$client->created_at}}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{$client->updated_at}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($client->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
                <a href="{{ route('client.index') }}" class="btn btn-danger">Back</a>

            </div>
        </div>
    </div>
</div>
@endsection
