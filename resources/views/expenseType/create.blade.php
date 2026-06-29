@php
    $title = 'Create Expense Type'
@endphp
@section('title') {{$title}} @endsection
@extends('layout')
@section('main-content')
<form method="post" action="{{route('expenseType.store')}}">
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
            <div class="form-group col-md-3 mt-3">
                <label for="is_img_required" class="control-label">Is Image Required</label>
                <select id="is_img_required" name="is_img_required" class="form-control">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <span class="text-danger">{{ $errors->first('is_img_required', ':message') }}</span>
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
