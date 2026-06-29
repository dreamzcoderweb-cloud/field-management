@php
    $title = 'Leave Types'
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
                <a href="{{route('leaveType.create')}}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div>
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
                        <th>Is Image Required</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leave_types as $key => $leave_type)
                        <tr>
                            <td class="ps-2">{{$key + 1}}</td>
                            <td>{{$leave_type->name}}</td>
                            <td>@if($leave_type->is_img_required)
                                    <i class="fa fa-check text-success"></i>
                                @else
                                    <i class="fa fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                           onchange="changeStatus('{{$leave_type->id}}')" {{$leave_type->status == 'active'? 'checked' : ''}} />
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('leaveType.edit', $leave_type->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-edit"></i></a>
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
