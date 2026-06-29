@php
    $title = 'Brand List';
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
                <a href="{{ route('admin.brand.create') }}" class="btn btn-phoenix-primary"><span
                        class="fa fa-plus-circle fa-fw me-2"></span>Create Brand</a>
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
                            <th>Name</th>
                            {{-- <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td class="ps-2">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $brand->name }}</td>
                                {{-- <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                            onchange="changeStatus('{{ $productCategory->id }}')"
                                            {{ $productCategory->status == 'active' ? 'checked' : '' }} />
                                    </div>
                                </td> --}}
                                <td>
                                    {{-- <a href="{{route('product.show', $productCategory->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a> --}}
                                    <a href="{{ route('admin.brand.edit', $brand->id) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-pen"></i></a>

                                    <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
