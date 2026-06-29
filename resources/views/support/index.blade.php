@php
    $title = 'Support'
@endphp
@section('title') {{$title}} @endsection
@extends('layout')
@section('main-content')
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <img src="{{asset('img/support.jpg')}}" class="card-img-top" />
                <div class="card-body text-center">
                    <h2 class="card-title text-primary text-center">CZ App Studio</h2>
                    <h5 class="card-title text-primary text-center">Support Time</h5>
                    <h6 class="card-text">Monday-Friday 10AM-5PM IST</h6>
                    <p>Whatsapp number <b>+91-88254 39260</b></p>
                    <hr>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <a href="https://czappstudio.com/" target="_blank" class="btn btn-primary"><i class="bi bi-globe"></i> Website</a>
                        <a href="https://wa.me/918825439260" target="_blank" class="btn btn-primary"><i class="bi bi-whatsapp"></i> Whatsapp</a>
                        <a href="mailto:support@czappstudio.com" target="_blank" class="btn btn-primary"><i class="bi bi-envelope"></i> Email</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
