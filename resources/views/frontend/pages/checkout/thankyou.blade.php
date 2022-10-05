@extends ('frontend.layouts.master')
<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="{{asset('frontend/product-detail/assets/css/chosen.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/product-detail/assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/product-detail/assets/css/color-01.css')}}">

@section('content')
    <!--main area-->
    <main id="main" class="main-site">
        <style>
            .ord{
                margin-top: 125px;
                margin-bottom: 100px;
                padding: 20px;
                box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
                background-color: rgba(239,239,239,0.72);
                border-radius: 5px;

            }

            @media only screen and (max-width: 991px) {
                .ord{
                    margin-top: 25px;
                    margin-bottom: 30px;

                }
            }
        </style>


            <style>

                #main{
                    margin-top: 0px;
                }

                @media only screen and (max-width: 991px) {
                    #footer{
                        position: inherit;
                    }
                    #main{
                        margin-top: 0px;
                    }
                }
            </style>

        <div class="container pb-60 ord">
            <div class="row">
                <div class="col-md-12 text-center " style="margin-top: 20px">
                    <i class="fa fa-check-circle" style="color: #a7e138; font-size: 100px"></i>
                    <h2>Thank you for your order</h2>
                    <p>A confirmation email was sent to you.</p>
                    <a href="{{route('shop')}}" class="btn btn-submit btn-submitx">Continue Shopping</a>
                </div>
            </div>
        </div><!--end container-->
<br/>
    </main>
    <!--main area-->


    <footer id="footer">
        <div class="wrap-footer-content footer-style-1">

        </div>
    </footer>
    <!--End function info-->

    <script src="{{asset('frontend/product-detail/assets/js/jquery-1.12.4.minb8ff.js?ver=1.12.4')}}"></script>
    <script src="{{asset('frontend/product-detail//js/jquery-ui-1.12.4.minb8ff.js?ver=1.12.4')}}"></script>
    {{--    <script src="{{asset('frontend/product-detail/assets/js/bootstrap.min.js')}}"></script>--}}
    <script src="{{asset('frontend/product-detail/assets/js/jquery.flexslider.js')}}"></script>
    <script src="{{asset('frontend/product-detail/assets/js/chosen.jquery.min.js')}}"></script>
    <script src="{{asset('frontend/product-detail/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/product-detail/assets/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('frontend/product-detail/assets/js/jquery.sticky.js')}}"></script>
    <script src="{{asset('frontend/product-detail/assets/js/functions.js')}}"></script>

@endsection

@section('scripts')

@endsection
