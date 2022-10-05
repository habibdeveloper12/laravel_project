@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>


    .ord{
        margin-top: 20px;
        margin-bottom: 30px;
        background-color: rgba(239,239,239,0.72);
        border-radius: 5px;
    }
    hr {
        border-top: 1px solid black !important;
        margin-top: 0 !important;
    }
    .back-to{
        padding: 15px 40px !important;
    }
    .back-to a{
        text-decoration-line: underline;
    }
    @media only screen and (max-width: 991px) {
        .ord{
            margin-top: 25px;
        }
        .no{
            display: none;
        }
        .back-to{
            padding: 20px 20px!important;
        }
    }
    .border{
        border: 1px solid green;
    }
</style>

@section('content')

    <div class="content">
        <div class="container ord">
            <div class="row">
                <div class="col-md-3 col-sm-2 back-to">
                    <a href="{{route('user.sales')}}"><i class="fa fa-arrow-left"></i> Back <span class="no">to sales page</span></a>
                </div>

                <div class="col-md-6 col-sm-8">
                    <h3 class="ml-sm-1 " style="margin-top: 20px; margin-bottom: 30px; font-size: 30px; text-align: center">Order #{{$order->order_number}}</h3>
                </div>

                <div class="col-3 ">
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12 col-lg-6 ">
                    <div class="col-12">
                    </div>

                    <div class="col-12 text-center mt-5">
                        <div class="row">
                            <div class="col-4">
                                <p> GAME : </p>
                                <h4> {{ucfirst($product->title)}}</h4>
                            </div>

                            @php
                                $category = \App\Models\Category::where('id', $product->cat_id)->get('title')->first()
                            @endphp
                            <div class="col-4">
                                <p> CATEGORY : </p>
                                <h4> {{ucfirst($category->title)}}</h4>
                            </div>
                            <div class="col-4">
                                <p> SERVER : </p>
                                <h4> {{ucfirst($product->server)}}</h4>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 text-center mt-5">
                        <div class="row">

                            <div class="col-6">
                                <p> ORDER STATUS : </p>
                                <h4 class="badge
                            @if($order->condition == 'pending')
                                    bg-warning
@elseif($order->condition == 'delivered')
                                    bg-info
@elseif($order->condition == 'completed')
                                    bg-success
@else
                                    bg-danger
