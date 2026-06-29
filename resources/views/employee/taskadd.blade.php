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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{ $title }}</h4>
            </div>
        </div>
        <div class="col">

        </div>
    </div>
    <form action="{{ route('employee.taskstore') }}" method="post" id="taskForm">
        @csrf
        <div class="card shadow">
            <div class="card-body">


                <div class="mt-2">

                    <h6>Task</h6>

                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <input id="user_id" type="hidden" name="user_id" class="form-control" value="{{ $user->id }}" />


                                <label for="title" class="control-label">Title</label>
                                <input id="title" class="form-control" value="{{ old('title') }}" name="title"/>
                                <span class="text-danger">{{ $errors->first('title', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="description" class="control-label">Description</label>
                                <textarea id="description" class="form-control" value="{{ old('description') }}" name="description" />
                                    </textarea>
                                <span class="text-danger">{{ $errors->first('description', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="description" class="control-label">Client List</label>
                                <select name="client_id" id="client_id" class="form-control">
                                    <option value="" selected disabled>Choose client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('type', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="description" class="control-label">Task Type</label>
                                <select name="type" id="type" class="form-control" disabled>
                                    <option value="" selected disabled>Choose Task Type</option>
                                    <option value="1">Client Visit</option>
                                    <option value="2">Payment Collection</option>
                                    <option value="3">Site Visit</option>
                                    <option value="4">Others</option>

                                </select>
                                <span class="text-danger">{{ $errors->first('type', ':message') }}</span>
                            </div>
                            <div id="other-textarea" class="form-group col-md-6 mb-3" style="display: none;">
                                <label for="other_details" class="control-label">Details for Others</label>
                                <textarea id="other_details" name="other_details" class="form-control" rows="3" placeholder="Provide details for Others"></textarea>
                            </div>
                            
                            <div id="client-details" class="form-group col-md-6 mb-3" style="display: none;">
                                <label for="client_email" class="control-label">Client Email</label>
                                <input type="text" id="client_email" class="form-control" readonly
                                    placeholder="Client Email">

                                <label for="client_address" class="control-label mt-2">Client Address</label>
                                <input type="text" id="client_address" class="form-control" readonly
                                    placeholder="Client Address">

                                <label for="client_phone" class="control-label mt-2">Client Phone</label>
                                <input type="text" id="client_phone" class="form-control" readonly
                                    placeholder="Client Phone">
                            </div>

                            <div class="form-group col-md-3 mb-3" style="display: none;">
                                <label for="balance_amount" class="control-label">Client Balance</label>
                                <input type="text" id="balance_amount" class="form-control" readonly
                                    placeholder="Balance will appear here">
                            </div>


                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('employee.index') }}" style="margin-left: 4px;" class="btn btn-danger">Back</a>


            </div>

        </div>

        @if($tasks->count() > 0)
        <div class="card card-primary mt-2">
            <div class="card-header">
                <h6><i class="fa fa-user-alt"></i> Task Details</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Task Title</th>
                            <th>Description</th>
                            <th>Task Type</th>
                            <th>Status</th>
                            <th>Client Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    @php
                                        $taskTypes = [
                                            1 => 'Client Visit',
                                            2 => 'Payment Collection',
                                            3 => 'Site Visit',
                                            4 => 'Other'
                                        ];
                                    @endphp
                                    {{ $taskTypes[$task->type] ?? 'Unknown Type' }}
                                </td>
                                <td>
                                    <select class="form-control status-dropdown" data-task-id="{{ $task->id }}">
                                        <option value="new" {{ $task->status == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </td>
                                <td>
                                    @php
                                        $clientDetails = json_decode($task->client_details, true);
                                    @endphp
                                    @if ($clientDetails)
                                        @if (!empty($clientDetails['name']))
                                            <strong>Name:</strong> {{ $clientDetails['name'] }}<br>
                                        @endif
                                        @if (!empty($clientDetails['email']))
                                            <strong>Email:</strong> {{ $clientDetails['email'] }}<br>
                                        @endif
                                        @if (!empty($clientDetails['phone']))
                                            <strong>Phone:</strong> {{ $clientDetails['phone'] }}<br>
                                        @endif
                                        @if (!empty($clientDetails['address']))
                                            <strong>Address:</strong> {{ $clientDetails['address'] }}<br>
                                        @endif
                                        @if (!empty($clientDetails['balance_amount']))
                                            <strong>Balance:</strong> {{ $clientDetails['balance_amount'] }}<br>
                                        @endif
                                        @if (!empty($clientDetails['other_details']))
                                            <strong>Other Details:</strong> {{ $clientDetails['other_details'] }}<br>
                                        @endif
                                    @else
                                        No Client Details Available
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-task-button" data-task-id="{{ $task->id }}">Delete</button>
                                </td>
                                
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                
            </div>
        </div>
@endif
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js "></script>
<script defer src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        const taskTypeDropdown = $('#type');
        const clientDropdown = $('#client_id');
        const balanceField = $('#balance_amount');

        // Initially disable Task Type dropdown
        taskTypeDropdown.prop('disabled', true);

        // Enable Task Type when a client is selected
        clientDropdown.on('change', function () {
            const clientId = $(this).val();

            // Reset Task Type and related fields when client changes
            taskTypeDropdown.prop('disabled', clientId === "").val('');
            balanceField.closest('.form-group').hide();
            balanceField.val('');

            $('#client-details').hide().find('input').val('');
            $('#other-textarea').hide().find('textarea').val('');
        });

        // Handle Task Type selection logic
        taskTypeDropdown.on('change', function () {
            const taskType = $(this).val();
            const clientId = clientDropdown.val();

            if (!clientId) {
                alert('Please select a client first.');
                taskTypeDropdown.prop('disabled', true).val('');
                return;
            }

            // Reset all optional fields
            balanceField.closest('.form-group').hide();
            $('#client-details').hide().find('input').val('');
            $('#other-textarea').hide().find('textarea').val('');

            // Logic for Task Type selections
            if (taskType === '2') { // Payment Collection
                balanceField.closest('.form-group').show();
                $.ajax({
                    url: "{{ route('get-client-balance') }}", // route("get-client-balance")', // Replace with the actual route to get-client-balance',
                    method: 'GET',
                    data: { client_id: clientId },
                    success: function (response) {
                        if (response.success) {
                            balanceField.val(response.balance_amount);
                        } else {
                            balanceField.val('Balance not found');
                        }
                    },
                    error: function () {
                        alert('An error occurred while fetching client balance.');
                    }
                });
            } else if (taskType === '1' || taskType === '3') { // Client Visit or Site Visit
                $('#client-details').show();
                $.ajax({
                    url: "{{ route('get-client-details') }}", 
                    method: 'GET',
                    data: { client_id: clientId },
                    success: function (response) {
                        if (response.success) {
                            $('#client_email').val(response.email);
                            $('#client_address').val(response.address);
                            $('#client_phone').val(response.phone);
                        } else {
                            alert('Client details not found.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while fetching client details.');
                    }
                });
            } else if (taskType === '4') { // Others
                $('#other-textarea').show();
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.status-dropdown').on('change', function () {
            const taskId = $(this).data('task-id');
            const newStatus = $(this).val();

            $.ajax({
                url: "{{ route('employee.taskupdatestatus', ':id') }}".replace(':id', taskId),
                type: 'POST',
                data: {
                    status: newStatus,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                success: function (response) {
                    if (response.success) {
                        alert('Status updated successfully!');
                    } else {
                        alert('Failed to update status.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status.');
                }
            });
        });
    });
</script>

<script>
    $(document).on('click', '.delete-task-button', function () {
        let taskId = $(this).data('task-id');
        let button = $(this);
        let url = "{{ route('employeetasks.destroy', ':id') }}".replace(':id', taskId);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message, 'Deleted');
                            // Remove the deleted task's row from the table
                            button.closest('tr').remove();
                        } else {
                            toastr.error('Failed to delete the task. Please try again.', 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred: ' + error, 'Error');
                    }
                });
            }
        });
    });
</script>