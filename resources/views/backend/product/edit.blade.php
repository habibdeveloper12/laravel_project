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
                        <form action = "{{route('product.update', $product->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <h4 class="card-title">Edit Product</h4>
                                <p class="card-description">
                                    Edit product
                                </p>
                                <form class="forms-sample">
                                    <label for="exampleInputName1">Game</label>
                                    <select id="title" name="brand_id" class="form-control">
                                        @foreach(\App\Models\Brand::where('status', 'active')->get() as $brand)
                                            <option value="{{$brand->id}}" {{$brand->id == $product->brand_id? 'selected': ''}}>{{$brand->title}} </option>
                                        @endforeach
                                    </select>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Summary</label>
                                        <textarea id="summary" class="form-control"  placeholder="Some text..." name="summary">{{$product->summary}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Description</label>
                                        <textarea id="description" class="form-control description"  placeholder="Write some text..." name="description">{{$product->description}}</textarea>
                                    </div>


                                    <div class="form-group">
                                        <label>Product Image upload</label>
                                        <input type="file" name="photo" class="form-control" >
                                    </div>

                                    <div class="form-group">
                                        <label  for="exampleSelect">Category</label>
                                        <select id="cat_id" name="cat_id" class="form-control">
                                            @foreach(\App\Models\Category::where('is_parent', 1)->get() as $cat)
                                                <option value="{{$cat->id}}" {{$cat->id == $product->cat_id ? 'selected' : ''}}>{{$cat->title}} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="cat_name" value="{{\App\Models\Category::where('title', 'powerleveling')->first()->id}}">

                                    </div>
                                    <div class="form-group stock">
                                            <label for="exampleInputName1">Stock</label>
                                            <input type="text" name="stock" class="form-control" id="exampleInputName1" placeholder="Stock"  value="{{$product->stock}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputName1">Price</label>
                                        <input type="number" name="price" class="form-control" id="exampleInputName1" step="any" placeholder="Price"  value="{{$product->price}}">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleSelect">Seller</label>
                                        <select name="vendor_id" class="form-control" id="exampleSelect">
                                            @php
                                                $seller = \App\Models\User::where('seller', '1')->get();
                                            @endphp
                                            @foreach( $seller as $vendor)
                                                <option value="{{$vendor->user_id}}" {{$vendor->user_id == $product->user_id ? 'selected' : ''}}>{{$vendor->username}} </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="form-group">
                                        <label for="exampleSelectGender">Server</label>
                                        <select name="server" class="form-control" id="exampleSelectGender">
                                            <option value="none" {{$product->server =='none' ? 'selected' : ''}} >None</option>
                                            <option value="europe" {{$product->server =='europe' ? 'selected' : ''}} >Europe</option>
                                            <option value="north america" {{$product->server =='north america' ? 'selected' : ''}} >North America</option>
                                            <option value="south america" {{$product->server =='south america' ? 'selected' : ''}} >South America</option>
                                            <option value="asia" {{$product->server =='asia' ? 'selected' : ''}} >Asia</option>
                                            <option value="africa" {{$product->server =='africa' ? 'selected' : ''}} >Africa</option>
                                            <option value="australia" {{$product->server =='australia' ? 'selected' : ''}} >Australia</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelectGender">Delivery type</label>
                                        <select name="delivery" class="form-control" id="exampleSelectGender">
                                            <option value="instant" {{$product->delivery =='instant' ? 'selected' : ''}} >Instant Delivery</option>
                                            <option value="1hr" {{$product->delivery =='1hr' ? 'selected' : ''}} >1 hour</option>
                                            <option value="4hr" {{$product->delivery=='4hrs' ? 'selected' : ''}} >4 hours</option>
                                            <option value="1d" {{$product->delivery =='1d' ? 'selected' : ''}} >1 day</option>
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
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

                        if(cat_id == id){
                            $('.stock').hide();
                        }else{
                            $('.stock').show();
                        }

                    });
                </script>

@endsection
