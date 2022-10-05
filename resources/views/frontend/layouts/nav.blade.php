<!-- container -->
<div class="container donot">
    <!-- responsive-nav -->
    <div id="responsive-nav">
        <!-- NAV -->
        <ul class="main-nav nav navbar-nav">
            @php
                $user = Auth::user();

            @endphp
            @if($user)
                <li class="{{\Request::is('/') ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                <li class="{{\Request::is('/dashboard') ? 'active' : ''}}"><a href="{{route('user.dashboard')}}">Profile</a></li>
                <li class="{{\Request::is('/order') ? 'active' : ''}}"><a href="{{route('user-order.index')}}">Orders</a></li>
                <li class="{{\Request::is('/new-message') ? 'active' : ''}}"><a href="{{route('message.index')}}">Messages</a></li>
                    <li class="{{\Request::is('/seller/seller-product') ? 'active' : ''}}"><a href="{{route('seller-product.index')}}">Offers</a></li>
                    <li class="{{\Request::is('/sales') ? 'active' : ''}}"><a href="{{route('user.sales')}}">Sales</a></li>
                <li class="{{\Request::is('/funds') ? 'active' : ''}}"><a href="{{route('user.funds')}}">My Balance</a></li>
                <li><a href="{{ route('user.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>{{__('homepage.logout')}}</a></li>

            @else
                <li class="{{\Request::is('/') ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                <li class="{{\Request::is('user/login') ? 'active' : ''}}"><a href="{{route('user.auth')}}">Login</a></li>
                <li class="{{\Request::is('user/register') ? 'active' : ''}}"><a href="{{ route('user.register') }}">Register</a></li>
                <li><a href="#" >How to Buy</a></li>
                <li><a href="#">How to Sell</a></li>
                <li><a href="#newsletter">Contact</a></li>
            @endauth

        </ul>
        <!-- /NAV -->
    </div>
    <!-- /responsive-nav -->
</div>
<!-- /container -->
