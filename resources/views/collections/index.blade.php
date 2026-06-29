@php
    $title = 'Collections';
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
                <a href="{{ route('collections.create') }}" class="btn btn-phoenix-primary"><span
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
                            <th>Client</th>
                            <th>Product</th>
                            <th>EMI</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collections as $collection)
                            <tr>
                                <td class="ps-2">{{ $loop->iteration }}</td>
                                <td>{{ $collection?->client?->name }}</td>
                                <td>{{ $collection?->product?->name }}</td>
                                <td>
                                    {{ $collection->emi_amount }} / month<br>
                                    <span>{{ $collection->paid_months }} / {{ $collection->total_months }} months</span><br>
                                    <span>Date: {{ $collection->emi_date }}</span>
                                </td>
                                <td>{{ $collection->paid_amount }}</td>
                                <td>{{ $collection->balance_amount }}</td>
                                <td>
                                    @if ($collection->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif ($collection->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('collections.show', $collection->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <!-- <a href="{{ route('collections.edit', $collection->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a> -->
                                    <form action="{{ route('collections.destroy', $collection->id) }}" method="POST"
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
