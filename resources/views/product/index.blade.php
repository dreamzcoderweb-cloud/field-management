@php
    $title = 'Products';
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
                <a href="{{ route('product.create') }}" class="btn btn-phoenix-primary"><span
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
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="ps-2">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product?->brand?->name }}</td>
                                <td>{{ $product?->category?->name }}</td>
                                <td>{{ $product?->subcategory?->name }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                            onchange="changeStatus('{{ $product->id }}')"
                                            {{ $product->status == 'active' ? 'checked' : '' }} />
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-info btn-sm"><i
                                            class="fa fa-eye"></i> </a>
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
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
                url: "{{ route('product.changeStatus') }}",
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
