@php
    use App\Models\Settings;$title = 'Employees';
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
            <div class="float-end">
                <a href="{{route('employee.create')}}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <div class="col-12 col-md-4 col-sm-12 col-xl-3 mb-3">
            <div class="card shadow radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Employees</p>
                            <h4 class="mb-0 text-pink">
                                {{$employees->count()}}
                            </h4>
                        </div>
                        <div class="ms-auto fs-2 text-pink">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-sm-12 col-xl-3 mb-3">
            <div class="card shadow radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Active Employees</p>
                            <h4 class="mb-0 text-success">
                                {{$employees->where('status','active')->count()}}
                            </h4>
                        </div>
                        <div class="ms-auto fs-2 text-success">
                            <i class="bi bi-person-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-sm-12 col-xl-3 mb-3">
            <div class="card shadow radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Inactive Employees</p>
                            <h4 class="mb-0 text-warning">
                                {{$employees->where('status','inactive')->count()}}
                            </h4>
                        </div>
                        <div class="ms-auto fs-2 text-warning">
                            <i class="bi bi-person-dash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Name</th>
                        <th>User Name</th>
                        <th>Attendance Type</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Team</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td class="ms-2">{{$employee->id}}</td>
                            <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                            <td>{{$employee->user_name}}</td>
                            <td>{{$employee->attendance_type}}</td>
                            <td>{{$settings->phone_country_code.'-'.$employee->phone_number}}</td>
                            <td>{{$employee->gender}}</td>
                            <td>{{$employee->team->name}}</td>
                            <td>
                                @if($employee->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('employee.show', $employee->id )}}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-eye"></i> </a>
                                    <a href="{{ route('admin.task.index', ['employee_id' => $employee->id]) }}"
                                        class="btn btn-sm btn-primary"><i class="fa fa-tasks"></i> </a>
                                    @php
                                        $staffVehicle =
                                            App\Models\Staffvehicle::where('user_id', $employee->id)->get();
                                    @endphp
                                    @if (count($staffVehicle) > 0)
                                        <a href="{{ route('admin.staffvehicle.index', ['userId' => $employee->id]) }}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-motorcycle"></i></a>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
