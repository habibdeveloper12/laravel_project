@extends ('support.layouts.master')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .ord{
            margin-top: 100px ;
            margin-bottom: 20px ;
            padding: 25px;
        }
        .main-section{
            margin: 30px auto;
        }
        .crumb-link a{
            text-decoration: none;
        }
        .crumb-link a:hover{
            text-decoration: underline;
        }
        .user-img{
            @php
                $setting = \App\Models\Settings::first();
            @endphp
           background-image: url("{{$setting->favicon}}");
            height: 60px;
            width: 60px;
            border-radius: 50%;
            border: 1px solid #efefef;
            background-position: center;
            background-size: 40px;
            background-repeat: no-repeat;

        }
        .top-section{
            padding: 10px 30px;
        }
        .body-section{
            padding: 10px 35px;
        }
        .body-end{
            text-align: center;
            margin: 0 30%;
        }
        .body-comment{
            padding: 10px 30px;
        }
        .sty{
            width: 100px;
        }
        .border{
            border: 1px solid red;
        }

        @media only screen and (max-width: 991px) {
            .ord{
                margin-top: 90px !important;
            }
            .aint{
                display: none;
            }
            .ghh{
                width: 70%
            }
            .body-end{
                margin: 0 5%;
            }


        }
    </style>

    <div class="container ord">
        <div class="row">
            <div class="col-12">
                <i class="crumb-link"><a href="{{route('support')}}"> GG-trade support </a> > </i>  <i><a href="{{route('seller.information')}}"> {{$category->title}}</a> > </i> <i>{{$subsection->title}}</i>
            </div>
        </div>

        <div class="row">
            <div class="col-12 main-section">

            </div>
        </div>

        <div class="row" >
            <div class="col-3 aint" style="border-right: 1px solid #efefef">
                <h6 style="font-weight: bold">Articles in this section</h6>
                @foreach($section_article as $art)
                    <p class="crumb-link" style="padding: 0 20px; margin: 5% 0"><a href="{{route('support-article', $art->slug)}}"> {{ucfirst($art->title)}} </a></p>
                @endforeach

            </div>
            <div class="col-md-9 col-sm-12" >
                <h3 style="font-weight: bolder; text-align: center">{{ucfirst($article->title)}}</h3>

                <div class="row top-section">
                    <div class="row col-md-6 col-sm-12">
                        <div class="user-img">
                        </div>

                        <div class="col-md-8 col-sm-12 p-2 ghh">
                            <p style="font-weight: bold; margin: 0">GG-trade Support</p>
                            <i style="font-size: smaller">{{ \Carbon\Carbon::parse($article->created_at)->diffForHumans()}}</i>
                        </div>

                    </div>

                </div>

                <div class="row body-section">
                    {{html_entity_decode($article->description)}}
                </div>

                <hr/>
                <div class="row body-end">
                    <i> Was the article helpful?</i>
                    <div id="reload">
                    <div class="row py-3" >
                        <div class="col-6">
                            <button class="btn btn-outline-primary sty" id="yes" > Yes</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary sty " id="no"  > No</button>
                        </div>
                    </div>
                    <i style="font-size: smaller"> {{$article->like}} out of {{$article->like + $article->dislike}} found this helpful</i>
                    </div>
                    <p class="pt-5">
                        Have more questions <a href="{{route('support.request')}}"><i>submit a request</i></a>.
                    </p>
                </div>

                <hr/>

                <h5 style="font-weight: bold; padding: 0 20px">Comments</h5>
                <div class="row body-comment" @if(count($comments)>3) style="height: 400px; overflow-y: scroll" @endif>

                    @if(count($comments)>0)
                        @foreach($comments as $comment)
                    <div class="row col-12 ml-1 ">
                        <div class="col-1" >
                            <img src="{{Helper::userDefaultImage()}}" style="height: 30px; width: 30px"/>
                        </div>
                        <div class="col-10"> {{\App\Models\User::where('user_id', $comment->user_id)->first()->username}} - {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</div>
                    </div>
                    <div class="row col-12 ml-1 mt-1">
                        <p>{{$comment->comment}} </p>

                        <hr style="border-color: black !important;"/>

                    </div>
                        @endforeach

                    @else
                    <p>0 comment</p>
                    @endif

                </div>
                <hr/>

                @auth
                <div class="col-md-8 col-sm-12" >

                    <form method="post" action="{{route('support.comment.post')}}">
                        @csrf
                        <label>Add a Comment</label>
                        <textarea class="form-control" rows="4" name="comment" required></textarea>
<input type="hidden" name="article_id" value="{{$article->id}}">
                        <button type="submit" class="btn btn-success my-3"; style="width: 100%">Submit</button>
                    </form>
                </div>
                @else
                <i><a href="{{route('user.auth')}}">Sign in </a> to leave a comment</i>
                @endauth
            </div>

        </div>



    </div><!--end container-->

    <script>
        $('#yes').click(function () {
            $.ajax({
                url: "{{route('article.helpful')}}",
                type: "post",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'article_id': '{{$article->id}}',
                    'body': 'yes'
                },
                dataType: 'json',

                success: function (response) {

                    $('#reload').html(response['header']);

                    // You will get response from your PHP page (what you echo or print)
                }, error: function (jqXHR, textStatus, errorThrown) {
                    // console.log(textStatus, errorThrown);
                }
            });

        })


        $('#no').click(function () {
            $.ajax({
                url: "{{route('article.helpful')}}",
                type: "post",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'article_id': '{{$article->id}}',
                    'body': 'no'
                },
                dataType: 'json',

                success: function (response) {
                    $('#reload').html(response['header']);

                    // You will get response from your PHP page (what you echo or print)
                }, error: function (jqXHR, textStatus, errorThrown) {
                    // console.log(textStatus, errorThrown);
                }
            });

        })
    </script>
@endsection


