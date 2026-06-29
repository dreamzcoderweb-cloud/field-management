@php
    $title = 'Loan'
@endphp
@section('title') {{$title}} @endsection
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
            <a href="{{route('loan.create')}}" class="btn btn-phoenix-primary"><span
                    class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
        </div>
    </div>
</div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Name</th>
                            <th>Status</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td class="ps-2">
                                    {{$loop->iteration}}
                                </td>
                                <td>{{$loan->name}}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                               onchange="changeStatus('{{$loan->id}}')" {{$loan->status == 'active'? 'checked' : ''}} />
                                    </div>
                                </td>
                                <td>
                                    {{-- <a href="{{route('product.show', $loan->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a> --}}
                                 {{--   <a href="{{route('client.edit', $loan->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{route('client.destroy', $loan->id)}}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>--}}

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
                url: "{{route('loan.changeStatus')}}",
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
