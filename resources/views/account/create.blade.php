@php
    $title = 'Create User'
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
    <form action="{{route('account.store')}}" method="post">
        @csrf
        <div class="card shadow mt-3">
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h6>Login Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-4">
                                <label for="userName" class="control-label">User Name</label>
                                <input id="userName" name="userName" class="form-control" value="{{old('userName')}}"/>
                                <span class="text-danger">{{ $errors->first('userName', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password" class="control-label">Password</label>
                                <input id="password" name="password" class="form-control"/>
                                <span class="text-danger">{{ $errors->first('password', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="confirmPassword" class="control-label">Confirm Password</label>
                                <input id="confirmPassword" name="confirmPassword" class="form-control"/>
                                <span class="text-danger">{{ $errors->first('confirmPassword', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-2 mt-3">
                                <label for="roleId" class="control-label">Role</label>
                                <select id="roleId" name="roleId" class="form-select mb-3">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option
                                            {{old('roleId') == $role->id ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('roleId', ':message') }}</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card card-primary mt-3">
                    <div class="card-header">
                        <h6>Personal Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="firstName" class="control-label">First Name</label>
                                <input id="firstName" name="firstName" class="form-control"
                                       value="{{old('firstName')}}"/>
                                <span class="text-danger">{{ $errors->first('firstName', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="lastName" class="control-label">Last Name</label>
                                <input id="lastName" name="lastName" class="form-control" value="{{old('lastName')}}"/>
                                <span class="text-danger">{{ $errors->first('lastName', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="gender" class="control-label">Gender</label>
                                <select id="gender" name="gender" class="form-select mb-3">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="unknown">Unknown</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('gender', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="designation" class="control-label">Designation</label>
                                <input id="designation" name="designation" class="form-control"
                                       value="{{old('designation')}}"/>
                                <span class="text-danger">{{ $errors->first('designation', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phoneNumber" class="control-label">Phone Number</label>
                                <input id="phoneNumber" name="phoneNumber" type="number" class="form-control"
                                       value="{{old('phoneNumber')}}"/>
                                <span class="text-danger">{{ $errors->first('phoneNumber', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control"
                                       value="{{old('email')}}"/>
                                <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>

    </form>

@endsection
