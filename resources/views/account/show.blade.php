@php
    $title = 'Account Details';
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

        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($user->img_url == null)
                            <img class="profile-user-img rounded-circle"
                                 width="100"
                                 height="100"
                                 src="{{asset('img/user.png')}}"
                                 alt="User profile picture">
                        @else
                            <img class="profile-user-img rounded-circle"
                                 width="100"
                                 height="100"
                                 src="{{asset('storage/'.$user->img_url)}}"
                                 alt="User profile picture">
                        @endif
                    </div>
                    <h5 class="text-center">
                       {{$user->user_name}}
                        @if ($user->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </h5>

                    <p class="text-muted text-center">{{$user->designation}}</p>
                    <hr />
                    <div class="container text-center">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-phoenix-primary" href="{{route('account.edit',['id'=> $user->id])}}">Edit</a>
                            </div>
                            <div class="col">
                              <form action="{{route('account.changeStatus',['id'=> $user->id])}}" method="post">
                                  @csrf
                                  @if($user->status == 'active')
                                      <button class="btn btn-phoenix-danger">Block</button>
                                  @else
                                      <button class="btn btn-phoenix-success" >UnBlock</button>
                                  @endif
                              </form>
                            </div>
                        </div>
                    </div>
                    <br />
                   {{-- <div class="col text-center">
                        <a class="btn btn-block btn-info" asp-action="ResetPasswordByAdmin" asp-route-userId="@Model.Id"><i class="fa fa-key ml-1"></i> Reset Password</a>
                    </div>--}}
                </div>
                <!-- /.card-body -->
            </div>

        </div>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h6>Login Details</h6>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td class="ps-2">User Name</td>
                                    <td>
                                       {{$user->user_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Phone Number</td>
                                    <td>
                                        {{$settings->phone_country_code.'-'.$user->phone_number}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Email</td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card card-primary mt-3">
                        <div class="card-header">
                            <h6>Personal Details</h6>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td class="ps-2">First Name</td>
                                    <td>
                                        {{$user->first_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Last Name</td>
                                    <td>
                                        {{$user->last_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Gender</td>
                                    <td>
                                        {{$user->gender}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>

@endsection
