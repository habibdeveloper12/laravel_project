@extends('frontend.layouts.master')

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<style>
    .form-control{
        width: 30% !important;
        text-align: center;
        float: left;
    }
    .minus{
        float: left;
    }
    .plus{
        float: left;
    }
    .bot{
        background-color: var(--col);
        border-color:  var(--col);
        color: black;
        font-size: 12px;
    }
    .bot:hover{
        background-color: #5CB85C;
        color: black;
        border-color: #5CB85C;
    }

    nav .pagination{
        float: right !important;
        margin-bottom: 20px !important;
        color: green;
    }

    .dot {
        height: 70px;
        width: 140px;
        margin: 5px 10px;
        font-size: 13px;
        font-weight: bolder;
        text-align: center;
        padding: 23px 3px;
        color: black;
        border-radius: 5%;
        border: 3px solid #75a222;
        display: inline-block;
    }
    .dot:hover{
        border: 3px solid #15161D;
        color: gray;
    }
    .tp{
        margin: 15px !important;
        padding: 40px 100px;
        border: 2px solid white;
        box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
        border-radius: 5px;
        background-color: rgba(255, 255, 255, .15);
        backdrop-filter: blur(2px);
        color:whitesmoke;
    }


    .head{
        margin: 10px 0px;
        text-align: center;
    }
    #store{
        padding: 30px;
    }
    .hisb{
        display: flex;
    }
    .container1{
        min-height: 1000px;
        margin: 30px auto;
        color: white;
        padding: 0;
        background-color: rgba(73, 71, 71, 0.79);
    }
    .category{
        width: 120px;
        height: 120px;
        margin: 15px 0px;
        line-height: 120px;
        margin-left: 45px;
        border-radius: 100%;
        text-align: center;
        border:4px solid white;
        background-color: #1E1F29;
    }
    .category:hover{
        border: 4px solid var(--col);
    }
    .active{
        background-color: var(--col);
        color: #1E1F29 ;
        border: 4px solid #1E1F29;
    }
    .border1{
        border: 1px solid red;
    }
    .text{
        padding: 10px;
        margin-left: 30px;
    }
    .circle a{
        color: var(--col);
    }

    .circle a:hover{
        color: white;
    }

    @media only screen and (max-width: 991px) {
        .category{
            width: 80px;
            height: 80px;
            line-height: 80px;
            font-size: 10px;
            margin-left: 25px;
        }

    }
