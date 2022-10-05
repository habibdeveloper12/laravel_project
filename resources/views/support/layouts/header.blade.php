<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav" @if(Request::is('support')) @else style="background-color: #406955; height: 90px" @endif>
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{route('support')}}">
            <img src="{{asset($setting->logo_white)}}" alt="" width="200px" style="height: 50px !important; margin-top: 15px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                @auth
                @else
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" target="_blank" href="{{route('user.auth')}}">Sign in</a></li>
                @endauth
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('support.request')}}">Submit a request</a></li>
            </ul>
        </div>
    </div>
</nav>


@if(Request::is('support'))
<!-- Page Header-->
<header class="masthead" style="background-image: url('{{asset($setting->support_banner)}}')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <span class="subheading">Check our frequently asked questions</span>
                </div>
            </div>
        </div>
    </div>
</header>
@endif
