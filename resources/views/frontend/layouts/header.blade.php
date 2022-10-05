<style>

    .trustpilot-widget a:hover{
        color: #7e7b7b;
    }
    @media only screen and (max-width: 991px) {
        .dropdown{
            display: none!important;
        }
        .jj{
            display: none;
        }
}
</style>

<div id="th">
<!-- TOP HEADER -->
    <div id="top-header">

				<div class="container">
					<ul class="header-links pull-right ">
						<li class="menu-item">
							<div class="dropdown">
								<button class="dropbtn">
                                    <a title="English" href="#">
                                        <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </a>
                                </button>
                                <div class="dropdown-content">
                                    @foreach (Config::get('languages') as $lang => $language)
                                        @if ($lang != App::getLocale())
									<a title="" href="{{ route('lang.switch', $lang) }}"><span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
{{--									<a title="german" href="#"><span class="img label-before"><img src="{{asset('frontend/img/lang-ger.png')}}" alt="lang-ger" ></span>&nbsp German</a>--}}
{{--									<a title="french" href="#"><span class="img label-before"><img src="{{asset('frontend/img/lang-fra.png')}}" alt="lang-fre"></span>&nbsp French</a>--}}
                                        @endif
                                    @endforeach

                                </div>
							</div>
						</li>
						<li class="menu-item" >
							<div class="dropdown">
                                @php
                                    Helper::currency_load();
                                    $currency_code = session('currency_code');
                                    $currency_symbol = session('currency_symbol');

                                    if($currency_symbol == ""){
                                            $system_default_currency_info = session('system_default_currency_info');
                                            $currency_symbol = $system_default_currency_info->symbol;
                                            $currency_code = $system_default_currency_info->code;
                                    }
                                    $user = Auth::user();
                                            $categories = \App\Models\Category::where(['status'=>'active', 'is_parent'=>1])->limit('9')->orderBy('id','DESC')->get();

                                @endphp
								<button class="dropbtn"><a href="#">{{$currency_symbol}} {{\Illuminate\Support\Str::upper($currency_code)}} &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></a></button>
								<div class="dropdown-content">
                                    @foreach(\App\Models\Currency::where('status', 'active')->get() as $currency)
									<a class="dropdown-item" href="javascript:;" onclick="currency_change('{{$currency['code']}}')"> {{$currency->symbol}} {{\Illuminate\Support\Str::upper($currency->code)}}</a>
                                    @endforeach
                                </div>
							</div>
						</li>

                        @if(Auth::user())
                                <li class="menu-item" ><a title="{{__('homepage.logout')}}" href="{{ route('user.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>{{__('homepage.logout')}}</a></li>
                        @else
                            <li class="menu-item" ><a title="{{__('homepage.login')}}" href="{{route('user.auth')}}"><i class="fa fa-user-o"></i>{{__('homepage.login')}}</a></li>
                            <li class="menu-item" ><a title="{{__('homepage.register')}}" href="{{route('user.register')}}"><i class="fa fa-user-plus"></i>{{__('homepage.register')}}</a></li>
                        @endif

					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

@php
    $setting = \App\Models\Settings::first();
