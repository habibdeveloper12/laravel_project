

@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">


<style type="text/css">
    body{
        background-image: url({{asset('/frontend/img/bg10.jpg')}});
    }
   .card {
        background: #fff;
        transition: .5s;
        border: 0;
        margin-bottom: 30px;
        border-radius: .55rem;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);

    }
    .chat-app .people-list {
        width: 280px;
        position: absolute;
        left: 0;
        top: 0;
        padding: 20px;
        z-index: 7
    }

    .chat-app .chat {
        margin-left: 280px;
        border-left: 1px solid #eaeaea
    }

    .people-list {
        -moz-transition: .5s;
        -o-transition: .5s;
        -webkit-transition: .5s;
        transition: .5s
    }

    .people-list .chat-list li {
        padding: 10px 15px;
        list-style: none;
        border-radius: 3px
    }

    .people-list .chat-list li:hover {
        background: #efefef;
        cursor: pointer
    }

    .people-list .chat-list li.active {
        background: #efefef
    }

    .people-list .chat-list li .name {
        font-size: 15px
    }

    .people-list .chat-list img {
        width: 45px;
        border-radius: 50%
    }

    .people-list img {
        float: left;
        border-radius: 50%
    }

    .people-list .about {
        float: left;
        padding-left: 8px
    }

    .people-list .status {
        color: #999;
        font-size: 13px
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
        .chat-app .people-list {
            height: 465px;
            width: 100%;
            overflow-x: auto;
            background: #fff;
            left: -400px;
        }
        .chat-app .people-list.open {
            left: 0
        }
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
        .rowed{
            margin-right: -19px !important;
            margin-left: -22px !important;
        }
        .fnn{
            margin-right: 1px !important;
            margin-left: 0px !important;
        }

        .chat .chat-header img {
            margin-left: 15px !important;
        }
        small{
            font-size: 60% !important;
        }
        h6{
            font-size: 15px !important;
        }
        .jun{
            padding: 10px 10px!important;
        }
        .chat-app .chat-list {
            height: calc(100% - 90%);
            overflow-x: visible;
        }
        .chat-app .chat-history {
            height: 300px ;
            overflow-x: visible;
        }
        @if(Request::is('user/message'))
        .chat{
            display: none;
        }

        .chat-app .people-list {
            height: 465px;
            width: 90%;
            margin-left: 20px;
            overflow-x: auto;
            background: #fff;
            left: 0px;
            display: block;
        }
        .rowed{
            margin-bottom: 450px;
        }
        @else

        .chat{
            display: block;
        }

        .chat-app .people-list {

            display: none;
        }

    @endif

}
</style>
@section('content')
    <div class="container col-12 " style="padding-top: 30px; min-height: 800px">
        <div class="row rowed clearfix">


            <div class="col-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                           <h4>Chats</h4>
                            <hr/>
                        </div>


                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            @if(count($users)>0)
                                @foreach($users as $y)

                                @if($y)

                                    @if($y == 'announce')
                                            <a href="{{route('message.show', 'announce')}}">
                                                @php
                                                    $str = 'user/message/announce';
                                                    $setting = \App\Models\Settings::first();
                                                @endphp
                                                <li class="clearfix  @if (request()->is($str))  active @endif ">
                                                    <img src={{$setting->favicon}} alt="avatar" style="height: 40px">
                                                    <div class="about">
                                                        <div class="name">GG-Trade  </div>
                                                        <div class="status">
                                                                <i class="fa fa-bell online text-success"></i> Announcement
                                                        </div>
                                                    </div>
                                                </li>
                                            </a>


                                        @else

                                    <a href="{{route('message.show', $y->user_id)}}">
                                       @php
                                       $str = 'user/message/'.$y->user_id;
                                       @endphp
                                        <li class="clearfix  @if (request()->is($str))  active @endif ">


                                            <div class="" style="background-image: url('{{$y->photo == null ? Helper::userDefaultImage() : $y->photo}}');
                                                background-size: cover;
                                                width: 40px;
                                                height: 40px;
                                                border-radius: 50%;
                                                float: left;
                                                ">
                                            </div>


                                            <div class="about">
                                                <div class="name">{{$y->username}}  </div>
                                                <div class="status">
                                                    @if(Cache::has('is_online' . $y->user_id))

                                                    <i class="fa fa-circle online text-success"></i> Online

                                                @else
                                                        <i class="fa fa-circle offline"></i> offline
                                                @endif

                                                        @foreach($unread_chat as $un)
                                                            @if($un[0]->user_id == $y->user_id)
                                                                <span class="fa fa-circle" style="color: #a7e138; margin-left:70px;">{{count($un)}}</span>
                                                            @endif
                                                        @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                   @endif
                                @endif
                                @endforeach
                            @else
                                <li>No Chat Found!</li>
                            @endif
                        </ul>
                    </div>

                    <div class="chat" id="fr">

                        @if(Request::is('user/message'))
                        <div style="padding: 30%; font-size: 20px">
                            Click on chat to view
                        </div>

                        @else

                        @include('frontend.layouts._message')




                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>


@endsection










