@extends('backend.layouts.master')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>

                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body row">
                            <div class="col-md-12 col-12">


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
                                                width:  100% !important;
                                            }

                                        }


                                    </style>

                                    <div class="col-12">

                                                <h3 class="py-4"> Chat with blacklisted Word</h3>

                                                <div class="card" style="border: 1px solid black;">
                                                    <div class="chat" id="fr">
                                                        <div class="chat-header clearfix">
                                                            <div class="row fnn">
                                                                <div class="col-lg-4 col-12 ">

                                                                    @if($buyer)
                                                                        <a style="color: black" href="{{route('seller.shop', $buyer->username)}}">
                                                                            @if($buyer->photo)
                                                                                <img src="{{$buyer->photo}}" alt="avatar">

                                                                            @else
                                                                                <img src={{Helper::userDefaultImage()}} alt="avatar">
                                                                            @endif
                                                                        </a>
                                                                        <div class="chat-about">
                                                                            <h6 class="m-b-0"><a style="color: black" href="{{route('seller.shop', $buyer->username)}}">{{$buyer->username}}</a></h6>
                                                                            <small>
                                                                                @if(Cache::has('is_online' . $buyer->user_id))
                                                                                    <i class="fa fa-circle online text-success"></i> Online
                                                                                @else
                                                                                    left {{ \Carbon\Carbon::parse($seller->last_seen)->diffForHumans()}}
                                                                                @endif
                                                                            </small>
                                                                        </div>
                                                                </div>
                                                                @endif

                                                                <div class="col-lg-4 col-12">
                                                                    <p></p>
                                                                </div>

                                                                <div class="col-lg-4 col-12">

                                                                    @if($seller)
                                                                        <a style="color: black" href="{{route('seller.shop', $seller->username)}}">
                                                                            @if($seller->photo)
                                                                                <img src="{{$seller->photo}}" alt="avatar">

                                                                            @else
                                                                                <img src={{Helper::userDefaultImage()}} alt="avatar">
                                                                            @endif
                                                                        </a>
                                                                        <div class="chat-about">
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
                                                                <div class="col-lg-3 col-1 hidden-sm text-right">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="reload" class="chat-history">
                                                            @include('backend.layouts._message-backend')
                                                        </div>

                                                        <div class="chat-message clearfix">
                                                            <div class="input-group mb-0">
                                                                <div class="row col-12">
                                                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                                                                    <style>
                                                                        .bodi:focus {
                                                                            height:70px !important;
                                                                            transition:0.5s;
                                                                            overflow: hidden;

                                                                        }

                                                                        .bodi{
                                                                            border: 1px solid #efefef;
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
                                                                            cursor:pointer !important;
                                                                            font-size: 25px;
                                                                            padding: 6px 10px;
                                                                        }
                                                                        .gg{
                                                                            padding-top: 3px ;
                                                                            padding-left: 1px ;

                                                                        }


                                                                        @media only screen and (max-width: 991px) {
                                                                            .fa-send{
                                                                                border-radius: 30px;
                                                                                margin-left: -5px;
                                                                                font-size: 14px;
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

                                                                <script>
                                                                    let hh = document.getElementById("fr");

                                                                    hh.addEventListener('keypress', logKey);

                                                                    function logKey(e) {
                                                                        let enter = `${e.code}`
                                                                        if(enter === 'Enter'){
                                                                            let user = {{$buyer->user_id}};
                                                                            let receiver = {{$seller->user_id}};
                                                                            let body = document.getElementById("imageName").value;
                                                                            if(!body){
                                                                                error.innerText = 'You did not type any message!';
                                                                                return;
                                                                            }

                                                                            $.ajax({
                                                                                url: "{{route('admin.message.store.v')}}",
                                                                                type: "post",
                                                                                data: {
                                                                                    '_token' : '{{ csrf_token() }}',
                                                                                    'user_id': user,
                                                                                    'receiver_id' : receiver,
                                                                                    'body' : body
                                                                                },
                                                                                dataType: 'json',

                                                                                success: function (response) {

                                                                                    error.innerText = response['error'];
                                                                                    console.log(response)

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

                                                                        let inputImage = document.querySelector("input[type=file]").files[0];

                                                                        if(inputImage.size > 4000000){
                                                                            error.innerText = 'File too large. Maximum upload is 4MB';
                                                                            return
                                                                        }

                                                                        formData.append("file", inputImage);
                                                                        formData.append("_token", '{{ csrf_token() }}');
                                                                        formData.append("receiver_id", {{$seller->user_id}});
                                                                        formData.append("user_id", {{$buyer->user_id}});

                                                                        $.ajax({
                                                                            url: "{{route('admin.message.file.v')}}",
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
                                                                        let user = {{$buyer->user_id}};
                                                                        let receiver = {{$seller->user_id}};
                                                                        let body = document.getElementById("imageName").value;
                                                                        if(!body){
                                                                            error.innerText = 'You did not type any message!';
                                                                            return;
                                                                        }

                                                                        $.ajax({
                                                                            url: "{{route('admin.message.store')}}",
                                                                            type: "post",
                                                                            data: {
                                                                                '_token' : '{{ csrf_token() }}',
                                                                                'user_id': user,
                                                                                'receiver_id' : receiver,
                                                                                'body' : body
                                                                            },
                                                                            dataType: 'json',

                                                                            success: function (response) {

                                                                                error.innerText = response['error'];
                                                                                console.log(response)

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
        @endsection
    </div>
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $.ajaxSetup({
            header: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $('.dltBtn').click(function (e) {
            var form = $(this).closest('form');
            var dataID =$(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });

        })
    </script>
@endsection

