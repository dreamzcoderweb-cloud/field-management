@php
    $title = 'Change Password'
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

    <form action="{{route('account.changePassword')}}" method="post">
        @csrf
        <div class="card shadow">
            <div class="form-group row card-body">
                <div class="form-group col-md-3">
                    <label for="oldPassword" class="control-label">Old Password</label>
                    <input id="oldPassword" name="oldPassword" class="form-control" />
                    <span class="text-danger">{{ $errors->first('oldPassword', ':message') }}</span>
                </div>
                <div class="form-group col-md-2">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" name="password" class="form-control" />
                    <span class="text-danger">{{ $errors->first('password', ':message') }}</span>
                </div>
                <div class="form-group col-md-2">
                    <label for="confirmPassword" class="control-label">Confirm Password</label>
                    <input id="confirmPassword" name="confirmPassword" class="form-control" />
                    <span class="text-danger">{{ $errors->first('confirmPassword', ':message') }}</span>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <input type="submit" value="Change" class="btn btn-primary" />
                </div>
            </div>
        </div>

    </form>
@endsection
