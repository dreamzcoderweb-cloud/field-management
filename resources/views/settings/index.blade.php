@php
    $title = 'Settings'
@endphp
@section('title') {{$title}} @endsection
@extends('layout')
@section('main-content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="width:30%">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Basic Settings</button>
                   {{-- <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">SMS Settings</button>--}}
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Dashboard Settings</button>
                    <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Mobile App Settings</button>
                    <button class="nav-link" id="v-pills-map-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-map-settings" type="button" role="tab" aria-controls="v-pills-map-settings" aria-selected="false">Map Settings</button>
                </div>
                <div class="tab-content w-100" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="card">
                            <div class="card-header">
                                <h6>Basic Settings</h6>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{route('settings.updateBasicSettings')}}" method="post">
                                    @csrf
                                    <div class="row mb-3">
                                        <label class="col-6 col-form-label">App Name</label>
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="appName" name="appName" placeholder="Application Name" value="{{$settings->app_name}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-6 col-form-label">App Version</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="appVersion" name="appVersion" placeholder="Application Version" value="{{$settings->app_version}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-6 col-form-label">Country Code</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="country" name="country" placeholder="Country Code" value="{{$settings->country}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-6 col-form-label">Country Phone Code</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="phoneCountryCode" name="phoneCountryCode" placeholder="Country Phone Code" value="{{$settings->phone_country_code}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-6 col-form-label">Currency</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="currency" name="currency" placeholder="Currency" value="{{$settings->currency}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-6 col-form-label">Currency Symbol</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="currencySymbol" name="currencySymbol" placeholder="Currency Symbol" value="{{$settings->currency_symbol}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-6 col-form-label">Distance Unit</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="distanceUnit" id="distanceUnit">
                                                <option {{$settings->distance_unit == 'km' ? 'selected' : ''}}>KM</option>
                                                <option {{$settings->distance_unit != 'km' ? 'selected' : ''}}>Miles</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="card">
                            <div class="card-header">
                                <h6>Dashboard Settings</h6>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{route('settings.updateDashboardSettings')}}" method="post">
                                    @csrf
                                    <div>
                                        <div class="row mb-3">
                                            <label for="OfflineCheckTimeType" class="col-sm-6 col-form-label">Offline Check Time Type</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="offlineCheckTimeType" id="offlineCheckTimeType">
                                                    <option {{$settings->offline_check_time_type == 'seconds' ? 'selected' : ''}}>Seconds</option>
                                                    <option {{$settings->offline_check_time_type != 'seconds' ? 'selected' : ''}}>Minutes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputName" class="col-sm-6 col-form-label">Offline Check Time</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="offlineCheckTime" name="offlineCheckTime" placeholder="Offline Check Time" value="{{$settings->offline_check_time}}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        <div class="card">
                            <div class="card-header">
                                <h6>Mobile App Settings</h6>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{route('settings.updateMobileAppSettings')}}" method="post">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <label for="inputName" class="col-sm-6 col-form-label">Mobile App Version</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="mobileAppVersion" name="mobileAppVersion" placeholder="Mobile App Version" value="{{$settings->m_app_version}}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputName" class="col-sm-6 col-form-label">Privacy Policy Link</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="privacyPolicyLink" name="privacyPolicyLink" placeholder="Privacy Policy Link" value="{{$settings->privacy_policy_url}}">
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="mb-3">
                                            <span class="text-danger">* Be careful while changing this, less time means more battery consumption in mobile app. Our recommendation is 15 minute</span>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="LocationUpdateIntervalType" class="col-sm-6 col-form-label">Mobile device Update Interval Type </label>
                                            <div class="col-sm-6">
                                                <select class="form-control" id="locationUpdateIntervalType" name="locationUpdateIntervalType">
                                                    <option {{$settings->m_location_update_time_type == 'seconds' ? 'selected' : ''}}">Seconds</option>
                                                    <option {{$settings->m_location_update_time_type != 'seconds' ? 'selected' : ''}}>Minutes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputName" class="col-sm-6 col-form-label">Mobile device Update Interval</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="locationUpdateInterval" name="locationUpdateInterval" placeholder="Location Update Interval" value="{{$settings->m_location_update_interval}}">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-map-settings" role="tabpanel" aria-labelledby="v-pills-map-settings-tab">
                        <div class="card">
                            <div class="card-header">
                                <h6>Map Settings</h6>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{route('settings.updateMapSettings')}}" method="post">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <label for="inputName" class="col-sm-6 col-form-label">Latitude</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="latitude" name="latitude" placeholder="Latitude" value="{{$settings->center_latitude}}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputName" class="col-sm-6 col-form-label">Longitude</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="longitude" name="longitude" placeholder="Longitude" value="{{$settings->center_longitude}}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputName" class="col-sm-6 col-form-label">Map Zoom Level</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="mapZoomLevel" name="mapZoomLevel" placeholder="Map Zoom Level" value="{{$settings->map_zoom_level}}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
