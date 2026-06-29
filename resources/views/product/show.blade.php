@php
    $title = 'Product Details';
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

        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Type</th>
                            <td>{{ $product->product_type }}</td>
                        </tr>

                        <tr>
                            <th>Product Name</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>{{ $product?->brand?->name }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $product?->category?->name }}</td>
                        </tr>
                        <tr>
                            <th>Subcategory</th>
                            <td>{{ $product?->subcategory?->name }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>{{ $product?->price }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($product->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <a href="{{ route('productList') }}" class="btn btn-danger">Back</a>

                </div>
            </div>
        </div>
    </div>
@endsection
