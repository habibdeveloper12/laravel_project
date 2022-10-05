@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<style>
    .ord{
        margin-top: 20px;
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 5px;

    }

    @media only screen and (max-width: 991px) {
        .ord{
            margin-top: 25px;
        }
    }
</style>

@section('content')

    <div class="content">
        <div class="container ord">


    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row mb-2" >
                <div class="col-12 text-center">
                    <h2 style="color: white;text-transform: uppercase;">A D D &nbsp;&nbsp;  O F F E R S</h2>
                    <hr style="border: 2px solid white"/>
                </div>
            </div>

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
                    <div class="card mb-5">
                        <form action = "{{route('seller-product.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <p class="card-description">
                                    Add new offer
                                </p>
                                <form class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Game</label>
                                        <select id="brand_id" name="brand_id" class="form-control">
                                            <option value="0" selected>None</option>

                                        @foreach(\App\Models\Brand::where('status', 'active')->get() as $brand)
                                                <option value="{{$brand->id}}" {{old('brand_id') == $brand->id? 'selected': ''}}>{{ucfirst($brand->title)}} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Offer title</label>
                                        <textarea id="summary" class="form-control"  placeholder="Some text..." name="summary">{{old('summary')}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Description</label>
                                        <textarea id="description" class="form-control description"  placeholder="Write some text..." name="description">{{old('description')}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label  for="exampleSelect">Category</label>
                                        <select id="cat_id" name="cat_id" class="form-control">
                                            @foreach(\App\Models\Category::where('is_parent', 1)->get() as $cat)
                                                <option value="{{$cat->id}}" {{old('cat_id') == $cat->id? 'selected': ''}}>{{ucfirst($cat->title)}} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="cat_name" value="{{\App\Models\Category::where('title', 'powerleveling')->first()->id}}">
                                    </div>

                                    <div class="form-group stock">
                                        <label for="exampleInputName1">Stock</label>
                                        <input type="number" name="stock" class="form-control" id="exampleInputName1" placeholder="Stock"  value="{{old('stock')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Price (€)</label>
                                        <input type="number" name="price" class="form-control" id="exampleInputName1" step="any" placeholder="Price"  value="{{old('price')}}">
                                        <p style="color:rgba(150,16,16,0.81)">Note: Price should be in euro</p>
                                    </div>

                                    <div class="form-group">
                                            <label>Product Image upload</label>
                                            <input type="file" name="photo" class="form-control" >
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
            </div>
        </div>
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
