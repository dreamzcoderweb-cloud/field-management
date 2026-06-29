@php
    $title = 'Vehicle list';
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{ $title }}</h4>
            </div>
        </div>
        <div class="col">
            <div class="float-end">
                <a href="{{ route('admin.vehicle.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create Vehicle</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $vehicle)
                            <tr>
                                <td class="ps-2">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $vehicle->name }}</td>
                                <td>{{ $vehicle->vehicle_number }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="status" type="checkbox"
                                            data-id="{{ $vehicle->id }}" {{ $vehicle->status == '1' ? 'checked' : '' }} />
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.vehicle.edit', $vehicle->id) }}" class="btn btn-primary btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit details">
                                        <i class="fa fa-pen"></i>
                                    </a>
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
        $(document).on('change', '#status', function() {
            let id = $(this).data('id');
            let status = $(this).prop('checked') ? 1 : 0;
            console.log(id, "id");
            $.ajax({
                url: "{{ route('admin.updateVehicleStatus') }}",
                type: "GET",
                data: {
                    id: id,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        notyf.success('Status Updated!!!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        window.location.reload();
                    } else {
                        notyf.error('Something wentwrong', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        window.location.reload();
                    }
                }
            });
        });
    </script>
@endsection
