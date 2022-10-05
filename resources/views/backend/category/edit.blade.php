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
                        <form action = "{{route('category.update',$category->id)}}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <h4 class="card-title">Edit Category</h4>
                                <p class="card-description">
                                    Edit previous categories
                                </p>
                                <form class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Title</label>
                                        <input type="text" name="title" class="form-control" id="exampleInputName1" placeholder="Title" value="{{$category->title}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Summary</label>
                                        <textarea id="summary" class="form-control"  placeholder="Write some text..." name="summary">{{$category->summary}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Rate (%) </label>
                                        <input id="rate" type="number" class="form-control"  value="{{$category->rate_per_purchase}}"  name="rate" >
                                    </div>

                                    <div class="form-group {{$category->is_parent == 1? "d-none": ""}}" id="parent_cat_div">
                                        <label for="exampleSelectGender">Parent Category</label>
                                        <select name="parent_id" class="form-control" id="exampleSelectGender">
                                            <option value="">--Parent Category--</option>
                                            @foreach($parent_cats as $pcats)
                                                <option value="{{$pcats->id}}" {{old('parent_id')==$pcats->id ? 'selected': ''}}>{{$pcats->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label>File upload</label>
                                    <div class="input-group">

                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$category->photo}}">
                                    </div>
                                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>


                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>


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

    <script>
        $('#is_parent').change(function(e){
            e.preventDefault();
            var is_checked = $('#is_parent').prop('checked');

            if(is_checked){
                $('#parent_cat_div').addClass('d-none');
                $('#parent_cat_div').val('');
            }else {
                $('#parent_cat_div').removeClass('d-none');            }

        })
    </script>

@endsection
