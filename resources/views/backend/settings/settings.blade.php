@extends('backend.layouts.master')


@section('content')


    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-lg-12">
                        @include('backend.layouts.notification')
                    </div>
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
                        <form action = "{{route('settings.update')}}" method="post">
                            @method('put')
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">Edit Settings</h4>
                                <div class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Banner Title</label><span class="text-danger">*</span>
                                        <input type="text" name="banner_title" class="form-control" id="exampleInputName1" placeholder="Title" value="{{$settings->banner_title}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Banner Description</label><span class="text-danger">*</span>
                                        <input type="text" name="banner_description" class="form-control" id="exampleInputName1" placeholder="Title" value="{{$settings->banner_description}}">
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <label>Banner Picture</label><span class="text-danger">*</span>
                                        <div class="input-group">

                                            <span class="input-group-btn">
                                                <a id="lfm5" data-input="thumbnail5" data-preview="holder5" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail5" class="form-control" type="text" name="banner" value="{{$settings->banner}}">
                                        </div>
                                        <div id="holder5" style="margin-top:15px;max-height:100px;"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Carousel Title</label><span class="text-danger">*</span>
                                        <input type="text" name="carousel_title" class="form-control" id="exampleInputName1" placeholder="Title" value="{{$settings->carousel_title}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->meta_keywords}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Meta Description</label>
                                        <textarea rows="5" class="form-control"  name="meta_description" >{{$settings->meta_description}}</textarea>
                                    </div>

                                    <div class="row">

                                       <div class="col-lg-6 col-md-12">
                                           <label>Logo</label><span class="text-danger">*</span>
                                           <div class="input-group">

                                            <span class="input-group-btn">
                                                <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                               <input id="thumbnail1" class="form-control" type="text" name="logo" value="{{$settings->logo}}">
                                           </div>
                                           <div id="holder1" style="margin-top:15px;max-height:100px;"></div>
                                       </div>

                                        <div class="col-lg-6 col-md-12">
                                        <label>Favicon</label>
                                        <div class="input-group">

                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="favicon" value="{{$settings->favicon}}">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                                        </div>
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Email address</label><span class="text-danger">*</span>
                                        <input type="text" name="email" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->email}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Phone number</label><span class="text-danger">*</span>
                                        <input type="text" name="phone" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->phone}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Address</label><span class="text-danger">*</span>
                                        <input type="text" name="address" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->address}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">About</label><span class="text-danger">*</span>
                                        <textarea rows="3" name="about" class="form-control" id="exampleInputName1" placeholder="">{{$settings->about}}</textarea>
                                    </div>


                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <label>Workflow Image</label><span class="text-danger">*</span>
                                        <div class="input-group">

                                        <span class="input-group-btn">
                                            <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                            <input id="thumbnail2" class="form-control" type="text" name="workflow_image" value="{{$settings->workflow_image}}">
                                        </div>
                                        <div id="holder2" style="margin-top:15px;max-height:100px;"></div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <label>Workflow Background</label><span class="text-danger">*</span>
                                        <div class="input-group">

                                        <span class="input-group-btn">
                                            <a id="lfm4" data-input="thumbnail4" data-preview="holder4" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                            <input id="thumbnail4" class="form-control" type="text" name="workflow_background" value="{{$settings->workflow_background}}">
                                        </div>
                                        <div id="holder4" style="margin-top:15px;max-height:100px;"></div>

                                    </div>

                                </div>

                                    <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Facebook URL</label>
                                        <input type="text" name="facebook_url" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->facebook_url}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Twitter URL</label>
                                        <input type="text" name="twitter_url" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->twitter_url}}">
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Instagram URL</label>
                                        <input type="text" name="instagram_url" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->instagram_url}}">
                                    </div>

                                    </div>


                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
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
                    $('#lfm1').filemanager('image');
                    $('#lfm2').filemanager('image');
                    $('#lfm3').filemanager('video');
                    $('#lfm4').filemanager('image');
                    $('#lfm5').filemanager('image');

                </script>

                <script>
                    $(document).ready(function() {
                        $('#description').summernote();
                    });
                </script>

@endsection
