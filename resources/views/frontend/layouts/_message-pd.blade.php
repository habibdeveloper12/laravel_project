<ul class="m-b-0">

    @foreach($messages as $message)


        @if($message->admin_id)
            <style>
                .ghh{
                    background: rgba(30, 90, 222, 0.82);
                    font-size: 14px;
                    color: white;
                    padding: 5px;
                    border-radius: 5px;
                }

                .ghhad{
                    background: rgba(164, 183, 220, 0.82);
                    font-size:14px;
                    color: white;
                    padding: 5px;
                    border-radius: 5px;
                }
            </style>
            <li class="clearfix text-center">
                    @if($message->body == 'gg-trade-new')
                    <div class="ghh">
                        Your order has been received, Seller will contact you shortly.
                    @elseif($message->admin_id == 'note')
                            <div class="ghh">
                        {{$message->body}}
                    @elseif($message->admin_id == 'cancelled')
                                    <div class="ghh" style="background-color: #be3939;">
                        {{$message->body}}
                    @elseif($message->admin_id == 'notes')
                           <div class="ghh" style="background-color: var(--col); color: black">
                           {{$message->body}}
                    @else
                                            <div class="ghh">
                        <div class="ghhad">
                            <h6 style="color: black">Message from Admin</h6>
                            @if($message->file)

                                @if($message->file_type == 'jpg' || $message->file_type == 'png' ||$message->file_type == 'jpeg')
                                    <a href="{{$message->file}}" target="_blank"> <img src="{{$message->file}}" style="max-height: 150px"> </a>
                                @else
                                    <div >
                                        <span class="float-left"  style="color: black"> File Attached: </span>
                                        <style>
                                            a{
                                                color: blue
                                            }

                                            a:hover{
                                                color: red;
                                            }
                                        </style>
                                        <a href="{{$message->file}}" target="_blank" >
                                            <i class="fa fa-paperclip" style="font-size: 20px;"></i> {{$message->filename}}
                                        </a>
                                    </div>
                                @endif


                            @else
                                {{$message->body}}

                            @endif
                        </div>

                    @endif
                </div>
            </li>

        @elseif($message->user_id === 'announce')
            <li class="clearfix">
                <div class="message-data text-center">
                    <span class="message-data-time">{{ date('g:i A, l - d M Y', strtotime($message->created_at)) }}</span>
                </div>

                @if($message->file && $message->body)
                    <style>
                        .announce{
                            font-size: 14px;
                            color: black;
                            padding: 10px;
                            border-radius: 5px;
                        }
                    </style>
                    <div class="announce other-message text-left ">
                        @if($message->file_type == 'jpg' || $message->file_type == 'png' ||$message->file_type == 'jpeg')
                            <p>{{$message->body}}</p>
                            <a href="{{$message->file}}" target="_blank"> <img src="{{$message->file}}" style="max-height: 150px"> </a>

                        @else
                            <div >
                                <p>{{$message->body}} </p>
                                <span class="float-center"  style="color: black; font-weight: bold"> File Attached: </span><br/>
                                <style>
                                    a{
                                        color: blue
                                    }

                                    a:hover{
                                        color: red;
                                    }
                                </style>
                                <a href="{{$message->file}}" target="_blank" >

                                    <i class="fa fa-paperclip" style="font-size: 20px;"></i>
                                    {{$message->filename}}
                                </a>
                            </div>
                        @endif
                    </div>


                @elseif($message->file)
                    <style>
                        .announce{
                            font-size: 14px;
                            color: black;
                            padding: 5px;
                            border-radius: 5px;
                        }
                    </style>
                    <div class="announce other-message text-left ">
                        @if($message->file_type == 'jpg' || $message->file_type == 'png' ||$message->file_type == 'jpeg')
                            <a href="{{$message->file}}" target="_blank"> <img src="{{$message->file}}" style="max-height: 150px"> </a>

                        @else
                            <div >
                                <span class="float-center"  style="color: black; font-weight: bold"> File Attached: </span><br/>
                                <style>
                                    a{
                                        color: blue
                                    }

                                    a:hover{
                                        color: red;
                                    }
                                </style>
                                <a href="{{$message->file}}" target="_blank" >

                                    <i class="fa fa-paperclip" style="font-size: 20px;"></i>
                                    {{$message->filename}}
                                </a>
                            </div>
                        @endif
                    </div>


                @else
                    <div class="announce other-message text-left"> {{$message->body}} </div>

                @endif

            </li>


        @elseif($message->user_id === $user->user_id)
            <li class="clearfix">
                <div class="message-data text-right">
                    <span class="message-data-time">{{ date('g:i A, l - d M Y', strtotime($message->created_at)) }}</span>
                </div>

                @if($message->file)
                    <div class="message other-message float-right">
                        @if($message->file_type == 'jpg' || $message->file_type == 'png' ||$message->file_type == 'jpeg')
                            <a href="{{$message->file}}" target="_blank"> <img src="{{$message->file}}" style="max-height: 150px"> </a>
                        @else
                            <div >
                                <span class="float-left"  style="color: black"> File Attached: </span><br/>
                                <style>
                                    a{
                                        color: blue
                                    }

                                    a:hover{
                                        color: red;
                                    }
                                </style>
                                <a href="{{$message->file}}" target="_blank" >
                                    <i class="fa fa-paperclip" style="font-size: 20px;"></i> {{$message->filename}}
                                </a>
                            </div>
                        @endif
                    </div>

                @else
                    <div class="message other-message float-right"> {{$message->body}} </div>

                @endif

            </li>

        @else
            <li class="clearfix">
                <div class="message-data">
                    <span class="message-data-time">{{ date('g:i A, l - d M Y', strtotime($message->created_at)) }}</span>
                </div>

                @if($message->file)
                    <div class="message my-message">
                        @if($message->file_type == 'jpg' || $message->file_type == 'png' ||$message->file_type == 'jpeg')
                            <a href="{{$message->file}}" target="_blank"> <img src="{{$message->file}}" style="max-height: 150px"> </a>
                        @else
                            <div >
                                <span class="float-left"  style="color: black"> File Attached: </span><br/>
                                <style>
                                    a{
                                        color: blue
                                    }

                                    a:hover{
                                        color: red;
                                    }
                                </style>
                                <a href="{{$message->file}}" target="_blank" >
                                    <i class="fa fa-paperclip" style="font-size: 20px;"></i> {{$message->filename}}
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="message my-message"> {{$message->body}} </div>

                @endif
            </li>
        @endif
    @endforeach

</ul>
