@extends('frontend.layouts.master')

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<style>
    .ord{
        padding: 0px;
        margin: 30px 10%;
        background-color: rgba(73, 71, 71, 0.79);
        min-height: 100px;
        border-radius: 5px;
    }
    .border{
        border: 1px solid red !important;
    }
    .letter{
        color: white;
        text-align: center;
        padding: 10px 0px;
        display: block;
        font-family: CustomFont !important;
    }
    .letter a{
        color: white;
    }
    .heading{
        color: white;
        font-family: CustomFont !important;
    }
    @font-face {
        font-family: "CustomFont";
        src: url({{asset('frontend/font/Controller_W01_Two.ttf')}});
    }
    .heading-item{
        text-align: center!important;
        color: #efefef;
        font-family: CustomFont !important;
    }
    .title{
        font-size: 16px;
        text-align: center!important;
        margin: 0px;
        font-weight: bolder;
        padding: 5px 0;
        font-family: CustomFont !important;

    }
    .title a{
        color: var(--col)!important;
    }
    .title a:hover{
        color: #c0c046 !important;
    }
    .dotter{
        font-size: 2px !important;
        font-weight: bolder;
        color: blue;
    }
    .cats a{
        color: white;
        font-size: 14px;
    }
    .letter-top{
        /*position: fixed;*/

    }
    .cat-head{
        padding-bottom: 1000px;
        overflow-y: scroll!important;
        -webkit-transition: all 0.5s ease;
        -ms-overflow-style: none;
        border-top: 1px solid rgba(35, 35, 35, 0.44);
        scrollbar-width: 1px;
        max-height: 1200px;
        scroll-behavior: smooth;
    }

    .cat-head::-webkit-scrollbar {
        display: none;
    }

    .heading{
        padding: 20px;
        font-size: 20px;
    }
    hr{
        margin: 0 !important;
    }

    @media only screen and (max-width: 991px) {
        .ord{
            margin: 30px 1%;
        }
        .letter-top{
margin-left: 20px;
        }

    }
</style>

@section('content')

    <div class="content ord">

            <div class="row heading">
                <h2 class="heading-item col-12">ALL GAMES</h2>
            </div>

            <div class="row">
                <div class="col-1 letter-top">
                    @foreach($brands_alpha as $key => $value)
                        <div class="letter">
                           <a href="#item{{$key}}">{{$key}}</a>
                        </div>
                    @endforeach

                </div>

                <div class="row col-11 cat-head">

                    @foreach($brands_alpha as $key => $value)
                        <div id="item{{$key}}" class="col-12 heading">
                            {{$key}}
                            <hr/>
                        </div>

                        @foreach($value as $brand)
                            @php
                                $categories_id = App\Models\Product::where(['brand_id'=> $brand->id, 'status' => 'active'])
                                                                    ->where(function ($query){
                                                                        $query->where([['stock', '>', 0]])
                                                                              ->orwhere(['stock' => 'Unlimited']);
                                                                    })
                                                                    ->groupby('cat_id')->get('cat_id');
                                    if(count($categories_id)< 0){
                                        return redirect()->route('shop');
                                    }

                                $categories = $categories_id->map(function ($cat) {
                                    return App\Models\Category::where('id', $cat->cat_id)->first();
                                });
                            @endphp

                            <div class="col-md-2 col-sm-6 mt-3">
                                <h5 class="title"><a href="{{route('shop.game', [$brand->id])}}"> {{$brand->title}} </a></h5>

                                <div class="col-12 cats">
                                    @foreach($categories as $category)
                                    <a href="{{route('shop.games', [$category->id, $brand->id])}}">
                                        {{ucfirst($category->title)}}
                                    </a>
                                    <i class="dotter fa fa-circle"> </i>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    @endforeach
                </div>
            </div>



</div>
        @endsection
    </div>

@section('scripts')

    <script>

        $('.letter-top').on("click", function () {
            var urlHash = window.location.href.split("#")[1];

            if (urlHash &&  $('#' + urlHash).length ){
                $('html,body').animate({
                    scrollTop: $('#' + urlHash).offset().top - $('#' + urlHash).offset().top
                }, 1);
            }
        });
    </script>


@endsection

