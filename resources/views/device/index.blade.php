@php
    $title = 'Device Management';
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
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration" id="datatable">
                    <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Sdk Version</th>
                        <th>Device Type</th>
                        <th>Last Location</th>
                        <th>Last Updated On</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($devices as $key => $device)
                        <tr>
                            <td class="ps-2">{{$key + 1}}</td>
                            <td>{{$device->user->first_name}}  {{$device->user->last_name}}</td>
                            <td>{{$device->brand}}</td>
                            <td>{{$device->model}}</td>
                            <td>{{$device->sdk_version}}</td>
                            <td>{{$device->device_type}}</td>
                            <td></td>
                            <td>{{$device->updated_at}}</td>
                            <td>
                                <form action="{{route('device.revoke', $device->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to revoke?')"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function changeStatus(id) {
            $.ajax({
                'csrf-token': '{{csrf_token()}}',
                url: "{{route('leaveType.changeStatus')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    console.log(data);
                    notyf.success(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

    </script>
@endsection
