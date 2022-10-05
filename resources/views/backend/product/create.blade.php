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
                        <form action = "{{route('product.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">Add Product</h4>
                                <p class="card-description">
                                    Add new product
                                </p>
                                <form class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Game</label>
                                        <select id="title" name="brand_id" class="form-control">
                                            <option value="null" selected> - </option>
                                        @foreach(\App\Models\Brand::where('status', 'active')->get() as $brand)
                                                <option value="{{$brand->id}}" {{old('brand_id') == $brand->id? 'selected': ''}}>{{$brand->title}} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Summary</label>
                                        <textarea id="summary" class="form-control"  placeholder="Some text..." name="summary">{{old('summary')}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Description</label>
                                        <textarea id="description" class="form-control description"  placeholder="Write some text..." name="description">{{old('description')}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Product Image upload</label>
                                        <input type="file" name="photo" class="form-control" >
                                    </div>

                                    <div class="form-group">
                                        <label  for="exampleSelect">Category</label>
                                        <select id="cat_id" name="cat_id" class="form-control">
                                            @foreach(\App\Models\Category::where('is_parent', 1)->get() as $cat)
                                                <option value="{{$cat->id}}" {{old('cat_id') == $cat->id? 'selected': ''}}>{{$cat->title}} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="cat_name" value="{{\App\Models\Category::where('title', 'powerleveling')->first()->id}}">
                                    </div>

                                    <div class="stock form-group">
                                        <label for="exampleInputName1">Stock</label>
                                        <input type="number" name="stock" class="form-control" id="exampleInputName1" placeholder="Stock"  value="{{old('stock')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Price</label>
                                        <input type="number" name="price" class="form-control" id="exampleInputName1" step="any" placeholder="Price"  value="{{old('price')}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleSelect">Sellers</label>
                                        <select name="vendor_id" class="form-control" id="exampleSelect">
                                            @php
                                                $seller = \App\Models\User::where('seller', '1')->get();
                                            @endphp
                                            @foreach($seller as $vendor)
                                                <option value="{{$vendor->user_id}}" {{old('user_id') == $vendor->user_id? 'selected': ''}}>{{$vendor->username}} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelectGender">Server</label>
                                        <select name="server" class="form-control" id="exampleSelectGender">
                                            <option value="none" {{old('server') =='active' ? 'selected' : ''}} >None</option>
                                            <option value="europe" {{old('server') =='inactive' ? 'selected' : ''}} >Europe</option>
                                            <option value="north america" {{old('server') =='active' ? 'selected' : ''}} >North America</option>
                                            <option value="south america" {{old('server') =='active' ? 'selected' : ''}} >South America</option>
                                            <option value="asia" {{old('server') =='inactive' ? 'selected' : ''}} >Asia</option>
                                            <option value="africa" {{old('server') =='active' ? 'selected' : ''}} >Africa</option>
                                            <option value="australia" {{old('server') =='inactive' ? 'selected' : ''}} >Australia</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelectGender">Delivery type</label>
                                        <select name="delivery" class="form-control" id="exampleSelectGender">
                                            <option value="instant" {{old('delivery') =='instant' ? 'selected' : ''}} >Instant Delivery</option>
                                            <option value="1hr" {{old('delivery') =='1hr' ? 'selected' : ''}} >1 hour</option>
                                            <option value="4hr" {{old('delivery')=='4hrs' ? 'selected' : ''}} >4 hours</option>
                                            <option value="1d" {{old('delivery') =='1d' ? 'selected' : ''}} >1 day</option>
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

                <script>
                    $(document).ready(function() {
                        $('#summary').summernote();
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        $('.description').summernote();
                    });
                </script>
                <script>
                    $('#cat_id').change(function () {
                        var cat_id = $(this).val();
                        var id = $('#cat_name').val() ;

                        if(cat_id == id ){
                            $('.stock').hide();
                        }else{
                            $('.stock').show();
                        }

                    });
                </script>

@endsection
