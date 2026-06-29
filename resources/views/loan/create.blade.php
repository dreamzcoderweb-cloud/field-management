@php
    use App\Models\Settings;$title = 'Create Product Category';
    $settings = Settings::first();
@endphp
@section('title')
    {{$title}}
@endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{$title}}</h4>
            </div>
        </div>
        <div class="col">

        </div>
    </div>
    <form action="{{route('loan.store')}}" method="post" id="loanForm">
        @csrf
        <div class="card shadow">
            <div class="card-body">
              

                <div class="card card-primary mt-2">
                    <div class="card-header">
                        <h6>Loan</h6>
                    </div>
                    <div class="card-body">
                      
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="name" class="control-label">Name</label>
                                <input id="name" name="name" class="form-control"
                                       value="{{old('name')}}"/>
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                          
                          
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('scripts')


<script>
   
        $("#loanForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                name: {
                    required: "The name field is required.",
                    minlength: "The name must be at least 3 characters long."
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });

</script>

@endsection
