@extends('frontend.layouts.master')
<style>
    .pull-right{
        display: none;
    }
    .ord{
        margin: 280px auto 50px auto;
        min-height: 500px
    }
    @media only screen and (max-width: 991px) {
        .ord {
            margin-top: 0px !important;
        }
    }

</style>

@section('content')

    <!-- SECTION -->
    <div class="section ord">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row" style="padding: 10%">
                <h1 style="font-size: 70px">505</h1>
                <h5>Internal Server Error</h5>
                Sorry! the page you are looking for is not found. Make sure that you have your device connected to internet.<p>Let's go <a href="{{route('home')}}" style="color: #d10024">home</a> and try from there.</p>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


@endsection
