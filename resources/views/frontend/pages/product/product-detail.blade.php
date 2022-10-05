@extends ('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<style>
    .topest{
        padding: 0px 0px 10px 40px;
        background-color: rgba(239,239,239,0.70);
        margin: 0 !important
    }
    @media only screen and (max-width: 991px) {
        .topest {
            padding: 0px 0px 10px 40px;
            margin: 0 !important;

        }
    }
</style>
@section('content')

    <div class="wrap-breadcrumb topest">
        <br/>
        <ul>
            <li class="item-link"><a href="{{route('home')}}" class="link">home</a></li>
            <li class="item-link"><a href="{{route('shop')}}">shop</a></li>
            <li class="item-link"><span>{{\App\Models\Brand::where('id',$product->brand_id)->first()->title}}</span></li>
        </ul>
    </div>

    <!--main area-->
    <main id="main" class="main-site">

        <div class="container" style="background-color: rgba(239,239,239,0.72); border-radius: 5px; margin: 30px auto" >


            <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <br/>
                                <div class="col-12" >
                                    <h2 class="text-center" > {{ucfirst(\App\Models\Brand::where('id',$product->brand_id)->first()->title)}}</h2>
                                    <br/>
                                </div>

                                <div class="col-12 text-center">
                                    <div class="row" style="padding: 0 20px">
                                        <div class="col-lg-4 col-md-4" style="border: 1px solid #efefef; padding: 5px">
                                            <p> GAME : </p>
                                            <h4> {{ucfirst(\App\Models\Brand::where('id',$product->brand_id)->first()->title)}}</h4>
                                        </div>

                                        <div class="col-lg-4 col-md-4 " style="border: 1px solid #efefef; padding: 5px">
                                            <p> SERVER : </p>
                                            <h4> {{ucfirst($product->server)}}</h4>
                                        </div>

                                        @php
                                            $category = \App\Models\Category::where('id', $product->cat_id)->get('title')->first()
                                        @endphp
                                        <div class="col-lg-4 col-md-4" style="border: 1px solid #efefef; padding: 5px">
                                            <p> CATEGORY : </p>
                                            <h4> {{ucfirst($category->title)}}</h4>
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 0 20px">
                                        <div class="col-lg-12 col-md-12" style="border: 1px solid #efefef; padding: 5px">
                                            <p> PRICE : </p>
                                            <h4> {{Helper::currency_converter($product->offer_price)}}</h4>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-12 mt-5">
                                    <div class="row" style="padding: 0 20px">
                                        <br/>
                                        <br/>
                                        <h5 class="col-12">Offer title</h5>
                                        <p style="margin-left: 15px">
                                            {!! html_entity_decode($product->summary) !!}
                                        </p>

                                    </div>
                                    <div class="row" style="padding: 0 20px">
                                        <br/>
                                        <br/>
                                            <h5 class="col-12">Detailed Description </h5>
                                        <p style="margin-left: 15px">
                                            {!! html_entity_decode($product->description) !!}
                                        </p>

                                        </div>
                                    </div>

                                <div class="col-12 mt-5">
                                    <div class="row" style="padding: 0 20px">
                                        <br/>
                                        <br/>
                                        <h5>Quantity </h5>
                                        <hr/>
                                        <div class="number">
                                            <input type="number" name="quantity" id="product_quantity" style="width: 250px" value="1"  min="1" max="{{$product->stock}}" class="form-control"/>
                                            <input type="hidden" name= "slug" value="{{$product->slug}}">
                                            <input type="hidden" name= "product" value="{{$product->title}}">
                                            <div><p style="color: #af8807; font-size: 15px; display: none" id="max_item">Maximum amount of stock reached</p></div>
                                        </div>
                                        <script>
                                            let product_quantity = document.getElementById("product_quantity");
                                            let max = {{$product->stock}};
                                            let maxxx =  document.getElementById("max_item");

                                            product_quantity.addEventListener("change", ()=>{

                                                if(product_quantity.value > max-1){
                                                    maxxx.style.display = "block";
                                                }else{
                                                    maxxx.style.display = "none";
                                                }

                                            });



                                        </script>
                                    </div>
                                </div>


<br/>
                                @if($user)
                                    @if($product->user_id != $user->user_id)
                                    <div class="col-12  mt-5">
                                        <div class="row" style="padding: 0 20px">
                                            <h6>PAYMENT METHOD</h6>

                                            <style>
                                                select {
                                                // A reset of styles, including removing the default dropdown arrow
                                                appearance: none;
                                                // Additional resets for further consistency
                                                background-color: transparent;
                                                    border: none;
                                                    padding: 0 1em 0 0;
                                                    margin: 0;
                                                    width: 100%;
                                                    font-family: inherit;
                                                    font-size: inherit;
                                                    cursor: inherit;
                                                    outline: none;
                                                    line-height: inherit;
                                                }

                                                .select {
                                                    width: 100%;
                                                    max-width: 100%;
                                                    margin-bottom: 10px;
                                                    border: 1px solid #efefef;
                                                    border-radius: 0.25em;
                                                    padding: 0.25em 0.5em;
                                                    font-size: 1.25rem;
                                                    cursor: pointer;
                                                    line-height: 1.1;
                                                    background-color: #fff;
                                                    background-image: linear-gradient(to top, #f9f9f9, #fff 33%);
                                                }
                                            </style>

                                            <div class="select">

                                                <select id="standard-select">
                                                    <option value="null">Not Selected</option>
                                                    <option value="balance">From your funds ({{Helper::currency_converter($user->balance)}})</option>
                                                    <option value="payop">Payop</option>
                                                    <option value="stripe">Stripe</option>
{{--                                                    <option value="przelewy">Przelewy24</option>--}}
{{--                                                    <option value="coinbase">Coinbase</option>--}}
{{--                                                    <option value="skrill">Skrill</option>--}}
                                                </select>
                                            </div>

                                            <div style="height: 25px">
                                                <p id="fund_max"  style="font-size: 13px; font-weight:bold; padding: 0;  color: red;text-align: center"></p>
                                            </div>

                                            <script>
                                                function f() {
                                                    var e = document.getElementById("standard-select");
                                                    var radioValue = e.value;
                                                    var quantity = document.getElementById("product_quantity");

                                                    $.ajax({
                                                        url: "{{route('payment.processing2')}}",
                                                        type: "POST",
                                                        data: {
                                                            '_token': '{{ csrf_token() }}',
                                                            'body': radioValue,
                                                            'product': '{{$product->id}}',
                                                            'quantity': quantity.value
                                                        },
                                                        success: function (response) {

                                                            if(response['error']){

                                                                {{--//You don't have sufficient fund! Your balance is {{Helper::currency_converter($user->balance)}}--}}
                                                                document.getElementById("fund_max").innerHTML = response['error']

                                                                setTimeout(remove , 5000);
                                                                function remove(){
                                                                    document.getElementById("fund_max").innerHTML = ''
                                                                }

                                                            }else{
                                                                if(response['success']){
                                                                    window.location = response['redirect']
                                                                }else{
                                                                    window.location = response;
                                                                }
                                                            }

                                                        }, error: function (jqXHR, textStatus, errorThrown) {
                                                            // console.log(textStatus, errorThrown);

                                                        }

                                                    })

                                                }
                                            </script>
                                            @csrf

                                            <button class="btn btn-primary text-center" onclick="f()" style="width: 100%;">BUY</button>
                                            <p style="color: #6c6a6a; width: 100%; padding-top: 5px">The seller will not be able to receive the payment until you confirm that he has fulfilled his obligations.</p>
                                        </div>
                                    </div>
                                    @endif

                                @else
                                    <div class="col-12  mt-5">
                                        <div class="row" style="padding: 0 20px">
                                            <h6>PAYMENT METHOD</h6>

                                            <style>
                                                select {
                                                // A reset of styles, including removing the default dropdown arrow
                                                appearance: none;
                                                // Additional resets for further consistency
                                                background-color: transparent;
                                                    border: none;
                                                    padding: 0 1em 0 0;
                                                    margin: 0;
                                                    width: 100%;
                                                    font-family: inherit;
                                                    font-size: inherit;
                                                    cursor: inherit;
                                                    outline: none;
                                                    line-height: inherit;
                                                }

                                                .select {
                                                    width: 100%;
                                                    max-width: 80%;
                                                    margin-bottom: 10px;
                                                    border: 1px solid #efefef;
                                                    border-radius: 0.25em;
                                                    padding: 0.25em 0.5em;
                                                    font-size: 1.25rem;
                                                    cursor: pointer;
                                                    line-height: 1.1;
                                                    background-color: #fff;
                                                    background-image: linear-gradient(to top, #f9f9f9, #fff 33%);
                                                }
                                            </style>
                                            <div class="select">
                                                <select id="standard-select">
                                                    <option value="0">Not Selected</option>
                                                    <option value="paypal">PayPal</option>
                                                    <option value="stripe">Stripe</option>
                                                    <option value="przelewy24">Przelewy24</option>
                                                    <option value="coinbase">Coinbase</option>
                                                    <option value="skrill">Skrill</option>
                                                </select>
                                            </div>

                                            <button class="btn btn-primary text-center" style="width: 80%;">BUY</button>
                                            <p style="color: #afabab; width: 80%">The seller will not be able to receive the payment until you confirm that he has fulfilled his obligations.</p>
                                        </div>
                                    </div>

                                @endif

            <style>
                .scll{
                    margin-top: 50px;
                    margin-bottom: 30px;
                    height: 20%;
                    overflow-y: scroll;
                }
               @if(\App\Models\UserReview::where('seller_id', $seller->user_id)->count() < 1)
                   .scll::-webkit-scrollbar{
                   display: none;
               }
                @endif


            </style>

                                <div class="col-12  ">
                                    <h5> SELLER REVIEWS </h5>
                                    <hr/>
                                    <div class="" >
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <h3>Rating Overview</h3>
                                            </div>
                                            <div class=" col-12 text-center">
                                                <h1>{{number_format($seller->avg_rating, 1)}}<small>/5</small></h1>
                                            </div>
                                            <div class=" col-12 text-center">
                                                @php
                                                    $rating = $seller->avg_rating;
                                                @endphp
                                                @foreach(range(1,5) as $i)
                                                    <span class="fa-stack" style="width:12px">
                                            <i class="far fa-star fa-stack-1x"></i>
                                            @if($rating >0)
                                                            @if($rating >0.5)
                                                                <i class="fas fa-star fa-stack-1x" style="color:  #F7D708;"></i>
                                                            @else
                                                                <i class="fas fa-star-half fa-stack-1x" style="font-size: 12px; color: #F7D708;"></i>
                                                            @endif
                                                        @endif
                                                        @php $rating--; @endphp
                                        </span>
                                                @endforeach


                                                <p>{{\App\Models\UserReview::where('seller_id', $seller->user_id)->count()}} ratings</p>
                                            </div>

                                        </div>

                                    </div >
                                    <hr/>


                                    <div class="wrap-review-form scll">
                                        @php
                                            $reviews = \App\Models\UserReview::where('seller_id', $seller->user_id)->latest()->paginate(4);
                                        @endphp
                                        <div id="comments">
                                            @if(count($reviews)>0)
                                                @foreach($reviews as $key=>$review)

                                                    @php
                                                    $reviewer = \App\Models\User::where('user_id', $review->user_id)->first();

                                                    @endphp
                                                    <h2 class="woocommerce-Reviews-title">{{$key+1}} review from <span>{{ucfirst($reviewer->username)}}</span></h2>
                                                    <ol class="commentlist">
                                                        <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-20">
                                                            <div id="comment-20" class="comment_container">
                                                                    <div class="col-3" style="background-image: url('{{$reviewer->photo == null ? Helper::userDefaultImage() : $reviewer->photo}}');
                                                                        background-size: cover; height: 70px; width: 70px; border-radius: 50%; float: left">
                                                                    </div>

                                                                <div class="comment-text col-9">
                                                                    <div class="">
                                                                        @for($i=0; $i < 5; $i++)
                                                                            @if($review->rate > $i)
                                                                                <i class="fa fa-star" style="color: gold" araia-hidden="true"></i>
                                                                            @else
                                                                                <i class="fa fa-star" araia-hidden="true" style="color: #efefef"> </i>
                                                                            @endif

                                                                        @endfor

                                                                    </div>
                                                                    <p class="meta">
                                                                        <strong class="woocommerce-review__author">{{\App\Models\User::where('id', $review->user_id)->value('username')}}</strong>
                                                                        <span class="woocommerce-review__dash">–</span>
                                                                        <time class="woocommerce-review__published-date" datetime="2008-02-14 20:00" >{{\Carbon\Carbon::parse($review->created_at)->format('M, d Y')}}</time>
                                                                    </p>
                                                                    <div class="description">
                                                                        <p style="font-size: 15px;">{{$review->review}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                @endforeach
                                            @endif
                                            {{$reviews->links('vendor.pagination.default')}}
                                        </div>

                                        <div id="review_form_wrapper">
                                            <div id="review_form">
                                                <div id="respond" class="comment-respond">
                                                    @if(!count($reviews)>0)
                                                        <h6 class="text-center text-behance"> No reviews yet</h6>
                                                    @endif


                                                </div><!-- .comment-respond-->
                                            </div><!-- #review_form -->
                                        </div><!-- #review_form_wrapper -->

                                    </div>


                                </div>


                            </div>


                            <div class="col-sm-12 col-lg-6">

                                <style type="text/css">

                                    .card {
                                        background: #fff;
                                        transition: .5s;
                                        border: 1px solid black;
                                        margin-bottom: 30px;
                                        margin-left: 10px;
                                        border-radius: .55rem;
                                        position: relative;
                                        width: 95%;
                                        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
                                    }

                                    .chat-app .chat {
                                        margin-left: 280px;
                                        border-left: 1px solid #eaeaea
                                    }


                                    .chat .chat-header {
                                        padding: 15px 20px;
                                        border-bottom: 2px solid #f4f7f6
                                    }

                                    .chat .chat-header img {
                                        float: left;
                                        border-radius: 40px;
                                        width: 40px
                                    }

                                    .chat .chat-header .chat-about {
                                        float: left;
                                        padding-left: 10px
                                    }

                                    .chat .chat-history {
                                        padding: 20px;
                                        border-bottom: 2px solid #fff
                                    }

                                    .chat .chat-history ul {
                                        padding: 0
                                    }

                                    .chat .chat-history ul li {
                                        list-style: none;
                                        margin-bottom: 30px
                                    }

                                    .chat .chat-history ul li:last-child {
                                        margin-bottom: 0px
                                    }

                                    .chat .chat-history .message-data {
                                        margin-bottom: 15px
                                    }

                                    .chat .chat-history .message-data img {
                                        border-radius: 40px;
                                        width: 40px
                                    }

                                    .chat .chat-history .message-data-time {
                                        color: #434651;
                                        padding-left: 6px
                                    }

                                    .chat .chat-history .message {
                                        color: #444;
                                        padding: 12px 10px;
                                        line-height: 26px;
                                        font-size: 14px;
                                        border-radius: 7px;
                                        display: inline-block;
                                        position: relative
                                    }

                                    .chat .chat-history .message:after {
                                        bottom: 100%;
                                        left: 7%;
                                        border: solid transparent;
                                        content: " ";
                                        height: 0;
                                        width: 0;
                                        position: absolute;
                                        pointer-events: none;
                                        border-bottom-color: #fff;
                                        border-width: 10px;
                                        margin-left: -10px
                                    }

                                    .chat .chat-history .my-message {
                                        background: #efefef
                                    }

                                    .chat .chat-history .my-message:after {
                                        bottom: 100%;
                                        left: 30px;
                                        border: solid transparent;
                                        content: " ";
                                        height: 0;
                                        width: 0;
                                        position: absolute;
                                        pointer-events: none;
                                        border-bottom-color: #efefef;
                                        border-width: 10px;
                                        margin-left: -10px
                                    }

                                    .chat .chat-history .other-message {
                                        background: #e8f1f3;
                                        text-align: right
                                    }

                                    .chat .chat-history .other-message:after {
                                        border-bottom-color: #e8f1f3;
                                        left: 93%
                                    }

                                    .chat .chat-message {
                                        padding: 20px
                                    }

                                    .chat-history {
                                        height: 350px;
                                        overflow-y: scroll;
                                    }
                                    .online,
                                    .offline,
                                    .me {
                                        margin-right: 2px;
                                        font-size: 8px;
                                        vertical-align: middle
                                    }

                                    .online {
                                        color: #86c541
                                    }

                                    .offline {
                                        color: #e47297
                                    }

                                    .me {
                                        color: #1d8ecd
                                    }

                                    .float-right {
                                        float: right
                                    }

                                    .clearfix:after {
                                        visibility: hidden;
                                        display: block;
                                        font-size: 0;
                                        content: " ";
                                        clear: both;
                                        height: 0
                                    }

                                    @media only screen and (max-width: 767px) {

                                        .chat-app .chat {
                                            margin: 0
                                        }
                                        .chat-app .chat .chat-header {
                                            border-radius: 0.55rem 0.55rem 0 0
                                        }
                                        .chat-app .chat-history {
                                            height: 200px;
                                            overflow-x: auto
                                        }
                                    }

                                    @media only screen and (min-width: 768px) and (max-width: 992px) {
                                        .chat-app .chat-list {
                                            height: 30px;
                                            overflow-x: auto
                                        }
                                        .chat-app .chat-history {
                                            height: 30px;
                                            overflow-x: auto
                                        }
                                    }

                                    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
                                        .chat-app .chat-list {
                                            height: 30px;
                                            overflow-x: auto
                                        }
                                        .chat-app .chat-history {
                                            height: 50px;
                                            overflow-x: auto
                                        }
                                    }


                                    @media only screen and (max-width: 991px) {
                                        .card {
                                            margin-top: 50px;
                                            width: 100% !important;
                                            margin-left: 0px;
                                        }

                                    }
                                </style>

                                <div class="container col-sm-12 col-lg-12 mt-2">
                                    <div class="row rowed clearfix ">

                                        <div class="col-12 ">

                                            <div class="card">
                                                @if($user)
                                                @if($product->user_id == $user->user_id)

                                                <p class="p-5">This is your Product!</p>
                                                @else
                                                    <div class="chat" id="fr">
                                                        <div class="chat-header clearfix">
                                                            <div class="row fnn">
                                                                <div class="col-1">
                                                                </div>
                                                                <div class="col-lg-8 col-9 pl-3">

                                                                    @if($seller)
                                                                        <style>
                                                                            .profile-pics{
                                                                                background-image: url('{{$seller->photo == null ? Helper::userDefaultImage() : $seller->photo}}');
                                                                                background-size: cover;
                                                                                width: 55px;
                                                                                height: 55px;
                                                                                border-radius: 50%;
                                                                                float: left;
                                                                            }
                                                                            @media only screen and (max-width: 991px) {

                                                                                .profile-pics{
                                                                                    width: 40px;
                                                                                    height: 40px;
                                                                                }

                                                                            }

                                                                        </style>
                                                                        <a  href="{{route('seller.shop', $seller->username)}}">
                                                                            <div class="profile-pics">
                                                                            </div>

                                                                        <div class="chat-about pt-md-3 pt-sm-0">
                                                                            <h6 class="m-b-0"><a style="color: black" href="{{route('seller.shop', $seller->username)}}">{{$seller->username}}</a></h6>
                                                                            <small>
                                                                                @if(Cache::has('is_online' . $seller->user_id))
                                                                                    <i class="fa fa-circle online text-success"></i> Online
                                                                                @else
                                                                                    left {{ \Carbon\Carbon::parse($seller->last_seen)->diffForHumans() }}
                                                                                @endif
                                                                            </small>
                                                                        </div>
                                                                        </a>
                                                                </div>
                                                                @auth
                                                                <div class="col-lg-3 col-1 " id="subDiv">

                                                                    <style>
                                                                        .hovertext {
                                                                            padding: 10px 10px;
                                                                            border: 1px solid #17A2B8;
                                                                        }
                                                                        .hovertext:before {
                                                                            content: attr(data-hover);
                                                                            visibility: hidden;
                                                                            opacity: 0;
                                                                            width: max-content;
                                                                            background-color: rgba(99, 187, 201, 0.86);
                                                                            padding: 10px 15px;
                                                                            color: black;
                                                                            text-align: center;
                                                                            border-radius: 5px;
                                                                            transition: opacity 1s ease-in-out;
                                                                            white-space: pre-line;

                                                                            position: absolute;
                                                                            z-index: 1;
                                                                            left: -100;
                                                                            top: -50;
                                                                        }
                                                                        .hovertext:hover:before {
                                                                            opacity: 1;
                                                                            visibility: visible;
                                                                        }
                                                                        .fa-bell-o .fa-bell-slash-o{
                                                                            font-size: 25px;
                                                                        }
                                                                        #butt{
                                                                            margin-top: 10px ;
                                                                        }

                                                                        @media only screen and (max-width: 991px) {

                                                                            .hovertext-text {
                                                                                display: none;
                                                                            }

                                                                            .hovertext:before {
                                                                                display: none;
                                                                            }
                                                                            .fa-bell-o .fa-bell-slash-o{
                                                                                font-size: 15px;
                                                                            }
                                                                            #butt{
                                                                                margin-top: 2px;
                                                                                margin-left: -17px;
                                                                            }
                                                                        }

                                                                    </style>
                                                                    <button id="butt" class="hovertext btn btn-outline-info" onclick="{{$subscribe ? 'disableNotifications()' : 'enableNotifications()' }}" data-hover="{{$subscribe ? 'Disable Notification' : 'Enable Notification' }}"><i class="fa {{$subscribe ? 'fa-bell-slash-o' : 'fa-bell-o' }}"> </i> </button>

                                                                    <script>
                                                                        var _registration = null;
                                                                        function registerServiceWorker() {
                                                                            return navigator.serviceWorker.register('../../js/service-worker.js')
                                                                                .then(function(registration) {
                                                                                    console.log('Service worker successfully registered.');
                                                                                    _registration = registration;
                                                                                    return registration;
                                                                                })
                                                                                .catch(function(err) {
                                                                                    console.error('Unable to register service worker.', err);
                                                                                });
                                                                        }
                                                                        function askPermission() {
                                                                            return new Promise(function(resolve, reject) {
                                                                                const permissionResult = Notification.requestPermission(function(result) {
                                                                                    resolve(result);
                                                                                });
                                                                                if (permissionResult) {
                                                                                    permissionResult.then(resolve, reject);
                                                                                }
                                                                            })
                                                                                .then(function(permissionResult) {
                                                                                    if (permissionResult !== 'granted') {
                                                                                        throw new Error('We weren\'t granted permission.');
                                                                                    }
                                                                                    else{
                                                                                        subscribeUserToPush();
                                                                                    }
                                                                                });
                                                                        }
                                                                        function urlBase64ToUint8Array(base64String) {
                                                                            const padding = '='.repeat((4 - base64String.length % 4) % 4);
                                                                            const base64 = (base64String + padding)
                                                                                .replace(/\-/g, '+')
                                                                                .replace(/_/g, '/');
                                                                            const rawData = window.atob(base64);
                                                                            const outputArray = new Uint8Array(rawData.length);
                                                                            for (let i = 0; i < rawData.length; ++i) {
                                                                                outputArray[i] = rawData.charCodeAt(i);
                                                                            }
                                                                            return outputArray;
                                                                        }
                                                                        function getSWRegistration(){
                                                                            var promise = new Promise(function(resolve, reject) {
                                                                                // do a thing, possibly async, then…
                                                                                if (_registration != null) {
                                                                                    resolve(_registration);
                                                                                }
                                                                                else {
                                                                                    reject(Error("It broke"));
                                                                                }
                                                                            });
                                                                            return promise;
                                                                        }
                                                                        function subscribeUserToPush() {
                                                                            getSWRegistration()
                                                                                .then(function(registration) {
                                                                                    console.log(registration);
                                                                                    const subscribeOptions = {
                                                                                        userVisibleOnly: true,
                                                                                        applicationServerKey: urlBase64ToUint8Array(
                                                                                            "{{env('VAPID_PUBLIC_KEY')}}"
                                                                                        )
                                                                                    };
                                                                                    return registration.pushManager.subscribe(subscribeOptions);
                                                                                })
                                                                                .then(function(pushSubscription) {
                                                                                    console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
                                                                                    sendSubscriptionToBackEnd(pushSubscription);
                                                                                    return pushSubscription;

                                                                                });
                                                                        }
                                                                        function sendSubscriptionToBackEnd(subscription) {
                                                                            return fetch('/api/save-subscription/{{Auth::user()->id}}', {
                                                                                method: 'POST',
                                                                                headers: {
                                                                                    'Content-Type': 'application/json',
                                                                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                                                                },
                                                                                body: JSON.stringify(subscription)
                                                                            })
                                                                                .then(function(response) {
                                                                                    if (!response.ok) {
                                                                                        throw new Error('Bad status code from server.');
                                                                                    }
                                                                                    return response.json();
                                                                                })
                                                                                .then(function(responseData) {
                                                                                    if (!(responseData.data && responseData.data.success)) {
                                                                                        throw new Error('Bad response from server.');
                                                                                    }
                                                                                });
                                                                        }
                                                                        async function enableNotifications(){
                                                                            //register service worker
                                                                            //check permission for notification/ask
                                                                            await askPermission();
                                                                            location.reload();
                                                                        }

                                                                        function disableNotifications(){
                                                                            @if($subscribe)
                                                                            $.ajax({
                                                                                url: "{{route('disable.notification')}}",
                                                                                type: "post",
                                                                                data: {
                                                                                    '_token' : '{{ csrf_token() }}',
                                                                                    'body' : 'disable',
                                                                                    'id': '{{$subscribe->id}}'
                                                                                },
                                                                                dataType: 'json',

                                                                                success: function (response) {

                                                                                    location.reload();

                                                                                    // You will get response from your PHP page (what you echo or print)
                                                                                },  error: function(jqXHR, textStatus, errorThrown) {
                                                                                    // console.log(textStatus, errorThrown);
                                                                                }
                                                                            });
                                                                            @endif


                                                                        }

                                                                        registerServiceWorker();
                                                                    </script>
                                                                </div>
                                                                @endauth

                                                            </div>
                                                        </div>
                                                            <style>
                                                                .warning{
                                                                    padding: 10px;
                                                                    text-align: center;
                                                                    color: white;
                                                                    border-radius: 5px;
                                                                    background-color: rgba(255, 128, 0, 0.52);
                                                                }
                                                            </style>
                                                            <div class="warning">
                                                                Don't contact yourself outside this platform. It is against our term & condition
                                                            </div>

                                                        @if($user)


                                                            <div class="chat-history" id="reload">
                                                                    @include('frontend.layouts._message-pd')
                                                            </div>

                                                            <div class="chat-message clearfix">
                                                                <div class="input-group ">
                                                                    <div class="row">
                                                                        <style>
                                                                            .bodi:focus {
                                                                                height:70px !important;
                                                                                transition:0.5s;
                                                                                overflow: hidden;

                                                                            }

                                                                            .bodi{
                                                                                border: 0;
                                                                            }


                                                                            input[type=file]{
                                                                                display: none;
                                                                            }
                                                                            .vv{
                                                                                cursor:pointer;
                                                                                font-size: 25px;
                                                                                padding: 6px 10px;

                                                                            }
                                                                            .sen{
                                                                                padding: 0;
                                                                                margin: 0;
                                                                            }

                                                                            .fa-send{
                                                                                border-radius: 30px;
                                                                                margin-left: -5px;
                                                                                padding: 10px;
                                                                                background-color: #a7e138;
                                                                            }
                                                                            .gg{
                                                                                padding-top: 3px ;
                                                                                padding-left: 1px ;

                                                                            }


                                                                            @media only screen and (max-width: 991px) {
                                                                                .fa-send{
                                                                                    border-radius: 30px;
                                                                                    margin-left: -5px;
                                                                                    padding: 10px;
                                                                                    background-color: #a7e138;

                                                                                }

                                                                            }


                                                                        </style>


                                                                        <input  name="body" id="imageName" class=" bodi form-control col-lg-10 col-sm-9 col-9" placeholder="Enter message here..." required style="background: transparent">

                                                                        <label for="inputTag" class="gg" >
                                                                            <i class="fa fa-paperclip vv"></i>
                                                                            <input type="file" id="inputTag" class="col-lg-1 col-sm-1 col-1">
                                                                        </label>

                                                                        <a id="submit" class="btn sen col-lg-1 col-sm-1 col-1"><i class="fa fa-send"></i></a>
                                                                        <span id="error" style="color: red; font-size: 13px; padding-left: 10px"> </span>

                                                                        <script>
                                                                            let input = document.getElementById("inputTag");
                                                                            let error = document.getElementById("error");
                                                                            var objDiv = document.getElementById("reload");
                                                                            objDiv.scrollTop = objDiv.scrollHeight;


                                                                            let formData = new FormData();


                                                                            input.addEventListener("click", ()=> {
                                                                                error.innerText = '';
                                                                            })


                                                                            input.addEventListener("change", ()=>{

                                                                                let inputImage = document.querySelector("input[type=file]").files[0];

                                                                                if(inputImage.size > 4000000){
                                                                                    error.innerText = 'File too large. Maximum upload is 4MB';
                                                                                    return
                                                                                }

                                                                                formData.append("file", inputImage);
                                                                                formData.append("_token", '{{ csrf_token() }}');
                                                                                formData.append("receiver_id", {{$seller->user_id}});
                                                                                $.ajax({
                                                                                    url: "{{route('message.file')}}",
                                                                                    type: "post",
                                                                                    data:  formData,
                                                                                    contentType: false,
                                                                                    processData: false,
                                                                                    dataType: 'json',

                                                                                    success: function (response) {

                                                                                        error.innerText = response['error'];

                                                                                        if(!response['error']){

                                                                                            $('#reload').html(response['header']);
                                                                                            objDiv.scrollTop = objDiv.scrollHeight;

                                                                                        }

                                                                                        // You will get response from your PHP page (what you echo or print)
                                                                                    },
                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                        // console.log(textStatus, errorThrown);
                                                                                    }
                                                                                });



                                                                            })
                                                                        </script>

                                                                        <script>
                                                                            let hh = document.getElementById("fr");

                                                                            hh.addEventListener('keypress', logKey);

                                                                            function logKey(e) {
                                                                                let enter = `${e.code}`
                                                                                if(enter === 'Enter'){
                                                                                        let receiver = {{$seller->user_id}};
                                                                                        let body = document.getElementById("imageName").value;
                                                                                        if(!body){
                                                                                            error.innerText = 'You did not type any message!';
                                                                                            return;
                                                                                        }

                                                                                        $.ajax({
                                                                                            url: "{{route('message.store')}}",
                                                                                            type: "post",
                                                                                            data: {
                                                                                                '_token' : '{{ csrf_token() }}',
                                                                                                'receiver_id' : receiver,
                                                                                                'body' : body
                                                                                            },
                                                                                            dataType: 'json',

                                                                                            success: function (response) {

                                                                                                error.innerText = response['error'];

                                                                                                if(!response['error']){
                                                                                                    document.getElementById("imageName").value ='';
                                                                                                    $('#reload').html(response['header']);
                                                                                                    objDiv.scrollTop = objDiv.scrollHeight;
                                                                                                }


                                                                                                // You will get response from your PHP page (what you echo or print)
                                                                                            },  error: function(jqXHR, textStatus, errorThrown) {
                                                                                                // console.log(textStatus, errorThrown);
                                                                                            }
                                                                                        });






                                                                                }
                                                                            }

                                                                            let submit = document.getElementById("submit");


                                                                            submit.addEventListener("click", ()=>{
                                                                                let receiver = {{$seller->user_id}};
                                                                                let body = document.getElementById("imageName").value;
                                                                                if(!body){
                                                                                    error.innerText = 'You did not type any message!';
                                                                                    return;
                                                                                }

                                                                                $.ajax({
                                                                                    url: "{{route('message.store')}}",
                                                                                    type: "post",
                                                                                    data: {
                                                                                        '_token' : '{{ csrf_token() }}',
                                                                                        'receiver_id' : receiver,
                                                                                        'body' : body
                                                                                    },
                                                                                    dataType: 'json',

                                                                                    success: function (response) {

                                                                                        error.innerText = response['error'];

                                                                                        if(!response['error']){
                                                                                            document.getElementById("imageName").value ='';
                                                                                            $('#reload').html(response['header']);
                                                                                            objDiv.scrollTop = objDiv.scrollHeight;
                                                                                        }


                                                                                        // You will get response from your PHP page (what you echo or print)
                                                                                    },  error: function(jqXHR, textStatus, errorThrown) {
                                                                                        // console.log(textStatus, errorThrown);
                                                                                    }
                                                                                });



                                                                            })


                                                                        </script>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        @else
                                                            <p style="padding:40% 10%; font-size: 30px; font-weight: bolder">Please <a href="{{route('user.auth')}}">LOGIN</a> to Chat with seller</p>
                                                        @endif

                                                        @endif
                                                    </div>

                                                @endif

                                                @else

                                                    <div class="chat" id="fr">
                                                        <div class="chat-header clearfix">
                                                            <div class="row fnn">
                                                                <div class="col-1">
                                                                </div>
                                                                <div class="col-lg-8 col-9 pl-3">


                                                                    @if($seller)
                                                                        <style>
                                                                            .profile-pics{
                                                                                background-image: url('{{$seller->photo == null ? Helper::userDefaultImage() : $seller->photo}}');
                                                                                background-size: cover;
                                                                                width: 55px;
                                                                                height: 55px;
                                                                                border-radius: 50%;
                                                                                float: left;
                                                                            }
                                                                            @media only screen and (max-width: 991px) {

                                                                                .profile-pics{
                                                                                    width: 40px;
                                                                                    height: 40px;
                                                                                }

                                                                            }

                                                                        </style>
                                                                        <a  href="{{route('seller.shop', $seller->username)}}">
                                                                            <div class="profile-pics">
                                                                            </div>


                                                                        <div class="chat-about pt-md-3 pt-sm-0">
                                                                            <h6 class="m-b-0">{{$seller->username}}</h6>
                                                                            <small>
                                                                                @if(Cache::has('is_online' . $seller->user_id))
                                                                                    <i class="fa fa-circle online text-success"></i> Online
                                                                                @else
                                                                                    left {{ \Carbon\Carbon::parse($seller->last_seen)->diffForHumans() }}
                                                                                @endif
                                                                            </small>
                                                                        </div>
                                                                        </a>
                                                                </div>

                                                                <div class="col-lg-3 col-1 hidden-sm text-right">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($user)
                                                            <div class="chat-history" id="reload">

                                                                @include('frontend.layouts._message-pd')

                                                            </div>

                                                            <div class="chat-message clearfix">
                                                                <div class="input-group ">
                                                                    <div class="row">
                                                                        <style>
                                                                            .bodi:focus {
                                                                                height:70px !important;
                                                                                transition:0.5s;
                                                                                overflow: hidden;

                                                                            }

                                                                            .bodi{
                                                                                border: 0;
                                                                            }


                                                                            input[type=file]{
                                                                                display: none;
                                                                            }
                                                                            .vv{
                                                                                cursor:pointer;
                                                                                font-size: 25px;
                                                                                padding: 6px 10px;

                                                                            }
                                                                            .sen{
                                                                                padding: 0;
                                                                                margin: 0;
                                                                            }

                                                                            .fa-send{
                                                                                border-radius: 30px;
                                                                                margin-left: -5px;
                                                                                padding: 10px;
                                                                                background-color: #a7e138;
                                                                            }
                                                                            .gg{
                                                                                padding-top: 3px ;
                                                                                padding-left: 1px ;

                                                                            }


                                                                            @media only screen and (max-width: 991px) {
                                                                                .fa-send{
                                                                                    border-radius: 30px;
                                                                                    margin-left: -5px;
                                                                                    padding: 10px;
                                                                                    background-color: #a7e138;

                                                                                }

                                                                            }


                                                                        </style>


                                                                        <input  name="body" id="imageName" class=" bodi form-control col-lg-10 col-sm-9 col-9" placeholder="Enter message here..." required style="background: transparent">

                                                                        <label for="inputTag" class="gg" >
                                                                            <i class="fa fa-paperclip vv"></i>
                                                                            <input type="file" id="inputTag" class="col-lg-1 col-sm-1 col-1">
                                                                        </label>

                                                                        <a id="submit" class="btn sen col-lg-1 col-sm-1 col-1"><i class="fa fa-send"></i></a>
                                                                        <span id="error" style="color: red; font-size: 13px; padding-left: 10px"> </span>


                                                                        <script>
                                                                            let input = document.getElementById("inputTag");
                                                                            let error = document.getElementById("error");
                                                                            var objDiv = document.getElementById("reload");
                                                                            objDiv.scrollTop = objDiv.scrollHeight;

                                                                            let formData = new FormData();

                                                                            input.addEventListener("click", ()=> {
                                                                                error.innerText = '';
                                                                            })


                                                                            input.addEventListener("change", ()=>{

                                                                                let inputImage = document.querySelector("input[type=file]").files[0];

                                                                                if(inputImage.size > 4000000){
                                                                                    error.innerText = 'File too large. Maximum upload is 4MB';
                                                                                    return
                                                                                }

                                                                                formData.append("file", inputImage);
                                                                                formData.append("_token", '{{ csrf_token() }}');
                                                                                formData.append("receiver_id", {{$seller->user_id}});
                                                                                $.ajax({
                                                                                    url: "{{route('message.file')}}",
                                                                                    type: "post",
                                                                                    data:  formData,
                                                                                    contentType: false,
                                                                                    processData: false,
                                                                                    dataType: 'json',

                                                                                    success: function (response) {

                                                                                        error.innerText = response['error'];

                                                                                        if(!response['error']){

                                                                                            $('#reload').html(response['header']);
                                                                                            objDiv.scrollTop = objDiv.scrollHeight;

                                                                                        }

                                                                                        // You will get response from your PHP page (what you echo or print)
                                                                                    },
                                                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                                                        // console.log(textStatus, errorThrown);
                                                                                    }
                                                                                });



                                                                            })
                                                                        </script>

                                                                        <script>
                                                                            let submit = document.getElementById("submit");

                                                                            submit.addEventListener("click", ()=>{
                                                                                let receiver = {{$seller->user_id}};
                                                                                let body = document.getElementById("imageName").value;
                                                                                if(!body){
                                                                                    error.innerText = 'You did not type any message!';
                                                                                    return;
                                                                                }

                                                                                $.ajax({
                                                                                    url: "{{route('message.store')}}",
                                                                                    type: "post",
                                                                                    data: {
                                                                                        '_token' : '{{ csrf_token() }}',
                                                                                        'receiver_id' : receiver,
                                                                                        'body' : body
                                                                                    },
                                                                                    dataType: 'json',

                                                                                    success: function (response) {

                                                                                        error.innerText = response['error'];

                                                                                        if(!response['error']){
                                                                                            document.getElementById("imageName").value ='';
                                                                                            $('#reload').html(response['header']);
                                                                                            objDiv.scrollTop = objDiv.scrollHeight;
                                                                                        }


                                                                                        // You will get response from your PHP page (what you echo or print)
                                                                                    },  error: function(jqXHR, textStatus, errorThrown) {
                                                                                        // console.log(textStatus, errorThrown);
                                                                                    }
                                                                                });



                                                                            })


                                                                        </script>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        @else
                                                            <p style="padding:40% 10%; font-size: 30px; font-weight: bolder">Please <a href="{{route('user.auth')}}">LOGIN</a> to Chat with seller</p>
                                                        @endif

                                                        @endif
                                                    </div>


                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

            </div><!--end row-->

        </div><!--end container-->

    </main>
    <!--main area-->


@endsection
