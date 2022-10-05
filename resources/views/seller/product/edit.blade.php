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
                    <h2 style="color: white;text-transform: uppercase;">E D I T &nbsp;&nbsp;  O F F E R S</h2>
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
                    <div class="card mb-5" style="border-radius: 5px">
                        <form action = "{{route('seller-product.update', $product->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="card-body" >

                                <form class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Game</label>
                                        <select id="brand_id" name="brand_id" class="form-control">
                                            @foreach(\App\Models\Brand::where('status', 'active')->get() as $brand)
                                                <option value="{{$brand->id}}" {{$brand->id == $product->brand_id ? 'selected' : ''}}>{{ucfirst($brand->title)}} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Offer Title</label>
                                        <textarea id="summary" class="form-control"  placeholder="Some text..." name="summary">{{$product->summary}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleTextarea1">Description</label>
                                        <textarea id="description" class="form-control description"  placeholder="Write some text..." name="description">{{$product->description}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label  for="exampleSelect">Category</label>
                                        <select id="cat_id" name="cat_id" class="form-control">
                                            @foreach(\App\Models\Category::where('is_parent', 1)->get() as $cat)
                                                <option value="{{$cat->id}}" {{$cat->id == $product->cat_id ? 'selected' : ''}}>{{ucfirst($cat->title)}} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Stock</label>
                                        <input type="number" name="stock" class="form-control" id="exampleInputName1" placeholder="Stock"  value="{{$product->stock}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Price (€)</label>
                                        <input type="number" name="price" class="form-control" id="exampleInputName1" step="any" placeholder="Price"  value="{{$product->price}}">
                                        <p style="color:rgba(150,16,16,0.81)">Note: Price should be in euro</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Product Image upload</label>
                                        <input type="file" name="photo" class="form-control" >
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
                    $(document).ready(function() {
                        $('.description').summernote();
                    });
                </script>
                <script>

                    var child_cat_id ={{$product->child_cat_id}};
                    $('#cat_id').change(function () {
                        var cat_id = $(this).val();
                        if(cat_id !=null){
                            $.ajax({
                                url:"/admin/category/"+cat_id+"/child",
                                type:"POST",
                                data:{
                                    _token:"{{csrf_token()}}",
                                    cat_id: cat_id,
                                },
                                success:function (response) {
                                    var html_option = "<option value=' '> --- Child Category ----- </option>";
                                    if(response.status){
                                        $('#child_cat_div').removeClass('d-none');
                                        $.each(response.data, function(id,title){
                                            html_option +="<option value='"+ Object.values(title)[0]  +"'  "+(child_cat_id==id ? 'selected' : '') +">" + Object.values(title)[1] + "</option>";
                                        })
                                    }
                                    else{
                                        $('#child_cat_div').addClass('d-none')

                                    }
                                    $('#chil_cat_div').html(html_option);
                                }
                            });
                        };
                    });

                    if(child_cat_id !=null){
                        $('#cat_id').change();
                    }
                </script>

@endsection
