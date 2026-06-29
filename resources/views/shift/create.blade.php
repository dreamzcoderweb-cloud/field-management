@php
    $title = 'Create Shift'
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

    <div class="card mt-2">
        <form action="{{route('shift.store')}}" method="POST">
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter shift name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                    </div>
                    <div class="col-md-6">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" placeholder="Enter shift description"
                               class="form-control">
                        <span class="text-danger">{{ $errors->first('description', ':message') }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="startTime">Start Time</label>
                        <input type="time" name="startTime" id="startTime" class="form-control">
                        <span class="text-danger">{{ $errors->first('startTime', ':message') }}</span>
                    </div>
                    <div class="col-md-6">
                        <label for="endTime">End Time</label>
                        <input type="time" name="endTime" id="endTime" class="form-control">
                        <span class="text-danger">{{ $errors->first('endTime', ':message') }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <label class="control-label">Shift Days</label>
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <input type="checkbox" class="btn-check" id="sunday" name="sunday" autocomplete="off">
                        <label class="btn btn-outline-primary" for="sunday">Sunday</label>

                        <input type="checkbox" class="btn-check" id="monday" name="monday" autocomplete="off">
                        <label class="btn btn-outline-primary" for="monday">Monday</label>

                        <input type="checkbox" class="btn-check" id="tuesday" name="tuesday" autocomplete="off">
                        <label class="btn btn-outline-primary" for="tuesday">Tuesday</label>

                        <input type="checkbox" class="btn-check" id="wednesday" name="wednesday" autocomplete="off" value="false">
                        <label class="btn btn-outline-primary" for="wednesday">Wednesday</label>

                        <input type="checkbox" class="btn-check" id="thursday" name="thursday" autocomplete="off">
                        <label class="btn btn-outline-primary" for="thursday">Thursday</label>

                        <input type="checkbox" class="btn-check" id="friday" name="friday" autocomplete="off">
                        <label class="btn btn-outline-primary" for="friday">Friday</label>

                        <input type="checkbox" class="btn-check" id="saturday" name="saturday" autocomplete="off">
                        <label class="btn btn-outline-primary" for="saturday">Saturday</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection
