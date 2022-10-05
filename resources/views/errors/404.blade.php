@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

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
        <div class="container" style="background-color: rgba(239,239,239,0.85);border-radius: 5px" >
            <!-- row -->
            <div class="row" style="padding: 5%">
                    <div class="row col-12">
                        <h1  style="font-size: 70px">404</h1>
                    </div>

                    <div class="row">
                        <h5 class="col-12">Oops! Page Not Found</h5>
                        <span class="col-12" style="font-size: 16px">
                            Maybe this page moved? Got deleted? Is hiding out in quarantine? Never existed in the first place?<p>Let's go <a href="{{route('home')}}" style="color: green; font-size: 15px">home</a> and try from there.</p>
                        </span>
                    </div>
                </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


@endsection