</style>
@section('content')
 <div class="container container1">
    <div class="row">
        <div class="head col-md-6 col-sm-12">
            <h1> {{ucfirst($brand->title)}} {{ucfirst($cats->title)}}</h1>
        </div>

        <div class="col-md-9 col-sm-12 text">
            GG-Trade is a player-to-player marketplace where you can buy {{ucfirst($brand->title)}} {{$cats->title}} at the best price.
            All trades are safe and secure due to transactions protection – sellers receive their payment once they fulfill the customer’s order.
            Users are allowed to sell only legally obtained accounts.
        </div>

        <div class="row col-12 circle">
            @foreach($categories as $cat)

            <a href="{{route('shop.games', [$cat->id,$brand->id])}}" >
                <div class="category {{\Request::is('shop-game/'.$cat->id . '/' . $brand->id) || $cats->id == $cat->id ? 'active' : ''}}">
                    {{ucfirst($cat->title)}}
                    <i class="text-center">({{\App\Models\Product::where(['cat_id'=> $cat->id, 'brand_id'=> $brand->id, 'status'=> 'active'])->count()}})</i>
                </div>
            </a>
            @endforeach

        </div>

    </div>


     <div class="row">

         <div id="store" class="col-md-12">
             <!-- store top filter -->
             <div class="store-filter clearfix">
                 <div class="store-sort col-md-12">
                     <div class="col-md-2 col-12"  style="padding: 0">

                         <select name="server" class="input-select"  id="server" style="border-radius: 5px; background-color: rgba(239,239,239,0.72)">
                             <option value="all">Server</option>
                             <option value="all">All</option>
                             <option value="europe" {{old('server') == 'europe' ? 'selected' : ''}}>Europe</option>
                             <option value="north america" {{old('server') == 'north america' ? 'selected' : ''}}>North America</option>
                             <option value="asia" {{old('server') == 'asia' ? 'selected' : ''}}>Asia</option>
                             <option value="africa" {{old('server') == 'africa' ? 'selected' : ''}}>Africa</option>
                             <option value="australia"  {{old('server') == 'australia' ? 'selected' : ''}}>Australia</option>
                             <option value="south america"  {{old('server') == 'south america' ? 'selected' : ''}}>South America</option>
                         </select>
                     </div>

                     <style>
                         .online{
                             border-radius: 5px;
                             padding: 0px;
                             font-size: 13px;
                         }

                         .slider.round {
                             border-radius: 34px;
                         }

                         .slider.round:before {
                             border-radius: 50%;
                         }
                         .switch {
                             position: relative;
                             display: inline-block;
                             width: 30px;
                             height: 20px;
                         }

                         .switch input {
                             opacity: 0;
                             width: 0;
                             height: 0;
                         }
                         .btn-outline-primary{
                             border-color: #0085ED;
                         }

                         .slider {
                             position: absolute;
                             cursor: pointer;
                             top: 0;
                             left: 0;
                             right: 0;
                             bottom: 0;
                             background-color: black;
                             -webkit-transition: .4s;
                             transition: .4s;
                         }

                         .slider:before {
                             position: absolute;
                             content: "";
                             height: 13px;
                             width: 12px;
                             left: 2px;
                             bottom: 4px;
                             background-color: white;
                             -webkit-transition: .4s;
                             transition: .4s;
                         }
                         input:checked + .slider {
                             background-color: rgb(161, 245, 3);
                         }

                         input:focus + .slider {
                             box-shadow: 0 0 1px #a1f503;
                         }

                         input:checked + .slider:before {
                             -webkit-transform: translateX(13px);
                             -ms-transform: translateX(13px);
                             transform: translateX(13px);
                         }


                         @media only screen and (max-width: 991px) {
                             .online {
                                 margin: 10px 0;
                             }
                         }
                     </style>

                     <div class="online col-md-4 col-12">
                         <div class="row"  style="margin: 0; padding: 0; ">
                             <div class="col-8 col-sm-8 col-md-5 " style="background-color: rgba(239,239,239,0.72); border-radius: 5px; border-top-right-radius: 0;border-bottom-right-radius: 0 " >
                                 <p style="padding: 10px 0;margin: 0; color: black "> Online sellers only</p>
                             </div>
                             <div class=""  style="padding: 7px 0; margin: 0; background-color: rgba(239,239,239,0.72); border-radius: 5px; border-top-left-radius: 0;border-bottom-left-radius: 0" >
                                 <label class="switch">
                                     <input id="online" type="checkbox" name="online"   >
                                     <span class="slider round"></span>
                                 </label>
                             </div>
                         </div>

                     </div>


                 </div>

                 @if($user)
                     @if(Auth::user())
                         @if($user->seller)
                         <a type="submit"  data-toggle="modal" data-target="#sell"  class="btn btn-secondary" style=" background-color: #3A994F; float: right; padding: 10px 30px">Sell {{ucfirst($cats->title)}}</a>


                         <div class="modal fade" id="sell" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                             <div class="modal-dialog modal-dialog-centered" role="document" style="max-height: 800px!important;">
                                 <div class="modal-content" >
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLongTitle">Add {{ucfirst($brand->title)}} {{ucfirst($cats->title)}}</h5>
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                         </button>
                                     </div>
                                     <div class="modal-body">
                                         <span id="errors" style="color: red; font-size: 14px; padding: 15px 0!important;"></span>

                                         <form>
                                             <style>
                                                 .g{
                                                     width: 100%;
                                                     border: 1px solid #efefef;
                                                     border-radius: 5px;
                                                     color: black;
                                                 }
                                                 .gg{
                                                     width: 100%;
                                                     height: 40px;
                                                     border: 1px solid #efefef;
                                                     border-radius: 5px;
                                                     color: black;
                                                 }
                                                 label{
                                                     width: 100%;
                                                     color: black;
                                                 }
                                                 .form-group{
                                                 }
                                             </style>

                                             <div class="form-group">
                                                 <label for="exampleTextarea1">Title</label>
                                                 <textarea id="summary" class=" g"  placeholder="Title of offer..." name="summary">{{old('summary')}}</textarea>
                                             </div>

                                             <div class="form-group">
                                                 <label for="exampleTextarea1">Detailed Description</label>
                                                 <textarea id="description" class="gg"  rows="10" placeholder="Describe offer..."  name="description">{{old('description')}}</textarea>
                                             </div>

                                             @if($cats->title != 'powerleveling')

                                                 <div class="form-group stock">
                                                     <label for="exampleInputName1">Stock</label>
                                                     <input type="number" required id="stock" name="stock" class="gg" id="exampleInputName1"  value="{{old('stock')}}">
                                                 </div>

                                             @endif

                                             <div class="form-group">
                                                 <label for="exampleInputName1">Price (€)</label>
                                                 <input type="number" required id="price" name="price" class="gg" id="exampleInputName1" step="any"  value="{{old('price')}}">
                                                 <p style="color:rgba(150,16,16,0.81)">Note: Price should be in euro</p>
                                             </div>

                                             <div class="form-group">
                                                 <label for="exampleSelectGender">Server</label>
                                                 <select name="server" class="gg" id="serverr">
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
                                                 <select name="delivery" class="gg" id="delivery">
                                                     <option value="instant" {{old('delivery') =='instant' ? 'selected' : ''}} >Instant Delivery</option>
                                                     <option value="1hr" {{old('delivery') =='1hr' ? 'selected' : ''}} >1 hour</option>
                                                     <option value="4hr" {{old('delivery')=='4hrs' ? 'selected' : ''}} >4 hours</option>
                                                     <option value="1d" {{old('delivery') =='1d' ? 'selected' : ''}} >1 day</option>
                                                 </select>
                                             </div>

                                             <button type="button" class="btn btn-primary submit mr-2" style="width: 100%">Add Offer</button>
                                         </form>


                                     </div>
                                 </div>
                             </div>
                         </div>
                         @else
                             <a href="{{route('seller-product.index')}}" class="btn btn-secondary" style=" background-color: #3A994F; float: right; padding: 10px 30px">Sell {{ucfirst($cats->title)}}</a>
                         @endif
                     @else

                         <a href="{{route('user.auth')}}" class="btn btn-secondary" style=" background-color: #3A994F; float: right; padding: 10px 30px">Sell {{ucfirst($cats->title)}}</a>

                     @endif

                 @else
                     <a href="{{route('user.auth')}}"  class="btn btn-secondary" style=" background-color: #3A994F; float: right; padding: 10px 30px">Sell {{ucfirst($cats->title)}}</a>
                 @endif

             </div>
             <!-- /store top filter -->

             @if(count($products)>0)
                 <div class="table-responsive" >
                @include('frontend.layouts.shop-game_single-product')
                 </div>

             @else

                 <p style="font-size: 20px; padding: 50px 10px; text-align:center; color: black; font-weight: bold">
                     Not Available!
                 </p>


             @endif

         </div>


     </div>




 </div>


