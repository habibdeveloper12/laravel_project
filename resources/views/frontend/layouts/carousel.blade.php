
<!-- section title -->
<div class="col-md-12">
    <div class="section-title">
        <style>
            .title-carousel{
                font-family: 'Customont';
                color: white;
                font-size: 20px
            }

            @media only screen and (max-width: 991px) {
                .title-carousel{
                    font-size: 14px
                }
            }

        </style>
        <h4 class="title-carousel">{{\App\Models\Settings::value('carousel_title')}}</h4>
    </div>
</div>
<!-- /section title -->

<!-- Products tab & slick -->
<div class="col-md-12">
    <div class="row">
        <div class="products-tabs">
            <!-- tab -->
            <div id="tab1" class="tab-pane active">
                <div class="products-slick" data-nav="#slick-nav-1">


                @foreach($sellers as $seller)

                        <!-- product -->
                        <div class="product">
                            <div class="product-img" style="height: 250px;
                                background-size: cover;
                                background-position: center;
                            @if($seller->photo)
                                background-image: url('{{$seller->photo}}')
                            @else
                                background-image: url('{{Helper::productDefaultImage()}}')
                            @endif
                                " >
                            </div>
                            <div class="product-body">
                                <h3 class="product-name"><a href="{{route('seller.shop', $seller->username)}}">{{ucfirst($seller->username)}}</a></h3>


                                <div class="row product-rating">

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
                                    &nbsp;({{number_format($seller->avg_rating, 1)}})


                                </div>


                                <div class="product-btns">
                                    <button onclick="location.href='{{route('seller.shop', $seller->username)}}'" class="quick-view" style=".quick-view:hover{ color: red}"><i class="fa fa-eye"></i><span class="tooltipp">view</span></button>
                                </div>
                            </div>

                        </div>
                        <!-- /product -->
                @endforeach

                </div>
                <div id="slick-nav-1" class="products-slick-nav"></div>
            </div>
            <!-- /tab -->
        </div>
    </div>
</div>
<!-- Products tab & slick -->





