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
            margin: 50px auto;
        }
        .crumb-link a{
            text-decoration: none;
        }
        .sub-section a{
            text-decoration: none;
            color: #565252;
        }

        .sub-section p a{
            text-decoration: none;
            color: #4f8118;
        }
        .sub-section p a:hover{
            text-decoration: underline;
        }

        .sub-section a:hover{
            text-decoration: none;
            color: black;
        }
        .cont{
            padding: 0 2%;
        }


        @media only screen and (max-width: 991px) {
            .ord{
                margin-top: 90px !important;
            }
        }
    </style>

    <div class="container ord">
        <div class="row">
            <div class="col-12">
                <i class="crumb-link"><a href="{{route('support')}}"> GG-trade support </a> > </i> <i>{{ucfirst($gen->title)}}</i>
            </div>
        </div>

        <div class="row">
            <div class="col-12 main-section">
                <h2 style="font-weight: bolder">{{ucfirst($gen->title)}}</h2>
            </div>
        </div>

        <div class="row cont">

            @foreach($subsection as $section)
                <div class="col-md-6 col-sm-12 sub-section">
                    <a href="{{route('support-sub-section', $section->id)}}">
                        <h4 style="font-weight: bolder">{{$section->title}}</h4>
                    </a>
                    @foreach($articles as $article)
                        @if($article->sub_section === $section->id)
                            <p>
                                <a href="{{route('support-article', $article->slug)}}">{{ucfirst($article->title)}}</a>
                            </p>
                        @endif
                    @endforeach
                </div>
            @endforeach

        </div>



    </div><!--end container-->

@endsection

@section('scripts')


@endsection

