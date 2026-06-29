@php
    use App\Models\Settings;
    $title = 'Edit Employee';
    $settings = Settings::first();
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <form action="{{ route('employee.update', ['id' => $user->id]) }}" method="post">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h6>Login Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-4">
                                <label for="userName" class="control-label">User Name</label>
                                <input id="userName" disabled name="userName" class="form-control"
                                    value="{{ $user->user_name }}" />
                                <span class="text-danger">{{ $errors->first('userName', ':message') }}</span>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group col-md-6">
                                    <label for="phoneNumber" class="control-label">Phone Number</label>
                                    <input id="phoneNumber" name="phoneNumber" type="number" class="form-control"
                                        value="{{ $user->phone_number }}" />
                                    <span class="text-danger">{{ $errors->first('phoneNumber', ':message') }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email" class="control-label">Email</label>
                                    <input id="email" name="email" type="email" class="form-control"
                                        value="{{ $user->email }}" />
                                    <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-primary mt-2">
                    <div class="card-header">
                        <h6> Personal Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="firstName" class="control-label">First Name</label>
                                <input id="firstName" name="firstName" class="form-control"
                                    value="{{ $user->first_name }}" />
                                <span class="text-danger">{{ $errors->first('firstName', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="lastName" class="control-label">Last Name</label>
                                <input id="lastName" name="lastName" class="form-control"
                                    value="{{ $user->last_name }}" />
                                <span class="text-danger">{{ $errors->first('lastName', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="gender" class="control-label">Gender</label>
                                <select id="gender" name="gender" class="form-select mb-3">
                                    <option {{ $user->gender == 'male' ? 'selected' : '' }} value="male">Male</option>
                                    <option {{ $user->gender == 'female' ? 'selected' : '' }} value="female">Female
                                    </option>
                                    <option {{ $user->gender == 'unknown' ? 'selected' : '' }} value="unknown">Unknown
                                    </option>
                                </select>
                                <span class="text-danger">{{ $errors->first('gender', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="dob" class="control-label">Date of birth</label>
                                <input id="dob" name="dob" type="date" class="form-control"
                                    value="{{ $user->dob }}" />
                                <span class="text-danger">{{ $errors->first('dob', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="uniqueId" class="control-label">Unique Id</label>
                                <input id="uniqueId" name="uniqueId" class="form-control"
                                    value="{{ $user->unique_id }}" />
                                <span class="text-danger">{{ $errors->first('uniqueId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="alternateNumber" class="control-label">Alternate Number</label>
                                <input id="alternateNumber" name="alternateNumber" type="number" class="form-control"
                                    value="{{ $user->alternate_number }}" />
                                <span class="text-danger">{{ $errors->first('alternateNumber', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="address" class="control-label">Address</label>
                                <input id="address" name="address" class="form-control" value="{{ $user->address }}" />
                                <span class="text-danger">{{ $errors->first('address', ':message') }}</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card card-primary mt-2">
                    <div class="card-header">
                        <h6> Work Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label id="parentId" class="control-label">Manager</label>
                                <select id="parentId" name="parentId" data-choices="data-choices"
                                    data-options='{"removeItemButton":true,"placeholder":true}' class="form-select mb-3">
                                    <option value="">Please select a manager</option>
                                    @foreach ($managers as $manager)
                                        <option {{ $user->parent_id == $manager->id ? 'selected' : '' }}
                                            value="{{ $manager->id }}">
                                            {{ $manager->first_name . ' ' . $manager->last_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('parentId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label id="shiftId" class="control-label">Shift</label>
                                <select id="shiftId" name="shiftId" data-choices="data-choices"
                                    data-options='{"removeItemButton":true,"placeholder":true}' class="form-select mb-3">
                                    <option value="">Please select a shift</option>
                                    @foreach ($shifts as $shift)
                                        <option {{ $user->shift_id == $shift->id ? 'selected' : '' }}
                                            value="{{ $shift->id }}">{{ $shift->title }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('shiftId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="teamId" class="control-label">Team</label>
                                <select id="teamId" name="teamId" data-choices="data-choices"
                                    data-options='{"removeItemButton":true,"placeholder":true}' class="form-select mb-3">
                                    <option value="">Please select a team</option>
                                    @foreach ($teams as $team)
                                        <option {{ $user->team_id == $team->id ? 'selected' : '' }}
                                            value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('teamId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="dateOfJoin" class="control-label">Date Of Join</label>
                                <input id="dateOfJoin" name="dateOfJoin" type="date" class="form-control"
                                    value="{{ $user->date_of_joining }}" />
                                <span class="text-danger">{{ $errors->first('dateOfJoin', ':message') }}</span>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="designation" class="control-label">Designation</label>
                                <input id="designation" name="designation" class="form-control"
                                    value="{{ $user->designation }}" />
                                <span class="text-danger">{{ $errors->first('designation', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="baseSalary" class="control-label">Base Salary</label>
                                <input id="baseSalary" name="baseSalary" type="number" class="form-control"
                                    value="{{ $user->base_salary }}" />
                                <span class="text-danger">{{ $errors->first('baseSalary', ':message') }}</span>

                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="primarySalesTarget" class="control-label">Primary Sales Target</label>
                                <input id="primarySalesTarget" name="primarySalesTarget" type="number"
                                    class="form-control" value="{{ $user->primary_sales_target }}" />
                                <span class="text-danger">{{ $errors->first('primarySalesTarget', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="secondarySalesTarget" class="control-label">Secondary Sales Target</label>
                                <input id="secondarySalesTarget" name="secondarySalesTarget" type="number"
                                    class="form-control" value="{{ $user->secondary_sales_target }}" />
                                <span class="text-danger">{{ $errors->first('secondarySalesTarget', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="availableLeaveCount" class="control-label">Available Leave Count</label>
                                <input id="availableLeaveCount" name="availableLeaveCount" type="number"
                                    class="form-control" value="{{ $user->available_leaves }}" />
                                <span class="text-danger">{{ $errors->first('availableLeaveCount', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <h6> Attendance Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-outline-warning d-flex align-items-center" role="alert">
                            <span class="fas fa-info-circle text-warning me-3"></span>
                            <p class="mb-0 flex-1">
                                <strong class="fw-bold">Important Note:</strong> <br />
                                <span><strong class="fw-bold">None</strong> : Open attendance system without any
                                    restriction</span>
                                <br />
                                <span><strong class="fw-bold">Geofence</strong> : Allow attendance only from the selected
                                    geofence group</span>
                                <br />
                                <span><strong class="fw-bold">IP Address</strong> : Allow attendance only from the selected
                                    IP group</span>
                                <br />
                                <span><strong class="fw-bold">QR Code</strong> : Allow attendance only from the selected QR
                                    group</span>
                                <br />
                                <span><strong class="fw-bold">Dynamic QR Code</strong> : Allow attendance from dynamic QR
                                    device registered in the portal.</span>
                            </p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="attendanceType" class="control-label">Attendance Type</label>
                                <select id="attendanceType" name="attendanceType" class="form-select mb-3">
                                    <option value="0" {{ $user->attendance_type == 'none' ? 'selected' : '' }}>None
                                    </option>
                                    <option value="1" {{ $user->attendance_type == 'geofence' ? 'selected' : '' }}>
                                        Geofence
                                    </option>
                                    <option value="2" {{ $user->attendance_type == 'ip_address' ? 'selected' : '' }}>
                                        IP
                                        Address
                                    </option>
                                    <option value="3"
                                        {{ $user->attendance_type == 'static_qr_code' ? 'selected' : '' }}>
                                        Static
                                        QR Code
                                    </option>
                                    {{-- <option value="4">Dynamic QR Code</option>
                                     <option value="5">Site</option> --}}
                                </select>
                                <span class="text-danger">{{ $errors->first('attendanceType', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3" id="geofenceGroupDiv" style="display:none;">
                                <label for="geofenceGroupId" class="control-label">Geofence Group</label>
                                <select id="geofenceGroupId" name="geofenceGroupId" class="form-select mb-3"></select>
                                <span class="text-danger">{{ $errors->first('geofenceGroupId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3" id="ipGroupDiv" style="display:none;">
                                <label for="ipGroupId" class="control-label">Ip Group</label>
                                <select id="ipGroupId" name="ipGroupId" class="form-select mb-3"></select>
                                <span class="text-danger">{{ $errors->first('ipGroupId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3" id="qrGroupDiv" style="display:none;">
                                <label for="qrGroupId" class="control-label">Qr Group</label>
                                <select id="qrGroupId" name="qrGroupId" class="form-select mb-3"></select>
                                <span class="text-danger">{{ $errors->first('qrGroupId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3" id="dynamicQrDiv" style="display:none;">
                                <label for="dynamicQrId" class="control-label">Dynamic Qr</label>
                                <select id="dynamicQrId" name="dynamicQrId" class="form-select mb-3"></select>
                                <span class="text-danger">{{ $errors->first('dynamicQrId', ':message') }}</span>
                            </div>
                            <div class="form-group col-md-3 mb-3" id="siteDiv" style="display:none;">
                                <label for="siteId" class="control-label">Site</label>
                                <select id="siteId" name="siteId" class="form-select mb-3"></select>
                                <span class="text-danger">{{ $errors->first('siteId', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNZMjI6BykptQrTCZJiPX2iEwBmd9UZUU&libraries=places&callback=initAutocomplete"
        async defer></script>

    </script>
    <script>
       function initAutocomplete() {
            const input = document.getElementById("address");
            const autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['address'],
                componentRestrictions: {
                    country: "in"
                }
            });
        }

        $(document).ready(function() {

            var currentSelection = '{{ $user->attendance_type }}';
            console.log('Current Selection ' + currentSelection);

            if (currentSelection === 'geofence') {
                $('#geofenceGroupDiv').show();
                $('#ipGroupDiv').hide();
                $('#qrGroupDiv').hide();
                $('#dynamicQrDiv').hide();
                $('#siteDiv').hide();
                getGeofenceGroups();
            } else if (currentSelection === 'ip_address') {
                $('#geofenceGroupDiv').hide();
                $('#ipGroupDiv').show();
                $('#qrGroupDiv').hide();
                $('#dynamicQrDiv').hide();
                $('#siteDiv').hide();
                getIpGroups();
            } else if (currentSelection === 'static_qr_code') {
                $('#geofenceGroupDiv').hide();
                $('#ipGroupDiv').hide();
                $('#qrGroupDiv').show();
                $('#dynamicQrDiv').hide();
                $('#siteDiv').hide();
                getQrGroups();
            } else {
                $('#geofenceGroupDiv').hide();
                $('#ipGroupDiv').hide();
                $('#qrGroupDiv').hide();
                $('#dynamicQrDiv').hide();
                $('#siteDiv').hide();
            }

            $('#attendanceType').change(function() {
                var attendanceType = $(this).val();
                console.log('Attendance Type ' + attendanceType);
                if (attendanceType == 1) {
                    $('#geofenceGroupDiv').show();
                    $('#ipGroupDiv').hide();
                    $('#qrGroupDiv').hide();
                    $('#dynamicQrDiv').hide();
                    $('#siteDiv').hide();
                    getGeofenceGroups();
                } else if (attendanceType == 2) {
                    $('#geofenceGroupDiv').hide();
                    $('#ipGroupDiv').show();
                    $('#qrGroupDiv').hide();
                    $('#dynamicQrDiv').hide();
                    $('#siteDiv').hide();
                    getIpGroups();
                } else if (attendanceType == 3) {
                    $('#geofenceGroupDiv').hide();
                    $('#ipGroupDiv').hide();
                    $('#qrGroupDiv').show();
                    $('#dynamicQrDiv').hide();
                    $('#siteDiv').hide();
                    getQrGroups();
                }
                /* else if (attendanceType == 4) {
                                    $('#geofenceGroupDiv').hide();
                                    $('#ipGroupDiv').hide();
                                    $('#qrGroupDiv').hide();
                                    $('#dynamicQrDiv').show();
                                    $('#siteDiv').hide();
                                } else if (attendanceType == 5) {
                                    $('#geofenceGroupDiv').hide();
                                    $('#ipGroupDiv').hide();
                                    $('#qrGroupDiv').hide();
                                    $('#dynamicQrDiv').hide();
                                    $('#siteDiv').show();
                                }*/
                else {
                    $('#geofenceGroupDiv').hide();
                    $('#ipGroupDiv').hide();
                    $('#qrGroupDiv').hide();
                    $('#dynamicQrDiv').hide();
                    $('#siteDiv').hide();
                }
            });
        })


        function getGeofenceGroups() {
            $.ajax({
                url: '{{ route('employee.getGeofenceGroups') }}',
                type: 'GET',
                success: function(response) {
                    if (response.length === 0) {
                        notyf('Please create a geofence group first');
                        return;
                    }

                    var selectedId = '{{ $user->geofence_group_id }}';

                    var options = '<option value="">Please select a geofence group</option>';
                    response.forEach(function(item) {
                        if (item.id == selectedId) {
                            options += '<option selected value="' + item.id + '">' + item.name +
                                '</option>';
                        } else {
                            options += '<option value="' + item.id + '">' + item.name + '</option>';
                        }
                    });
                    $('#geofenceGroupId').html(options);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function getIpGroups() {
            $.ajax({
                url: '{{ route('employee.getIpGroups') }}',
                type: 'GET',
                success: function(response) {
                    if (response.length === 0) {
                        notyf('Please create a ip group first');
                        return;
                    }

                    var selectedId = '{{ $user->ip_address_group_id }}';
                    var options = '<option value="">Please select a ip group</option>';
                    response.forEach(function(item) {
                        if (item.id == selectedId) {
                            options += '<option selected value="' + item.id + '">' + item.name +
                                '</option>';
                        } else {
                            options += '<option value="' + item.id + '">' + item.name + '</option>';
                        }
                    });
                    $('#ipGroupId').html(options);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function getQrGroups() {
            $.ajax({
                url: '{{ route('employee.getQrGroups') }}',
                type: 'GET',
                success: function(response) {
                    if (response.length === 0) {
                        notyf('Please create a qr group first');
                        return;
                    }
                    var selectedId = '{{ $user->qr_code_group_id }}';
                    var options = '<option value="">Please select a qr group</option>';
                    response.forEach(function(item) {
                        if (item.id == selectedId) {
                            options += '<option selected value="' + item.id + '">' + item.name +
                                '</option>';
                        } else {
                            options += '<option value="' + item.id + '">' + item.name + '</option>';
                        }
                    });
                    $('#qrGroupId').html(options);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection

