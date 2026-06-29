@php
    use App\Models\Settings;
    $title = 'Create Task';
    $settings = Settings::first();
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    {{-- <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{ $title }}</h4>
            </div>
        </div>
        <div class="col">

        </div>
    </div> --}}
    <ul class="nav nav-pills mb-4 justify-content-start">
        <li class="nav-item">
            <a class="nav-link fw-semibold px-4 py-2 rounded-pill 
                {{ request()->routeIs('admin.task.index') ? 'active bg-primary text-white shadow' : 'text-primary border border-primary' }}"
                href="{{ route('admin.task.index') }}">
                <i class="fas fa-tasks me-2"></i> Tasks
            </a>
        </li>
        <li class="nav-item ms-2">
            <a class="nav-link fw-semibold px-4 py-2 rounded-pill 
                {{ request()->routeIs('admin.task.create') ? 'active bg-primary text-white shadow' : 'text-primary border border-primary' }}"
                href="{{ route('admin.task.create') }}">
                <i class="fas fa-plus-circle me-2"></i> Create
            </a>
        </li>
    </ul>
    <form action="{{ route('admin.task.store') }}" method="post" id="validation">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    <h6>Create task</h6>
                    <div class="card-body">
                        <div class="form-group row">

                            <div class="form-group col-md-12 mb-3">
                                <label for="title" class="control-label">Title</label>
                                <input id="title" class="form-control" name="title" value="{{ old('title') }}" />
                                <span class="text-danger">{{ $errors->first('title', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="description" class="control-label">Description</label>
                                <textarea id="description" name="description" class="form-control">
                                    {{ old('description') }}
                                </textarea>
                                <span class="text-danger">{{ $errors->first('description', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="type" class="control-label">Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Task</option>
                                    <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Client Meet</option>
                                    <option value="3" {{ old('type') == '3' ? 'selected' : '' }}>Collection</option>
                                    {{-- <option value="4" {{ old('type') == '4' ? 'selected' : '' }}>Lead</option> --}}
                                </select>
                                <span class="text-danger">{{ $errors->first('type', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="team_id" class="control-label">Team</label>
                                <select id="team_id" name="team_id" class="form-control">
                                    <option value="">Select Team</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}"
                                            {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('team_id', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="user_id" class="control-label">Employee</label>
                                <select id="user_id" name="user_id" class="form-control">
                                    <option value="">Select Employee</option>
                                    {{-- @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('user_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                    @endforeach --}}
                                </select>
                                <span class="text-danger">{{ $errors->first('user_id', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="client_id" class="control-label">Client List</label>
                                <select name="client_id" id="client_id" class="form-control client_empty" disabled>
                                    <option value="">Choose client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('client_id', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3 lead_detail" hidden>
                                <label for="lead_id" class="control-label">Lead List</label>
                                <select name="lead_id" id="lead_id" class="form-control">
                                    <option value="">Choose Lead</option>
                                    @foreach ($leads as $lead)
                                        <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('lead_id', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3 client_details" hidden>
                                <div class="border p-3 rounded">
                                    <h6 class="text-primary">Client Details</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Name:</strong> <span class="param" id="nameparam"></span></p>
                                            <p><strong>Mobile:</strong> <span class="param" id="mobileparam"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Email:</strong> <span class="param" id="emailparam"></span></p>
                                            <p><strong>Address:</strong> <span class="param" id="addressparam"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-3 mb-3 sale_detail" hidden>
                                <label for="sale_id" class="control-label">Sales List</label>
                                <select name="sale_id" id="sale_id" class="form-control sale_empty">
                                    <option value="">Choose sale</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('type', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3 sale_detail" hidden>
                                <label for="amount" class="control-label amount_empty">Amount</label>
                                <input id="amount" class="form-control" name="amount" value="{{ old('amount') }}"
                                    readonly />
                                <span class="text-danger">{{ $errors->first('amount', ':message') }}</span>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 mb-3 task" hidden>
                                    <label for="notes" class="control-label">Notes</label>
                                    <textarea id="notes" name="notes" class="form-control note_empty">
                                        {{ old('notes') }}
                                    </textarea>
                                    <span class="text-danger">{{ $errors->first('notes', ':message') }}</span>
                                </div>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="start_date" class="control-label">Start date</label>
                                <input id="start_date" type="date" class="form-control" name="start_date"
                                    value="{{ old('start_date') }}" />
                                <span class="text-danger">{{ $errors->first('start_date', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="end_date" class="control-label">End date</label>
                                <input id="end_date" type="date" class="form-control" name="end_date"
                                    value="{{ old('end_date') }}" />
                                <span class="text-danger">{{ $errors->first('end_date', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('task.index') }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js "></script>
<script defer src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>



<script>
    $(document).ready(function() {
        $("#validation").validate({
            rules: {
                title: "required",
                description: "required",
                team_id: "required",
                user_id: "required",
                type: "required",
                client_id: {
                    required: function(element) {
                        let typeValue = $('#type').val();
                        return typeValue === '2' || typeValue === '3'; // Correct way to check
                    }
                },
                sale_id: {
                    required: function(element) {
                        return $('#type').val() === '3' && ('#client_id') != "";
                    }
                },
                lead_id: {
                    required: function(element) {
                        return $('#type').val() === '4';
                    }
                },
                start_date: "required",
                end_date: "required",
            },
            messages: {
                title: "The title field is required.",
                description: "The description field is required.",
                team_id: "Select a team.",
                user_id: "Select a employee.",
                type: "The type field is required.",
                client_id: "Select a client.",
                sale_id: "Select a sale.",
                sale_id: "Select a lead.",
                start_date: "Select a start date.",
                end_date: "Select a end date.",
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $(document).on('change', '#type', function() {
        // alert("hiii");
        let type = $(this).val();
        console.log(type, "type");
        if (type == 1) {
            $('.lead_detail').attr("hidden", true);
            $(".task").attr("hidden", false);
            $('.client_details').attr("hidden", true);
            $('.sale_detail').attr("hidden", true);
            $("#client_id").attr('disabled', true);
            $(".client_empty").val("");
            $(".sale_empty").val("");
            $(".amount_empty").val("");
        } else if (type == 2) {
            $('.lead_detail').attr("hidden", true);
            $('.client_details').attr("hidden", false);
            $(".task").attr("hidden", true);
            $('.sale_detail').attr("hidden", true);
            $("#client_id").attr('disabled', false);
            $('.note_empty').val("");
            $(".sale_empty").val("");
            $(".amount_empty").val("");
        } else if (type == 3) {
            $('.lead_detail').attr("hidden", true);
            $('.sale_detail').attr("hidden", false);
            $(".task").attr("hidden", true);
            $('.client_details').attr("hidden", true);
            $("#client_id").attr('disabled', false);
            $(".client_empty").val("");
            $('.note_empty').val("");
        } else if (type == 4) {
            $('.lead_detail').attr("hidden", false);
            $('.sale_detail').attr("hidden", true);
            $(".task").attr("hidden", true);
            $('.client_details').attr("hidden", true);
            $("#client_id").attr('disabled', true);
            $(".client_empty").val("");
            $('.note_empty').val("");
        }
    });

    $(document).on('change', '#client_id', function() {
        let id = $(this).val();
        let type = $("#type").val();
        console.log(id, type);
        $.ajax({
            url: "{{ route('clientDetails') }}",
            type: "GET",
            data: {
                type: type,
                id: id,
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response != "" && response.type == 2) {
                    $('#nameparam').text(response.client.name);
                    $('#mobileparam').text(response.client.phone);
                    $('#emailparam').text(response.client.email);
                    $('#addressparam').text(response.client.address);
                } else if (response != "" && response.type == 3) {
                    if (response.sales) {
                        if (Array.isArray(response.sales)) {
                            $('#sale_id').empty();
                            $('#sale_id').html('<option value="">Select Sale</option>');
                            response.sales.forEach(sale => {
                                $('#sale_id').append(
                                    `<option value="${sale.id}">${sale.product.name}</option>`
                                );
                            });
                        } else {
                            console.error("Expected an array, but received:", response.sales);
                        }
                    }
                } else {
                    alert("Something went wrong!!!");
                }
            }
        });
    });

    $(document).on('change', '#sale_id', function() {
        let sale_id = $("#sale_id").val();
        console.log(sale_id, "saleId");
        $.ajax({
            url: "{{ route('getAmount') }}",
            type: "GET",
            data: {
                id: sale_id,
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response != "") {
                    $("#amount").val(response.amount);
                } else {
                    alert("Something went wrong!!!");
                }
            }
        });
    });

    $(document).on('change', '#team_id', function() {
        let team_id = $("#team_id").val();
        console.log(team_id, "team_id");
        $.ajax({
            url: "{{ route('admin.teamMembers') }}",
            type: "GET",
            data: {
                teamId: team_id,
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response != "") {
                    // $("#amount").val(response.amount);
                    let $userSelect = $('#user_id');
                    $userSelect.empty(); // clear existing options
                    $userSelect.append(
                        '<option value="">Please select an Employee</option>');

                    response.users.forEach(function(user) {
                        $userSelect.append(
                            `<option value="${user.id}">${user.user_name}</option>`
                        );
                    });
                } else {
                    alert("Something went wrong!!!");
                }
            }
        });
    });
</script>
