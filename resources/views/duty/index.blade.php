@php
    $title = 'Tasks';
@endphp
@section('title')
    {{ $title }}
@endsection
@extends('layout')
@section('main-content')
    <style>
        .widget-search .clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #aaa;
        }

        .widget-search input:focus+.clear-search,
        .widget-search input:not(:empty)+.clear-search {
            color: #000;
        }
    </style>
    {{-- <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{ $title }}</h4>
            </div>
        </div>
        <div class="col">
        <div class="float-end">
            <a href="{{route('task.create')}}" class="btn btn-phoenix-primary"><span
                    class="fa fa-plus-circle fa-fw me-2"></span>Create Task</a>
        </div>
    </div>
    </div> --}}

    {{-- Tab Navigation --}}
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

    <div class="card">
        <div class="card-body">
            <form action="" method="GET">
                <div class="d-flex flex-wrap align-items-end gap-2">
                    <div class="flex-fill" style="min-width: 150px;">
                        <label for="from_date">From</label>
                        <input type="date" id="from_date" onchange="form.submit()" name="from_date" class="form-control"
                            value="{{ request('from_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="flex-fill" style="min-width: 150px;">
                        <label for="to_date">To</label>
                        <input type="date" id="to_date" onchange="form.submit()" name="to_date" class="form-control"
                            value="{{ request('to_date') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="flex-fill" style="min-width: 150px;">
                        <label for="status">Status</label>
                        <select onchange="form.submit()" name="status" class="form-control">
                            <option value="">Select status</option>
                            <option value="6" {{ request('status') === '8' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completed</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Closed</option>
                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>In progress</option>
                            <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Re assign</option>
                            <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Hold</option>
                        </select>
                    </div>

                    <div class="flex-fill" style="min-width: 150px;">
                        <label for="type">Type</label>
                        <select onchange="form.submit()" name="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>Task</option>
                            <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>Client Meet</option>
                            <option value="3" {{ request('type') == '3' ? 'selected' : '' }}>Collection</option>
                        </select>
                    </div>

                    <div class="flex-fill" style="min-width: 150px;">
                        <label for="team_id">Team</label>
                        <select onchange="form.submit()" name="team_id" class="form-control">
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ request('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-fill" style="min-width: 150px;">
                        <label for="search">Search</label>
                        <input type="text" value="{{ request('search') }}" class="form-control" name="search"
                            placeholder="Search">
                    </div>

                    <div class="d-grid" style="min-width: 80px;">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="d-grid" style="min-width: 80px;">
                        <label>&nbsp;</label>
                        <a href="{{ route('admin.task.index') }}" class="btn btn-danger w-100">
                            &#10005;
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            {{-- <th>Type</th> --}}
                            <th>Task Detail</th>
                            <th>Assigned to</th>
                            <th>Assigned by</th>
                            <th>Duration</th>
                            <th>Created at</th>
                            <th>Status</th>
                            <th>Action <small class="text-muted">status</small></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($duties) > 0)
                            @foreach ($duties as $duty)
                                <tr>
                                    <td class="ps-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @if ($duty->type == 1)
                                            <span class="badge bg-primary">Task</span>
                                        @elseif ($duty->type == 2)
                                            <span class="badge bg-warning">Client Meet</span>
                                        @elseif ($duty->type == 3)
                                            <span class="badge bg-secondary">Collection</span>
                                        @else
                                            <span class="badge bg-success">Lead</span>
                                        @endif
                                        &nbsp;
                                        @if ($duty->type == 2 && $duty->clientmeet->next_meet != '')
                                            <i class="fa fa-calendar text-success" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Next meet: {{ \Carbon\Carbon::parse($duty->clientmeet->next_meet)->format('d-m-Y') }}">
                                            </i>
                                        @endif

                                        <br>
                                        {{ $duty->title }}
                                        <br>
                                        {{ $duty->description }}
                                    </td>
                                    <td>{{ $duty?->user?->first_name }} {{ $duty?->user?->last_name }}
                                        <br>
                                        {{ $duty?->user?->phone_number }}
                                        @if (isset($duty->team))
                                            <br>
                                            <span class="badge bg-success">{{ $duty?->team?->name }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $duty?->assignedby?->first_name }} {{ $duty?->assignedby?->last_name }}</td>
                                    <td>{{ $duty?->start_date }} <small class="text-muted">to</small>
                                        {{ $duty?->end_date }}
                                    </td>
                                    <td>{{ $duty?->created_at }}
                                    </td>
                                    <td>
                                        @if ($duty->status == 0)
                                            <span class="badge bg-primary">Pending</span>
                                        @elseif ($duty->status == 1)
                                            <span class="badge bg-success">Completed</span>
                                        @elseif ($duty->status == 2)
                                            <span class="badge bg-danger">Closed</span>
                                        @elseif ($duty->status == 3)
                                            <span class="badge bg-secondary">In progress</span>
                                        @elseif ($duty->status == 4)
                                            <span class="badge bg-info">Re assign</span>
                                        @elseif ($duty->status == 5)
                                            <span class="badge bg-warning">Hold</span>
                                        @elseif ($duty->status == 6)
                                            <span class="badge" style="background-color: #ff8e31">Warm</span>
                                        @elseif ($duty->status == 7)
                                            <span class="badge" style="background-color: #31ffff">Cold</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <div class="form-group"> --}}
                                        <select id="status" name="status" class="form-control"
                                            {{ $duty->status == 1 ? 'disabled' : '' }} data-id="{{ $duty?->id }}">
                                            {{-- <option value="">Select Type</option> --}}
                                            @if ($duty->type != 4)
                                                <option value="0" {{ $duty->status === '0' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="1" {{ $duty->status == '1' ? 'selected' : '' }}>
                                                    Completed
                                                </option>
                                                <option value="2" {{ $duty->status == '2' ? 'selected' : '' }}>Closed
                                                </option>
                                                <option value="3" {{ $duty->status == '3' ? 'selected' : '' }}>In
                                                    progress
                                                </option>
                                                <option value="4" {{ $duty->status == '4' ? 'selected' : '' }}>Re
                                                    assign
                                                </option>
                                                <option value="5" {{ $duty->status == '5' ? 'selected' : '' }}>Hold
                                                </option>
                                            @else
                                                <option value="6" {{ $duty->status == '6' ? 'selected' : '' }}>Warm
                                                </option>
                                                <option value="7" {{ $duty->status == '7' ? 'selected' : '' }}>Cold
                                                </option>
                                            @endif
                                        </select>
                                        {{-- </div> --}}
                                    </td>
                                    <td>
                                        {{-- <a href="{{route('product.show', $task->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a> --}}
                                        {{--   <a href="{{route('client.edit', $task->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                --}}
                                        <form action="{{ route('admin.task.destroy', $duty?->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">
                                    <center>No Records Found.</center>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $duties->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('change', '#status', function() {
            let id = $(this).data('id');
            let status = $(this).val();
            console.log(id, "id");
            $.ajax({
                url: "{{ route('admin.updateTaskStatus') }}",
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
