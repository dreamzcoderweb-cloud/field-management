@php
    use App\Models\Settings;$title = 'Create Task';
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
    <form action="{{route('task.store')}}" method="post" id="taskForm">
        @csrf
        <div class="card shadow">
            <div class="card-body">
              

                <div class="mt-2">
                   
                        <h6>Task</h6>
                    
                    <div class="card-body">
                      
                        <div class="form-group row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="title" class="control-label">Title</label>
                                <input id="title"  class="form-control"
                                       value="{{old('title')}}"/>
                                <span class="text-danger">{{ $errors->first('title', ':message') }}</span>
                            </div>
                          
                            <div class="form-group col-md-3 mb-3">
                                <label for="description" class="control-label">Description</label>
                                <textarea id="description"  class="form-control"
                                       value="{{old('description')}}"/>
                                    </textarea>
                                <span class="text-danger">{{ $errors->first('description', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="description" class="control-label">Client List</label>
                                <select name="client_id" id="client_id" class="form-control">
                                    <option value="1">Choose client</option>
                                   @foreach ($clients as $client)
                                       <option value="{{$client->id}}">{{$client->name}}</option>
                                   @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('type', ':message') }}</span>
                            </div>

                            <div class="form-group col-md-3 mb-3">
                                <label for="description" class="control-label">Task Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="" selected disabled>Choose Task Type</option>
                                    <option value="1">Client Visit</option>
                                    <option value="2">Payment Collection</option>
                                    <option value="3">Site Visit</option>
                                    <option value="4">Others</option>

                                </select>
                                <span class="text-danger">{{ $errors->first('type', ':message') }}</span>
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
   
        $("#taskForm").validate({
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


