@php
    use App\Models\Settings;$title = 'Employee Details';
    $settings = Settings::first();
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


    <div class="row mb-3 fs--1">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
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

                    <h3 class="profile-username text-center">{{$user->user_name}}</h3>

                    <p class="text-muted text-center">{{$user->designation}}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-8">
                                    Primary sales target
                                </div>
                                <div class="col-4">
                                    <p class="text-primary">{{$settings->currency_symbol.''.($user->primary_sales_target ?? 0)}}</p>
                                </div>
                            </div>

                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-8">
                                    Secondary sales target
                                </div>
                                <div class="col-4">
                                    <p class="text-primary">{{$settings->currency_symbol.''.($user->secondary_sales_target ?? 0)}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-8">
                                    Available leaves
                                </div>
                                <div class="col-4">
                                    <p class="text-primary">{{$user->available_leaves}} days</p>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="row justify-content-evenly">
                        <div class="col">
                            <a class="btn btn-primary btn-block" href="{{route('employee.edit',['id'=> $user->id])}}">Edit</a>
                        </div>
                        <div class="col">
                            <form action="{{route('employee.changeStatus',["id"=> $user->id])}}" method="post">
                                @csrf
                                @if($user->status == 'active')
                                    <button type="submit" class="btn btn-block btn-danger"
                                            onclick="confirm('Are you sure you want to block the user?')">Block
                                    </button>
                                @else
                                    <button class="btn btn-block btn-success"
                                            onclick="confirm('Are you sure you want to unblock the user?')">UnBlock
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- Attendance Type -->
            <div class="card card-primary mt-3">
                <div class="card-header">
                    <h6 class="mt-2">Attendance Info</h6>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong>Attendance Type</strong>
                    <p class="text-muted">
                        {{$user->attendance_type}}
                    </p>
                    <hr>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Device Info -->
            <div class="card card-primary mt-3">
                <div class="card-header">
                    <h6 class="mt-2"><i class="fa fa-mobile-alt"></i> Device Info</h6>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if ($user->userDevice != null)
                        <strong>Brand</strong>
                        <p class="text-muted">
                            {{$user->userDevice->brand}}
                        </p>

                        <hr>
                        <strong>Model</strong>
                        <p class="text-muted">
                            {{$user->userDevice->model}}
                        </p>
                        <hr>

                        <strong>Device Type</strong>

                        <p class="text-muted">
                            {{$user->userDevice->device_type}}
                        </p>
                        <hr>

                        <strong>Sdk Version</strong>

                        <p class="text-muted">
                            {{$user->userDevice->sdk_version}}
                        </p>
                        <hr>

                        <strong>Last Reported Location</strong>

                        <p class="text-muted">
                            @if($user->userDevice->latitude == null || $user->userDevice->longitude == null)
                                Location not available
                            @else
                                <a href="{{"https://www.google.com/maps/search/?api=1&query=".$user->userDevice->latitude.",".$user->userDevice->longitude}}"
                                   target="_blank"><i class="fa fa-share"></i> Open in maps</a>
                            @endif
                        </p>

                        <strong>Last Reported On</strong>

                        <p class="text-muted">
                            {{$user->userDevice->updated_at}}
                        </p>

                        {{--   @*<a class="btn btn-danger btn-block"
                                onclick="confirm('Are you sure you want to revoke the device?')"><i class="fa fa-ban"></i>
                               Revoke Device</a>*@--}}
                    @else
                        <p>Device not configured</p>
                    @endif

                </div>
                <!-- /.card-body -->
            </div>

        </div>
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h6><i class="fa fa-lock"></i> Login Details</h6>
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
                                        {{$user->phone_number}}
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

                    <div class="card card-primary mt-2">
                        <div class="card-header">
                            <h6><i class="fa fa-user-alt"></i> Personal Details</h6>
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
                                <tr>
                                    <td class="ps-2">DOB</td>
                                    <td>
                                        {{$user->dob ?? 'N/A'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Unique Id</td>
                                    <td>
                                        {{$user->unique_id ?? 'N/A'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Alternate Phone Number</td>
                                    <td>
                                        {{$user->alternate_phone_number ?? 'N/A'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Address</td>
                                    <td>
                                        {{$user->address ?? 'N/A'}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card card-primary mt-2">
                        <div class="card-header">
                            <h6><i class="fa fa-user-tie"></i> Work Details</h6>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped ">
                                <tbody>
                                <tr>
                                    <td class="ps-2">Reporting Manager</td>
                                    <td>
                                        {{$managerName->getFullName() ?? 'N/A'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Shift</td>
                                    <td>
                                        {{$user->shift->title}}
                                        <div class="d-flex justify-content-start">
                                            <h3 class="badge {{$user->shift->sunday?'bg-success' : 'bg-secondary'}} me-2">
                                                Sun</h3>
                                            <h3 class="badge {{$user->shift->monday?'bg-success' : 'bg-secondary'}} me-2">
                                                Mon</h3>
                                            <h3 class="badge {{$user->shift->tuesday?'bg-success' : 'bg-secondary'}} me-2">
                                                Tue</h3>
                                            <h3 class="badge {{$user->shift->wednesday?'bg-success' : 'bg-secondary'}} me-2">
                                                Wed</h3>
                                            <h3 class="badge {{$user->shift->thursday?'bg-success' : 'bg-secondary'}} me-2">
                                                Thu</h3>
                                            <h3 class="badge {{$user->shift->friday?'bg-success' : 'bg-secondary'}} me-2">
                                                Fri</h3>
                                            <h3 class="badge {{$user->shift->saturday?'bg-success' : 'bg-secondary'}} me-2">
                                                Sat</h3>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Team</td>
                                    <td>
                                        {{$user->team->name ?? 'N/A'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Date of joining</td>
                                    <td>
                                        {{$user->date_of_joining ?? 'N/A'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Base salary</td>
                                    <td>
                                        {{$settings->currency_symbol.''.($user->base_salary ?? 0)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-2">Designation</td>
                                    <td>
                                        {{$user->designation ?? 'N/A'}}
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
