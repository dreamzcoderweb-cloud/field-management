@php
    $title = 'Staff Vehicle';
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">Vehicles of {{ $staffvehicles[0]?->user?->user_name }}</h4>
            </div>
        </div>
        <div class="col">
            {{-- <div class="float-end">
                <a href="{{ route('productcategory.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create new</a>
            </div> --}}
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bike Model</th>
                            <th>Number</th>
                            <th>Current Kilometer</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($staffvehicles) > 0)
                            @foreach ($staffvehicles as $staffvehicle)
                                <tr>
                                    <td class="ps-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $staffvehicle?->bike_model }}</td>
                                    <td>{{ $staffvehicle->number }}</td>
                                    <td>{{ $staffvehicle->current_kilometer }}</td>
                                    <td><img src="{{ url('public/staff/vehicle/' . $staffvehicle->kilometer_image) }}"
                                            alt="KM-IMG" style="width: 40px;height:40px;"></td>
                                    <td>{{ $staffvehicle->created_at->format('d-m-Y h:i A') }}</td>
                                    <td>
                                        {{-- <a href="{{route('product.show', $productCategory->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a> --}}
                                        <a href="{{ route('admin.staffvehicle.edit', $staffvehicle->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
                                        <form action="{{ route('admin.staffvehicle.destroy', $staffvehicle->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <Center>
                                    <td colspan="6">No Data Found</td>
                                </Center>
                            </tr>
                        @endif
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
                'csrf-token': '{{ csrf_token() }}',
                url: "{{ route('productcategory.changeStatus') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    notyf.success(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection

