@php
    $title = 'Edit Team'
@endphp
@section('title') {{$title}} @endsection
@extends('layout')
@section('main-content')
    <form method="post" action="{{route('team.store')}}">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="form-group row">
                    <div class="form-group col-md-5">
                        <label for="name" class="control-label">Name</label>
                        <input id="name" name="name" class="form-control" />
                        <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="description" class="control-label">Description</label>
                        <input id="description" name="description" class="form-control" />
                        <span class="text-danger">{{ $errors->first('description', ':message') }}</span>
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
