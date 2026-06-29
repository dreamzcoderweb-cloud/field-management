@php
    use App\Models\Settings;
    $title = 'Create Target';
    $settings = Settings::first();
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
    <form action="{{ route('admin.target.store') }}" method="post" enctype="multipart/form-data" id="formValidation">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-2">
                    {{-- <h6> Sale Details</h6> --}}
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name" class="control-label">Target Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="team_id" class="control-label">Team</label>
                                <select id="team_id" name="team_id" class="form-select mb-3">
                                    <option value="">Please select a team</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}"
                                            {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('user_id') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="user_id" class="control-label">Employee</label>
                                <select id="user_id" name="user_id" class="form-select mb-3">
                                    <option value="">Please select a Employee</option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->user_name }}
                                    @endforeach --}}
                                </select>
                                <span class="text-danger">{{ $errors->first('user_id') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="from" class="control-label">From</label>
                                <input type="date" name="from" value="{{ old('from') }}" class="form-control"
                                    min="{{ now()->format('Y-m-d') }}">
                                <span class="text-danger">{{ $errors->first('from') }}</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="to" class="control-label">To</label>
                                <input type="date" name="to" value="{{ old('to') }}" class="form-control"
                                    min="{{ now()->format('Y-m-d') }}">
                                <span class="text-danger">{{ $errors->first('to') }}</span>
                            </div>
                        </div>
                        {{-- <div id="target-rows">
                            <div class="form-group row target-row">
                           
                                <div class="form-group col-md-4 mb-3">
                                    <label class="control-label">Product</label>
                                    <select name="product_id[]" class="form-select mb-3">
                                        <option value="">Please select a Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ collect(old('product_id'))->contains($product->id) ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('product_id.*'))
                                        <span class="text-danger">{{ $errors->first('product_id.*') }}</span>
                                    @endif
                                </div>

                               
                                <div class="form-group col-md-3 mb-3">
                                    <label class="control-label">Target</label>
                                    <input type="text" class="form-control" name="target[]"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);">
                                    @if ($errors->has('target.*'))
                                        <span class="text-danger">{{ $errors->first('target.*') }}</span>
                                    @endif
                                </div>

                               
                                <div class="form-group col-md-3 mb-3">
                                    <label class="control-label">Amount</label>
                                    <input type="text" class="form-control" name="amount[]" value="0" readonly
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 10) this.value = this.value.slice(0, 10);">
                                    @if ($errors->has('amount.*'))
                                        <span class="text-danger">{{ $errors->first('amount.*') }}</span>
                                    @endif
                                </div>

                              
                                <div class="col-md-1 mt-3">
                                    <button type="button" class="btn btn-success form-control add-row">Add</button>
                                </div>
                                <div class="col-md-1 mt-3">
                                    <button type="button" class="btn btn-danger form-control delete-row">Delete</button>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="sale_count" class="control-label">How Many Products Need to Sale?</label>
                                <input type="text" id="sale_count" name="sale_count" class="form-control"
                                    value="{{ old('sale_count') }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 3) this.value = this.value.slice(0, 3);">
                                <span class="text-danger">{{ $errors->first('sale_count') }}</span>
                            </div>
                        </div>

                        <div id="incentive_wrapper" class="form-group row"></div>

                    </div>
                </div>

            </div>

            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.target.index') }}" class="btn btn-danger" style="margin-left: 4px;">Back</a>
            </div>

        </div>

    </form>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $('#sale_count').on('input', function() {
                    let count = parseInt($(this).val()) || 0;
                    let wrapper = $('#incentive_wrapper');
                    wrapper.empty(); // clear old inputs

                    for (let i = 1; i <= count; i++) {
                        wrapper.append(`
                <div class="form-group col-md-3 mb-3">
                    <label class="control-label">Incentive for Target ${i}</label>
                    <input type="text" name="incentive[${i}]" class="form-control"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, ''); 
                        if (this.value.length > 10) this.value = this.value.slice(0, 10);">
                </div>
            `);
                    }
                });
            });
            // Add row
            $('#target-rows').on('click', '.add-row', function() {
                let $clone = $(this).closest('.target-row').clone();
                $clone.find('input:not([readonly])').val('');
                $clone.find('input[readonly]').val('0');
                $clone.find('select').val('');
                $('#target-rows').append($clone);
                updateDeleteButtons();
            });

            // Delete row
            $('#target-rows').on('click', '.delete-row', function() {
                if ($('.target-row').length > 1) {
                    $(this).closest('.target-row').remove();
                    updateDeleteButtons();
                }
            });

            // Update delete buttons initially
            function updateDeleteButtons() {
                $('.delete-row').prop('disabled', $('.target-row').length <= 1);
            }
            updateDeleteButtons();

            // AJAX amount calculation on input
            $('#target-rows').on('input', 'input[name="target[]"]', function() {
                let $row = $(this).closest('.target-row');
                let target = parseFloat($(this).val()) || 0;
                let productId = $row.find('select[name="product_id[]"]').val();

                if (!productId || isNaN(target)) {
                    $row.find('input[name="amount[]"]').val(0);
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.productdetails') }}",
                    type: "GET",
                    data: {
                        productId: productId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let total = parseFloat(response.amount) * target;
                            $row.find('input[name="amount[]"]').val(total.toFixed(2));
                        } else {
                            alert("Something went wrong!");
                            $row.find('input[name="amount[]"]').val(0);
                        }
                    },
                    error: function() {
                        alert("AJAX error!");
                        $row.find('input[name="amount[]"]').val(0);
                    }
                });
            });

            // Optional: Trigger calculation if product changes too
            $('#target-rows').on('change', 'select[name="product_id[]"]', function() {
                let $row = $(this).closest('.target-row');
                $row.find('input[name="target[]"]').trigger('input');
            });

            $('#team_id').on('change', function() {
                let teamId = $(this).val();
                console.log(teamId);
                $.ajax({
                    url: "{{ route('admin.teamMembers') }}",
                    type: "GET",
                    data: {
                        teamId: teamId
                    },
                    dataType: 'json',
                    success: function(response) {
                        let $userSelect = $('#user_id');
                        $userSelect.empty(); // clear existing options
                        $userSelect.append(
                            '<option value="">Please select an Employee</option>');

                        response.users.forEach(function(user) {
                            $userSelect.append(
                                `<option value="${user.id}">${user.user_name}</option>`
                            );
                        });
                    },
                    error: function() {
                        alert("AJAX error!");
                    }
                });
            });
        });
    </script>
@endsection
