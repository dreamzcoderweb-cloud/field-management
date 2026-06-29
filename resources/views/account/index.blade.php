@php
    $title = 'User Accounts';
    $settings = \App\Models\Settings::first();
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
            <div class="float-end">
                <a href="{{route('account.create')}}" class="btn btn-phoenix-primary"><span class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>
                        Sl.No
                    </th>
                    <th>
                       User Name
                    </th>
                    <th>
                      First Name
                    </th>
                    <th>
                       Last Name
                    </th>
                    <th>
                       Role
                    </th>
                    <th>
                       Gender
                    </th>
                    <th>
                        Phone Number
                    </th>
                    <th>
                        Designation
                    </th>
                    <th>
                        Status
                    </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="ps-2">
                            {{$loop->iteration}}
                        </td>
                        <td>
                            {{$user->user_name}}
                        </td>
                        <td>
                            {{$user->first_name}}
                        </td>
                        <td>
                            {{$user->last_name}}
                        </td>
                        <td>
                            {{$user->roles->first()['name']}}
                        </td>
                        <td>
                            {{$user->gender}}
                        </td>
                        <td>
                            {{$settings->phone_country_code.'-'.$user->phone_number}}
                        </td>
                        <td>
                            {{$user->designation}}
                        </td>
                        <td>
                            @if($user->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif

                        </td>
                        <td class="d-flex">
                            <a href="{{route('account.show', $user->id)}}" class="btn btn-sm btn-primary btn-icon me-1"><span class="fa fa-eye"></span></a>
                            <a href="{{route('account.edit', $user->id)}}" class="btn btn-sm btn-primary btn-icon"><span class="fa fa-edit"></span></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
