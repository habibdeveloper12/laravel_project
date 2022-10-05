@extends('support.layouts.master')



@section('content')

    <div class="container px-4 px-lg-5">
        <div class="row top">
            <style>
                .row a{
                    text-decoration: none
                }
                .top{
                    margin-top: 120px;
                }

                .post-title{
                    font-size: 18px!important;
                }

                @media only screen and (max-width: 991px) {
                }



            </style>

        </div>


        <h3 class="text-center mb-4">All Activity</h3>


        <div class="row justify-content-center">
            <div class="col-md-12 ">

                @foreach($articles as $article)
                <!-- Post preview-->
                <div class="post-preview">
                    <a href="{{route('support-sub-section', $article->sub_section)}}">
                        @php
                          $subsection = \App\Models\SupportSubSection::where('id', $article->sub_section)->first();
                        @endphp
                        <h5 class="post-title">{{$subsection->title}}</h5>
                    </a>
                    <a href="{{route('support-article', $article->slug)}}">
                        <h6 class="post-subtitle">{{ucfirst($article->title)}}</h6>
                    </a>
                    <p class="post-meta">
                       Article created {{ \Carbon\Carbon::parse($article->created_at)->diffForHumans()}}
                    </p>
                </div>
                <!-- Divider-->
                <hr class="my-4" />
                <!-- Post preview-->

                @endforeach

                <!-- Pager-->
                <div class="d-flex justify-content-end mb-4">
                    {{$articles->links('vendor.pagination.bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>


@endsection