@endphp
			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row" >
						<!-- LOGO -->
						<div class="col-md-3 col-12" style="@auth padding-top: 15px @else padding: 25px 0px  @endauth" >
							<div class="header-logo">
								<a href="{{route('home')}}" class="logo">
									<img src="{{asset($setting->logo)}}" alt="" width="200px" style="height: 50px !important; margin-top: 15px">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

                        <style>
                            .pad{
                                background-color: white!important;
                                font-size: 26px!important;
                                color: var(--col);
                                border-radius: 40px  40px 40px 40px;
                                border: 1px solid #efefef;
                                border-right: none ;
                                border-top-right-radius: 0px;
                                border-bottom-right-radius: 0px;
                                margin-right: -15px;
                                z-index: 40;
                                padding: .2px;

                            }
                            .dropdown-menu{
                                z-index: 99;
                            }


                            @media only screen and (max-width: 991px) {
                                .dropdown{
                                    display: inline-block!important;

                                }
                                .fa-gamepad{
                                    display: {{\Request::is('/') ? 'inline-block' : 'none'}};
                                }
                                .yn{
                                    display: {{\Request::is('/') ? 'none' : 'block'}};

                                }



                                .pad{
                                    @auth
                                    margin-left: {{\Request::is('/') ? '3px' : '-7px'}} ;

                                    @else
                                    margin-left: {{\Request::is('/') ? '3px' : '8px'}} ;
                                    @endauth
}


                            }

                        </style>
						<!-- SEARCH BAR -->
						<div class="col-md-5 col-12" style="@auth padding-top: 15px @else padding: 30px 0px  @endauth "   >
							<div class="header-search">
								<form action="{{route('search')}}" method="get">
                                    <div class="row" style="max-width: 100%; margin: 0">

                                        <div class="pad col-md-1 col-xs-1 col-sm-1 col-lg-1 col-1 text-center " style="max-width: 20%">
                                        <span class="fa fa-gamepad" style="padding-top: 2px"></span>
                                        </div>

                                        <style>

                                            @media only screen and (max-width: 991px) {
                                                .header-search form .input {
                                                    width: {{\Request::is('/') ? 'calc(100% - 240px)' : 'calc(100% - 197px)'}};
                                                }
                                            }

                                        </style>
                                        <input type="search" class="input col-6" style="float:left;" id="search_text" name="query" placeholder="{{__('homepage.I am looking for')}}...">


                                        <div class="dropdown1">
                                            <button class="btn  search-btn dropdown-toggle"  type="button" data-toggle="dropdown1">Browse Games <i class="{{\Request::is('/') ? 'fa fa-caret-down' : ''}}"></i>
                                                </button>

                                            <style>

                                                .dropdown1 {
                                                    float: left;
                                                    position: relative;
                                                }

                                                .dropdown1 .dropbtn {
                                                    font-size: 10px;
                                                    border: none;
                                                    outline: none;
                                                    color: white;
                                                    padding: 4px 6px;
                                                    background-color: inherit;
                                                    margin: 0;
                                                }


                                                .dropdown-one {
                                                    cursor: pointer;
                                                    display: none;
                                                    position: absolute;
                                                    border-radius: 5px;
                                                    background-color: #ffffff;
                                                    max-width:165px;
                                                    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                                    z-index: 99;
                                                }

                                                .dropdown-two {
                                                    cursor: pointer;
                                                    display: none;
                                                    position: absolute;
                                                    left: 160px;
                                                    top: 2px;
                                                    min-width: 160px;
                                                    border: 1px solid var(--col);
                                                    border-radius: 5px;
                                                    background-color: #ffffff;
                                                    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                                }

                                                .dropdown1:hover .dropdown-one, #link1:hover > .dropdown-two , #link1:hover > .dropdown-two2,
                                                #link1:hover > .dropdown-two3, #link1:hover > .dropdown-two4{
                                                    display: block;
                                                }
                                                .dItem{
                                                    border-bottom: 2px solid var(--col);
                                                    border-radius: 5px;
                                                    border-top-left-radius: 0px ;
                                                    border-top-right-radius: 0px ;
                                                    margin-top: 2px;
                                                }
                                                .dItem2 {
                                                    color: black;
                                                    width: 160px;
                                                    padding: 6px 6px;
                                                    display: block;
                                                    font-size: small;
                                                    font-weight: bold;
                                                    text-align: left;

                                               }
                                                #file{
                                                    border-bottom: 2px solid #bbb8b8;
                                                }

                                                .dropdown-one .dItem {
                                                    color: black;
                                                    width: 160px;
                                                    padding: 6px 6px;
                                                    display: block;
                                                    font-size: small;
                                                    font-weight: bold;
                                                    text-align: left;
                                                }

                                                .dropdown-one .dItem:hover, .dropdown-two a:hover {
                                                    background-color: var(--col);
                                                }

                                            </style>

                                            <div class="dropdown-one">
                                                @php
                                                    $top_cats =\App\Models\Category::where('status', 'active')->get();
                                                @endphp

                                                @foreach($top_cats as $index => $cat)
                                                    @php
                                                      $items = \App\Models\Product::where(['cat_id'=> $cat->id, 'status' => 'active'])->limit(10)->get()->unique('brand_id');
                                                    @endphp
                                                <style>
                                                    .dropdown-two{{$cat->id}} {
                                                        cursor: pointer;
                                                        display: none;
                                                        position: relative;
                                                        left: 160px;
                                                        z-index: 99999999;
                                                        top: {{$index > 0 ? ($index *35) -1: '1'}}px;
                                                        min-width: 160px;
                                                        border: 1px solid var(--col);
                                                        border-radius: 5px;
                                                        background-color: #ffffff;
                                                        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                                    }
                                                    .dItem2:hover{
                                                        background-color: #afadad;
                                                    }

                                                    .dropdown1:hover .dropdown-one, #link1:hover > .dropdown-two , #link1:hover > .dropdown-two{{$cat->id}}{
                                                        display: block;
                                                        position: absolute;
                                                        z-index: 999;
                                                    }
                                                    @media only screen and (max-width: 991px) {
                                                        .dropdown-two{{$cat->id}} {
                                                            left: -160px;

                                                        }
                                                    }

                                                </style>
                                                    <div id="link1" class="dItem">{{strtoupper($cat->title)}}
                                                        <i class="fa fa-caret-right" style="float: right; font-size: 16px"></i>
                                                        <div class="dropdown-two{{$cat->id}}">

                                                            @if(count($items)>0)

                                                                @foreach($items as $brand)
                                                                    @php
                                                                        $brd = \App\Models\Brand::where('id', $brand->brand_id)->first();
                                                                    @endphp
                                                                    <a href="{{route('shop.games', [$cat->id,$brd->id])}}">
                                                                        <div class="dItem2" id="file" >{{ucfirst($brd->title)}}</div>
                                                                    </a>
                                                                @endforeach

                                                            @endif

                                                        </div>
                                                    </div>
                                                @endforeach

                                                <a href="{{route('shop')}}" >
                                                    <div class="dItem">VIEW ALL GAMES</div>
                                                </a>
                                            </div>

                                        </div>

                                    </div>

								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-4 clearfix col-12">
							<div class="header-ctn">


                            @if(Auth::user())
                                @php
                                    $current_time = Carbon\Carbon::now()->toDateTimeString();
                                        $new_ord = \App\Models\Order::where(['user_id' => $user->user_id, 'condition' => 'pending', 'payment_status' =>'paid'])->get();
                                        $newest_ord = \App\Models\Order::where(['user_id' => $user->user_id, 'is_seen_buyer' => '0', 'payment_status' =>'paid'])->get();
                                        $newest_sal = \App\Models\Order::where(['seller' => $user->user_id,  'is_seen_seller' => '0', 'payment_status' =>'paid'])->get();
                                        $new_sal = \App\Models\Order::where(['seller' => $user->user_id, 'condition' => 'pending', 'payment_status' =>'paid'])->get();

                                $counter = 0;

                                        if(count($newest_ord) > 0){
                                            $counter = $counter +1;
                                        }if(count($newest_sal) > 0){
                                            $counter = $counter +1;
                                        }
                                @endphp
                                  <!-- Cart -->
                                <style>
                                    @keyframes bounce {
                                        0%, 100%, 20%, 50%, 80% {
                                            -webkit-transform: translateY(0);
                                            -ms-transform:     translateY(0);
                                            transform:         translateY(0)
                                        }
                                        40% {
                                            -webkit-transform: translateY(-30px);
                                            -ms-transform:     translateY(-30px);
                                            transform:         translateY(-30px)
                                        }
                                        60% {
                                            -webkit-transform: translateY(-15px);
                                            -ms-transform:     translateY(-15px);
                                            transform:         translateY(-15px)
                                        }
                                    }
                                    .img-top {
                                        -webkit-animation-duration: 1.5s;
                                        animation-duration: 1.5s;
                                        -webkit-animation-fill-mode: both;
                                        animation-fill-mode: both;
                                        -webkit-animation-timing-function: ease-in-out;
                                        animation-timing-function: ease-in-out;
                                        animation-iteration-count: infinite;
                                        -webkit-animation-iteration-count: infinite;
                                    }
                                    .img-top:hover {
                                        cursor: pointer;
                                        animation-name: bounce;
                                        -moz-animation-name: bounce;
                                    }
                                </style>
                                      <div class="">
                                          <a href="{{route('user-order.index')}}">
                                              <i class="img-top"><img src="{{asset('frontend/img/orders.png')}}" style="height: 70px"></i>
                                              <span>Orders</span>

                                              @if(count($new_ord))
                                                  <div class="qty">{{count($new_ord)}}</div>
                                              @endif
                                          </a>
                                      </div>
                                        <!-- /Cart -->

                                          <!-- Cart -->
                                              <div class="">
                                                  <a href="{{route('user.sales')}}">
                                                      <i class="img-top"><img src="{{asset('frontend/img/sales.png')}}" style="height: 70px"></i>
                                                      <span>Sales</span>
                                                      @if(count($new_sal))
                                                          <div class="qty">{{count($new_sal)}}</div>
                                                      @endif
                                                  </a>
                                              </div>
                                              <!-- /Cart -->

                                      <!-- Cart -->
                                      @php
                                          $unread_messages = \App\Models\Message::where(['receiver_id' => $user->user_id, 'is_read' => '0'])->get();
                                           $unread_chat = $unread_messages->groupBy('user_id');
                                       $name = explode( " ", $user->username);
                                        if(count($unread_chat) > 0){
                                            $counter = $counter +1;
                                        }

                                      @endphp
                                      <div class="dropdown" style="cursor: pointer">
                                          <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

                                                      <i class=""><img src="{{asset('frontend/img/profile.png')}}" style="height: 70px"></i>

                                                  <span class="">{{$name[0]}}  <i class="{{\Request::is('/')  ||  \Request::is('checkout') ? 'fa fa-caret-down' : ''}}" aria-hidden="true"></i> </span>

                                              @if(count($unread_chat) || count($newest_ord) || count($newest_sal))
                                              <div class="qty">{{$counter}}</div>
                                              @endif
                                          </a>



                                          <div class="cart-dropdown cart-dropdown1">
                                              <p> Hello, <strong>{{$user->username}} </strong> </p>
                                              <div class="cart-summary">
                                                  <h5><a href="{{route('user.dashboard')}}"><i class="fa fa-tachometer" aria-hidden="true">&nbsp;</i>Profile</a></h5>
                                                  <h5><a style="{{count($unread_chat) > 0 ? "color:red" : ''}}" href="{{route('message.index')}}"><i class="fa fa-envelope" aria-hidden="true">&nbsp;</i> Messages - ({{count($unread_chat)}})</a> </h5>
                                                  <h5><a href="{{route('seller-product.index')}}"> <i class="fas fa-archive" aria-hidden="true">&nbsp;</i>  Offers</a></h5>
                                                  <h5><a style="{{count($newest_ord) > 0 ? "color:red" : ''}}" href="{{route('user-order.index')}}"> <i class="fa fa-shopping-bag" aria-hidden="true">&nbsp;</i>Orders</a></h5>
                                                  <h5><a style="{{count($newest_sal) > 0 ? "color:red" : ''}}" href="{{route('user.sales')}}"> <i class="fas fa-shopping-cart" aria-hidden="true">&nbsp;</i> Sales</a></h5>
                                                  <h5><a href="{{route('user.funds')}}"> <i class="fas fa-dollar" aria-hidden="true">&nbsp;</i> My Balance</a></h5>
                                              </div>
                                              <div class="cart-summary">
                                                  <h5><a href="{{ route('user.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Log out </a></h5>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- /Cart -->






                                @else
{{--                                    <!-- Wishlist -->--}}
{{--                                        <div class="wishlist">--}}
{{--                                            <a href="#">--}}
{{--                                                <i class="fa fa-dollar"></i>--}}
{{--                                                <span>{{__('homepage.how to buy')}}</span>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                        <!-- /Wishlist -->--}}

{{--                                        <!-- Cart -->--}}
{{--                                        <div class="wishlist">--}}
{{--                                            <a href="#" aria-expanded="true">--}}
{{--                                                <i class="fa fa-shopping-cart"></i>--}}
{{--                                                <span>{{__('homepage.how to sell')}}</span>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                        <!-- /Cart -->--}}
                                @endif

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->

</div>

