
    <table class="table table-sm" id="product-data" style=" border-radius: 5px;
        background-color: rgba(255,255,255,0.64); ">

        <thead>
        <tr>
            <th class="text-center">SERVER</th>
            <th class="text-center">OFFER TITLE</th>
            <th class="text-center" >RATING</th>
            <th class="text-center">DELIVERY</th>
            <th class="text-center">QUANTITY</th>
            <th class="text-center">PRICE</th>
        </tr>
        </thead>

        @foreach($products as $item)
            <tbody>

            <form action="{{route('payment')}}" method="post">

                <tr>
                    <td>
                        {{ucfirst($item->server)}}
                    </td>
                    <td>
                        <div class="row">
                            <a href="{{route('product.detail', $item->slug)}}">
                                <div class="col-md-12" style="width: 100%">
                                    <input type="hidden" name="product" value="{{$item->title}}">
                                    <input type="hidden" name="slug" value="{{$item->slug}}">
                                    <p><small class="">{!! html_entity_decode($item->summary) !!}</small></p>
                                </div>
                            </a>
                        </div>
                    </td>
                    <td style="min-width: 200px">

                        @php
                            $seller = \App\Models\User::where('username', $item->added_by)->first()
                        @endphp

                        <div class="col-md-4" style="
                            background-image: url('{{$seller->photo == null ? Helper::userDefaultImage() : $seller->photo}}');
                            background-size: cover;
                            background-position: center;
                            border: 2px solid   {{Cache::has('is_online' . $seller->user_id) ? 'green' : 'grey'}};
                            border-radius: 50%;
                            max-width:40px;
                            margin-right: 5px;
                            height:40px;
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
                                    <span class="fa-stack" style="width:13px">
                                                        <i class="far fa-star fa-stack-1x" style="font-size: 10px"></i>
                                                        @if($rating >0)
                                            @if($rating >0.5)
                                                <i class="fas fa-star fa-stack-1x" style="font-size: 10px"></i>
                                            @else
                                                <i class="fas fa-star-half fa-stack-1x" style="font-size: 10px"></i>
                                            @endif
                                        @endif
                                        @php $rating--; @endphp
                                                        </span>
                                @endforeach
                                <span class="fa-stack" style="font-size: 15px">&nbsp;({{\App\Models\UserReview::where('seller_id', $item->user_id)->count()}})</span>


                            </div>
                        </div>
                    </td>
                    <td class="px-5 text-center">
                        {{$item->delivery}}
                        <a href="{{route('product.detail', $item->slug)}}" class="btn btn-outline-primary">
                            View offer
                        </a>
                    </td>
                    <td style="padding-left: 100px!important; min-width: 250px!important;" >
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
                            @if($item->added_by == $user->username)
                                <a href="#"  class="bot btn  mt-0" > Your product</a>
                            @else

                                @csrf
                                <button type="submit" class="bot btn mt-0" >
                                    Buy now</button>
            </form>
            @endif


            @else
                <a href="{{route('user.auth')}}" class="bot btn  mt-0">Buy Now</a>
                @endif
                </td>
                </tr>
            </tbody>
        @endforeach

    </table>

