@extends('backend.layouts.master')


@section('content')


    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <form action = "{{route('brand.store')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">Add Brand</h4>
                                <p class="card-description">
                                    Add new brand
                                </p>
                                <form class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Title</label>
                                        <input type="text" name="title" class="form-control" id="exampleInputName1" placeholder="Title" value="{{old('title')}}">
                                    </div>

                                    <label>File upload <span class="text-danger">*</span></label>
                                    <div class="input-group">

                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="photo">
                                    </div>
                                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>


                                    <div class="form-group">
                                        <label for="exampleSelectGender">Status</label>
                                        <select name="status" class="form-control" id="exampleSelectGender">
                                            <option value="active" {{old('status') =='active' ? 'selected' : ''}} >Active</option>
                                            <option value="inactive" {{old('status') =='inactive' ? 'selected' : ''}} >Inactive</option>
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>

                        </form>

                    </div>
                </div>

                @endsection
            </div>

            @section('scripts')
                <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

                <script>
                    $('#lfm').filemanager('image');
                </script>

                <script>
                    $(document).ready(function() {
                        $('#summary').summernote();
                    });
                </script>

@endsection
