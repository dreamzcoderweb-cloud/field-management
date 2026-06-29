@php
    $title = 'Teams'
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
                <a href="{{route('team.create')}}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="datatable">
                <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>Employees</th>
                    {{--   <th>Chat Status</th>--}}
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td class="ps-2">{{$loop->iteration}}</td>
                        <td>{{$team->name}}</td>
                        <td>{{$team->users->count()}}</td>
                        {{--  <td>
                              <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" onchange="changeChatStatus('{{$team->id}}')"  {{$team->is_chat_enabled? 'checked' : ''}} />
                              </div>
                          </td>--}}
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                       onchange="changeStatus('{{$team->id}}')" {{$team->status == 'active'? 'checked' : ''}} />
                            </div>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{route('team.edit', $team->id)}}" class="btn btn-sm btn-primary me-3"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{route('team.delete', $team->id)}}"
                                   onclick="return confirm('Are you sure you want to delete?')"
                                   class="btn btn-sm btn-danger me-3"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        function changeStatus(id) {
            $.ajax({
                'csrf-token': '{{csrf_token()}}',
                url: "{{route('team.changeStatus')}}",
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


        function changeChatStatus(id) {
            $.ajax({
                'csrf-token': '{{csrf_token()}}',
                url: "{{route('team.changeChatStatus')}}",
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
