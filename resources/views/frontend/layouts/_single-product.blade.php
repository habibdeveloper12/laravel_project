<table class="table " id="sortTable" style=" box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
        border-radius: 5px;
        background-color: rgba(239,239,239,0.64)!important;
     ">

    <thead>
    <tr>
        <th class="text-center">OFFER TITLE</th>
        <th class="text-center" >RATING</th>
        <th class="text-center px-3">DELIVERY</th>
        <th class="q">QUANTITY</th>
        <th class="text-center">PRICE</th>
    </tr>
    </thead>

        <style>
            .form-control{
                width: 30%;
                text-align: center;
                float: left;
            }
            .minus{
                float: left;
            }
            .plus{
                float: left;
            }
            .bot{
                background-color: #A7E138;
                border-color: #A7E138;
                color: black;
                font-size: 12px;
            }
            .bot:hover{
                background-color: #5CB85C;
                color: black;
                border-color: #5CB85C;
            }
            .product-rating .fa-star{
                font-size: 12px;
            }

            @media only screen and (max-width: 991px) {
                .q, .pics{
                    display: none;
                }

            }
        </style>
        <form action="{{route('payment')}}" method="post">
            <tbody>

            @foreach($products as $item)

                <tr>
                    <td style="width: 40%">
                        <div class="row">

                            @if($item->photo)
                                <div class="col-md-3 pics" style="
                                    background-image: url('{{$item->photo}}');
                                    margin-left: 10px;
                                    background-size: cover;
                                    background-position: center;
                                    max-width:60px;
                                    max-height:60px;
                                    float: left;
                                    "></div>
                            @else
                                <div class="col-md-3 pics" style="
                                    background-image: url('{{Helper::productDefaultImage()}}');
                                    margin-left: 10px;
                                    background-size: cover;
                                    background-position: center;
                                    max-width:60px;
                                    max-height:60px;
                                    "></div>
                            @endif


                            <div class="col-md-9">
                                <input type="hidden" name="product" value="{{$item->title}}">
                                <input type="hidden" name="slug" value="{{$item->slug}}">
                                <a href="{{route('product.detail', $item->slug)}}">{{ucfirst($item->title)}}</a>
                                <p><small class="">{!! html_entity_decode($item->summary) !!}</small></p>
                            </div>

                        </div>
                    </td>
                    <td class="px-5">

                        @php
                            $seller = \App\Models\User::where('user_id', $item->user_id)->first()
                        @endphp

                        <div class="col-md-4" style="
                            background-image: url('{{$seller->photo == null ? Helper::userDefaultImage() : $seller->photo}}');
                            background-size: cover;
                            background-position: center;
                            border: 1px solid red;
                            border-radius: 50%;
                            max-width:40px;
                            margin-right: 5px;
                            height:40px;
                            float: left;
                            ">
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <a href="{{route('seller.shop', $item->added_by)}}"> {{$item->added_by}}</a>
                            </div>


                            <div class="row product-rating mt-0">

                                @php
                                    $rating = $seller->avg_rating;
                                @endphp
                                @foreach(range(1,5) as $i)
                                    <span class="fa-stack" style="width:12px">
                                <i class="far fa-star fa-stack-1x"></i>
                                @if($rating >0)
                                            @if($rating >0.5)
                                                <i class="fas fa-star fa-stack-1x"></i>
                                            @else
                                                <i class="fas fa-star-half fa-stack-1x" style="font-size: 12px"></i>
                                            @endif

                                        @endif
                                        @php $rating--; @endphp
                            </span>
                                @endforeach
                                <span class="fa-stack" style="font-size: 16px">&nbsp;({{\App\Models\UserReview::where('seller_id', $item->user_id)->count()}})</span>


                            </div>
                        </div>
                    </td>

                    <td class="px-3">
                        {{$item->delivery}}
                    </td>
                    <td class="q px-5">
                        <div class=" row number">
                            <span class="minus btn btn-danger text-center" data-product-id="{{$item->id}}" data-product-stock="{{$item->stock}}">-</span>
                            <input type="text" name="quantity" id="product_quan{{$item->id}}" value="1"  class="form-control"/>
                            <input type="hidden" data-id="{{$item->rowId}}" data-product-quantity="{{$item->stock}}" id="update-{{$item->rowId}}">
                            <span class="plus btn btn-danger" data-product-id="{{$item->id}}"  data-product-stock="{{$item->stock}}">+</span>
                        </div>
                        <div class="row"><p style="color: #af8807; font-size: 12px; display: none" id="max_item{{$item->id}}">Maximum amount of stock reached</p></div>

                    </td>
                    <td>
                        <p class="text-center" style="font-weight: bolder">{{Helper::currency_converter($item->offer_price)}}</p>
                        @if($user)
                            @if($item->user_id == $user->user_id)
                                <a href="#"  class="bot btn mt-0" > Your product</a>
                            @else

                                @csrf
                                <button type="submit" class="bot btn btn-primary mt-0" >Buy now</button>
                            @endif


                        @else
                            <a href="{{route('user.auth')}}" class="bot btn btn-primary mt-0"><i class="fa fa-money"></i> &nbsp;Buy Now</a>
                        @endif
                    </td>
                </tr>


            @endforeach

            </tbody>

        </form>

</table>