@endsection

@section('scripts')

    <script>
        $('#server').change(function () {
            var server = $('#server').val();

                $.ajax({
                    url: "{{route('shop.server',[$cats->id, $brand->id])}}",
                    type: "post",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'sort': server
                    },
                    dataType: 'json',

                    success: function (response) {
                        if(response['empty']){
                            $('.table-responsive').html('<p style="font-size: 35px; color: white; margin: auto; margin-bottom: 150px"> No Offer Available</p>');
                        }else{
                            $('.table-responsive').html(response['header']);

                        }

                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        if(err){
                            // console.log(err)
                        }
                    }
                });

        });

    </script>

    <script>

        $('#online').change(function () {

            if($(this).prop('checked')) {

                $.ajax({
                    url: "{{route('shop.filter',[$cats->id, $brand->id])}}",
                    type: "post",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'sort': 'online',
                    },

                    dataType: 'json',

                    success: function (response) {

                        if(response['empty']){
                            $('.table-responsive').html('<p style="font-size: 35px; color: white; margin: auto; margin-bottom: 150px"> No Seller Available</p>');
                        }else{
                            $('.table-responsive').html(response['header']);

                        }

                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        if(err){
                            // console.log(err)
                        }
                    }
                });

            } else {

                $.ajax({
                    url: "{{route('shop.filter',[$cats->id, $brand->id])}}",
                    type: "post",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'sort': 'none',

                    },

                    dataType: 'json',

                    success: function (response) {

                        if(response['empty']){
                            $('.table-responsive').html('<p style="font-size: 35px; color: white; margin: auto; margin-bottom: 150px"> No Seller Available</p>');
                        }else{
                            $('.table-responsive').html(response['header']);

                        }

                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        if(err){
                            // console.log(err)
                        }
                    }
                });
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.minus').click(function () {
                var product_id = $(this).data('product-id');
                var product_stock = $(this).data('product-stock');
                var product_qty = document.getElementById('product_quan' + product_id).value;
                let maxxx =  document.getElementById('max_item'+ product_id);

                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                maxxx.style.display = "none"

                return false;



            });

            $('.plus').click(function () {
                var product_id = $(this).data('product-id');
                var product_stock = $(this).data('product-stock');
                var product_qty = document.getElementById('product_quan' + product_id).value;
                let maxxx =  document.getElementById('max_item'+ product_id);

                if(product_qty < product_stock){
                    var $input = $(this).parent().find('input');
                    $input.val(parseInt($input.val()) + 1);
                    $input.change();
                    return false;
                }else{
                    maxxx.style.display = "block";
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"> </script>
    <script src="{{asset('backend/assets/summernote/summernote-bs4.js')}}"></script>

    <script>
        let errors = document.getElementById("errors");
        $('.submit').click(function () {


            $.ajax({
                url: "{{route('post.new.offer',$cats->id )}}",
                type: "post",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'title': $("#title").val(),
                    'summary': $("#summary").val(),
                    'description': $("#description").val(),
                    'stock': $("#stock").val(),
                    'price': $("#price").val(),
                    'server': $("#serverr").val(),
                    'delivery': $("#delivery").val(),
                    'brand_id': '{{$brand->id}}'
                },

                dataType: 'json',

                success: function (response) {
                    if(response){
                        window.location = "{{route('seller-product.index')}}";

                    }
                    // You will get response from your PHP page (what you echo or print)
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");

                    if(err){

                        errors.innerText = err.message + ' Make sure you fill all the fields correctly';
                        console.log(err)
                    }
                }
            });


        })

    </script>

    <script>
        $(document).ready(function() {
            $("#sortTable").DataTable();
        });
    </script>
    <script src="{{asset('backend/assets/js/dataTables.bootstrap4.js')}}"></script>

{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#summary').summernote();--}}
{{--        });--}}

{{--        $(document).ready(function() {--}}
{{--            $('#description').summernote();--}}
{{--        });--}}
{{--    </script>--}}
@endsection

