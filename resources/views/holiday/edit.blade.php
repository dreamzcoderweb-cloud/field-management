@php
    $title = 'Create Holiday'
@endphp
@section('title') {{$title}} @endsection
@extends('layout')
@section('main-content')
    <form method="post" action="{{route('holiday.update')}}">
        <input type="hidden" name="id" value="{{$holiday->id}}">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="form-group row">
                    <div class="form-group col-md-5">
                        <label for="name" class="control-label">Name</label>
                        <input id="name" name="name" class="form-control" value="{{$holiday->name}}"/>
                        <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="date" class="control-label">Date</label>
                        <input id="date" name="date" class="form-control" type="date"  value="{{$holiday->date}}"/>
                        <span class="text-danger">{{ $errors->first('date', ':message') }}</span>
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