@endif
                                    "> {{ucfirst($order->condition)}}

                                </h4>
                            </div>

                            <div class="col-6">
                                <p> QUANTITY : </p>
                                <h4> {{$order->quantity}}</h4>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 text-center mt-5">
                        <div class="row">
                            <div class="col-6">
                                <p> OPEN : </p>
                                <h4> {{date('d M Y - g:i A ', strtotime($order->created_at))}}</h4>
                            </div>


                            <div class="col-6">
                                <p> TOTAL : </p>
                                <h4> {{Helper::currency_converter($order->total)}}</h4>
                            </div>
                        </div>



                    </div>



                    @php
                        $reviewed = \App\Models\UserReview::where(['order_id' => $order->id, 'reviewer' => \Illuminate\Support\Facades\Auth::user()->user_id])->first()
                    @endphp
                    <div class="col-12 text-center">
                        <hr/>
                        <h5> ACTIONS  </h5>

                        <div class="row">
                            @if($order->condition == 'completed')

                                <style>
                                    .rec{
                                        padding: 10px;
                                        background-color: green;
                                        font-weight: bold;
                                        margin-left: 20px;
                                        width: 100%;
                                        color: white;
                                    }
                                    @media only screen and (max-width: 991px) {
                                        .rec{
                                            margin-right: 20px;
                                        }

                                    }


                                </style>
                                <div class="rec text-center"> <span class="fa fa-check" style="font-size: 20px"></span> ORDER COMPLETED</div>

                            @else

                                <div class="col-lg-2 col-2">

                                </div>
                                <div class="col-lg-8 col-8 border py-3 mb-2">


                                    <form action="{{route('orders.status')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                        <input type="hidden" name="buyer" value="{{$order->user_id}}">
                                        <strong>Status</strong>
                                        <select name="condition" class="form-control mt-1">
                                            <option value="delivered" {{$order->condition == 'cancelled' || $order->condition == 'completed' ? 'disabled' : ''}} {{$order->condition  == 'delivered'? 'selected' : ''}}>Delivered</option>
                                            <option value="cancelled" {{$order->condition == 'delivered' || $order->condition == 'completed' ? 'disabled' : ''}} {{$order->condition  == 'cancelled'? 'selected' : ''}}>Cancel and Refund</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success mt-2"> Update</button>

                                        @if($order->condition  == 'delivered')
                                        <p style="color: black; margin-top: 20px">Note: When order is delivered it cannot be updated again!</p>
                                        @elseif($order->condition  == 'cancelled')
                                        <p style="color: black; margin-top: 20px">Note: When order is cancelled it cannot be updated again!</p>
                                        @endif
                                    </form>


                                </div>
                                <div class="col-lg-2 col-2">

                                </div>
                            @endif



                        </div>


                        @php
                            $curr_note = \App\Models\AdminNotification::where(['order_id' => $order->order_number, 'status' => 'active'])->first()
                        @endphp
                        @if($curr_note)
                            <p style="font-size: 15px">Notification sent!</p>
                            <span class="btn btn-danger "type="button" > ADMIN WILL CONTACT YOU SHORTLY</span>
                        @else
                            <hr style="margin-top: 20px!important;"/>

                            <p style="font-size: 14px; text-align: center">If you have any issue with order</p>

                            <button class="btn btn-danger " style="margin-bottom: 30px" type="button" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-headset"></i> Contact Support</button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLongTitle">Report an Issue</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{route('notify.admin', $order->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-label">Order ID</label>
                                                <input class="form-control" type="text" name="order_id" value="{{$order->order_number}}" required>

                                                <label class="form-label">Describe issue</label>
                                                <textarea rows="5" class="form-control mb-4" name="description" value="" required></textarea>

                                                <label class="form-label">Attach file
                                                    <input type="file" class="form-control mb-4" name="file" style="display: block">
                                                </label>

                                                <button type="submit" class="btn btn-primary" style="width: 100%"> Submit</button>
                                            </form>

                                        </div>


                                    </div>
                                </div>
                            </div>

                        @endif

                    </div>

                    @if($order->condition == 'completed')

                        @if(!$reviewed)
                            <div class="col-12" style="margin-top: 50px">
                                <h5> REVIEW FOR THE BUYER </h5>
                                <hr/>
                                <div class="wrap-review-form">

                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                @auth
                                                    <form action="{{route('user.review', $seller->user_id)}}" method="post" id="commentform" class="comment-form" novalidate="">
                                                        @csrf
                                                        <input type="hidden" name="seller_id" value="{{$user->user_id}}">
                                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                                        <input type="hidden" name="buyer_id" value="{{$seller->user_id}}">

                                                        <div class="comment-form-rating pb-5">
                                                            <span>Buyer rating </span><span style="color: red; font-size: 18px">*</span>
                                                            <p class="stars">
                                                                <label for="rated-1"></label>
                                                                <input type="radio" id="rated-1" name="rate" value="1">
                                                                <label for="rated-2"></label>
                                                                <input type="radio" id="rated-2" name="rate" value="2">
                                                                <label for="rated-3"></label>
                                                                <input type="radio" id="rated-3" name="rate" value="3">
                                                                <label for="rated-4"></label>
                                                                <input type="radio" id="rated-4" name="rate" value="4">
                                                                <label for="rated-5"></label>
                                                                <input type="radio" id="rated-5" name="rate" value="5">
                                                            </p>
                                                        </div>
                                                        @error('rate')
                                                        <p class="text-danger" style="color: red!important;">{{$message}}</p>
                                                        @enderror

                                                        <p class="comment-form-comment">
                                                            <label for="comment">Buyer review
                                                            </label>
                                                            <textarea id="comment" class="mb-2" name="review" cols="45" rows="8" style="width: 80%"></textarea>
                                                        </p>
                                                        @error('review')
                                                        <p class="text-danger">{{$message}}</p>
                                                        @enderror

                                                        <p class="form-submit" style="margin-bottom: 40px">
                                                            <button class= "btn btn-success"  type="submit" id="submit" >PUBLISH REVIEW</button>
                                                        </p>
                                                    </form>
                                                @else
                                                    <p class="py-5">You need to login to write a review. <a href="{{route('user.auth')}}"> Click here! </a> to login</p>
                                                @endif

                                            </div><!-- .comment-respond-->
                                        </div><!-- #review_form -->
                                    </div><!-- #review_form_wrapper -->

                                </div>

                            </div>
                        @else
                            <div class="col-12" style="margin-top: 50px">
                                <div class="row">
                                    <h4 class="col-6" style="padding: 0px 20px">Your Review</h4>
                                    <div class="col-3"></div>
                                    <button class="col-3 btn btn-outline-primary" onclick="switchreview()" style="border: 1px solid #007bff"> <i class="fa fa-edit"></i> Edit Review</button>
                                </div>
                                <div id="comments2" style="display: none" class="wrap-review-form">

                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                @auth
                                                    <form action="{{route('user.review.update', $seller->user_id)}}" method="post" id="commentform" class="comment-form" novalidate="">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{$order->id}}">

                                                        <div class="comment-form-rating pb-5">
                                                            <span>Buyer rating </span><span style="color: red; font-size: 18px">*</span>

                                                            <p class="stars">
                                                                @for($i=1; $i < 6; $i++)
                                                                    @if($reviewed->rate > $i)
                                                                        <label for="rated-{{$i}}"></label>
                                                                        <input type="radio" id="rated-{{$i}}" name="rate" value="{{$i}}">
                                                                    @else
                                                                        <label for="rated-{{$i}}" style="color: red!important;"></label>
                                                                        <input type="radio" id="rated-{{$i}}" name="rate" value="{{$i}}">
                                                                    @endif
                                                                @endfor
                                                            </p>
                                                        </div>
                                                        @error('rate')
                                                        <p class="text-danger" style="color: red!important;">{{$message}}</p>
                                                        @enderror

                                                        <p class="comment-form-comment">
                                                            <label for="comment">Buyer review  </label>
                                                            <textarea id="comment" class="mb-2" name="review" cols="45" rows="8" style="width: 80%">{{$reviewed->review}}</textarea>
                                                        </p>
                                                        @error('review')
                                                        <p class="text-danger">{{$message}}</p>
                                                        @enderror

                                                        <p class="form-submit" style="margin-bottom: 40px">
                                                            <button class= "btn btn-success"  type="submit" id="submit" >UPDATE REVIEW</button>
                                                        </p>
                                                    </form>
                                                @else
                                                    <p class="py-5">You need to login to write a review. <a href="{{route('user.auth')}}"> Click here! </a> to login</p>
                                                @endif

                                            </div><!-- .comment-respond-->
                                        </div><!-- #review_form -->
                                    </div><!-- #review_form_wrapper -->

                                </div>

                                <div id="comments" style="padding: 10px 20px">
                                    <ol class="commentlist">
                                        <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-20">
                                            <div id="comment-20" class="row comment_container">
                                                <div class="col-3" style="background-image: url('{{$user->photo == null ? Helper::userDefaultImage() : $reviewer->photo}}');
                                                    background-size: cover; height: 75px; max-width: 75px; border-radius: 50%; float: left">
                                                </div>
                                                <div class="comment-text col-9">
                                                    <div class="">
                                                        @for($i=0; $i < 5; $i++)
                                                            @if($reviewed->rate > $i)
                                                                <i class="fa fa-star" style="color: gold" araia-hidden="true"></i>
                                                            @else
                                                                <i class="fa fa-star" araia-hidden="true" style="color: #efefef"> </i>
                                                            @endif

                                                        @endfor

                                                    </div>
                                                    <p class="meta">
                                                        <strong class="woocommerce-review__author">{{\App\Models\User::where('id', $user->user_id)->value('username')}}</strong>
                                                        <span class="woocommerce-review__dash">–</span>
                                                        <time class="woocommerce-review__published-date" datetime="2008-02-14 20:00" >{{\Carbon\Carbon::parse($reviewed->created_at)->format('M, d Y')}}</time>
                                                    </p>
                                                    <div class="description">
                                                        <p style="font-size: 15px;"><strong>{{$reviewed->review}}</strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>

                                <script>
                                    function switchreview(){
                                        var x = document.getElementById("comments2");
                                        var y = document.getElementById("comments");

                                        if (x.style.display === "none") {
                                            x.style.display = "block";
                                            y.style.display = "none";

                                        } else {
                                            y.style.display = "block";
                                            x.style.display = "none";
                                        }
                                    }
                                </script>
                            </div>
                        @endif

                    @endif



                </div>

                <div class="col-sm-12 col-lg-6">

                    <style type="text/css">
                        .card {
                            background: #fff;
                            transition: .5s;
                            border: 0;
                            margin-bottom: 30px;
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

                        .chat-history{
                            height: 350px;
                            overflow-y: scroll;



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
                            }

                        }
                    </style>

                    <div class="container col-12 mt-2">
                        <div class="row rowed clearfix ">

                            <div class="col-12 ">
                                <div class="card">
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
                                                        <a style="color: black" href="{{route('seller.shop', $seller->username)}}">

                                                                <div class="profile-pics">
                                                                </div>

                                                        </a>
                                                        <div class="chat-about pt-md-3 pt-sm-0">
                                                            <h6 class="m-b-0"><a style="color: black" href="{{route('seller.shop', $seller->username)}}">{{$seller->username}}</a></h6>
                                                            <small>
                                                                @if(Cache::has('is_online' . $seller->user_id))
                                                                    <i class="fa fa-circle online text-success"></i> Online
                                                                @else
                                                                    left {{ \Carbon\Carbon::parse($seller->last_seen)->diffForHumans()}}
                                                                @endif
                                                            </small>
                                                        </div>
                                                </div>
                                                @endif
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
                                                                        location.reload()

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
                                                        function enableNotifications(){
                                                            //register service worker
                                                            //check permission for notification/ask
                                                            askPermission();
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

                                        <div id="reload" class="chat-history">
                                            @include('frontend.layouts._message-pd')
                                        </div>

                                        <div class="chat-message clearfix">
                                            <div class="input-group mb-0">
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

                                                    <a id="submit1" class="btn sen col-lg-1 col-sm-1 col-1"><i class="fa fa-send"></i></a>
                                                    <span id="error" style="color: red; font-size: 13px; padding-left: 10px"> </span>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"> </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    </script>



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

            let inputImage = document.querySelector("#inputTag").files[0];

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
                    console.log(textStatus, errorThrown);
                }
            });



        })
    </script>

    <script>
        let submit = document.getElementById("submit1");

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
                    console.log(textStatus, errorThrown);
                }
            });



        })


    </script>



    <script>
        $('.cfmBtn').click(function (e) {
            var form = $(this).closest('form');
            var dataID =$(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure Seller has delivered your product?",
                text: "Once confirmed, you will not be able to go back!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Thanks! Order is confirmed!", {
                            icon: "success",
                        });
                    } else {
                        swal("Order not confirmed!");
                    }
                });

        })
    </script>
@endsection


