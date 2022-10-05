@extends('frontend.layouts.master')



@section('content')
    @php
        $setting = \App\Models\Settings::first();
    @endphp

    <div id="hot-deal" class="section1"  style="background-image: url({{asset($setting->banner)}}); border-bottom: 10px solid var(--col)">
        <!-- container -->
        <div class="container" >
            <!-- row -->

            <style>
                @font-face {
                    font-family: "Customont";
                    src: url({{asset('frontend/font/Controller_W01_Two.ttf')}});
                }
                .flexxer{
                    display: flex;
                    justify-content: space-between;
                }
                .flexxer-group{
                    width: 400px;
                    padding: 38px 0;
                    font-family: Customont;
                    color: white;
                }
                .first{
                    font-size: 25px;
                }

                .second{
                    font-size: 22px
                }

                @media only screen and (max-width: 991px) {
                    .first{
                        font-size: 14px;
                    }

                    .second{
                        font-size: 14px
                    }

                }
            </style>
            <div class="flexxer" >

                <div class="flexxer-group">
                        <p class="first" >{{$setting->banner_title}}</p>
                </div>


                <div class="flexxer-group">
                    <p class="second">{{$setting->banner_description}}</p>
                </div>


            </div>
            <!-- /row -->

        </div>
        <!-- /container -->


    </div>
    <!-- /HOT DEAL SECTION -->
    <div class="text-center" style="background-color: var(--col); padding-bottom: 5px">
        <!-- TrustBox widget - Micro Review Count -->
        <div class="trustpilot-widget" data-locale="en-US" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="61cb7ae7d2e1a77e56bf0f86" data-style-height="24px" data-style-width="100%">
            <a  href="https://www.trustpilot.com/review/gg-trade.com" target="_blank" rel="noopener" >
                <span style="font-size: 15px">Trustpilot</span>
            </a>
        </div>
        <!-- End TrustBox widget -->
    </div>

    <!-- SECTION -->
    <div class="section"  style="background-image: url('{{asset($setting->background)}}'); margin-top:0px; background-size: cover ">

        <!-- container -->
        <div class="container caro" >
            <!-- row -->

            <div class="row" >

            @php
                $sellers = \App\Models\User::where('seller', '1')->where('avg_rating' ,'>', 0)->orderBy('avg_rating', 'DESC')->get();
            @endphp


            @include('frontend.layouts.carousel')



            </div>
            <!-- /row -->

        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section" style="background-color: #efefef">
        <!-- container -->
        <div class="container" >
            <style>
                .flex-cont{
                    display: flex;
                    flex-wrap: wrap;
                }
                .flex-group{
                    flex: 1 0 20%;
                    padding: 30px;
                    justify-content: space-around;
                    color: black;

                }
                .ic{
                    font-size: 50px;
                    color: var(--col);
                    margin-bottom: 10px;
                }
                .fg{
                    border-right: 1px solid var(--col);
                }

                @media only screen and (max-width: 991px) {
                    .flex-cont{
                        flex-direction: column;
                    }
                    .fg{
                        border: none;
                    }

                }
            </style>
            <!-- row -->
            <div class="row ">

                <!-- section title -->
                <div class="col-md-12 flex-cont">



                    <div class="flex-group text-center fg" >
                        <i class="" ><img src="{{asset('frontend/img/1_body.png')}}" style="height: 150px"></i>
                        <p>
                            Feel confident each time you transact with us.
                        </p>
                        <p>
                            GG-Trade comes with SSL protection and wide range of payment processors under a safe and secured platform.
                        </p>


                    </div>

                    <div class="flex-group text-center fg" >
                        <i class="" ><img src="{{asset('frontend/img/3_body.png')}}" style="height: 150px"></i>
                        <p>
                            Our dedicated Customer Service team are available to help with any queries about your orders and provide exceptional after sales report
                        </p>



                    </div>

                    <div class="flex-group text-center">
                        <i class="" ><img src="{{asset('frontend/img/2_body.png')}}" style="height: 150px"></i>
                        <p>
                        GG-Trade provides competitive pricing to the buyers driven by a free market economy while striving to keep the cost low for our sellers.
                        </p>
                    </div>


                </div>
                <!-- /section title -->


            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section" style="background-image: url('{{asset($setting->background)}}'); background-size: cover ; " >
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <style>
                        .titled{
                            color: white;
                            padding: 5px;
                            text-align: center;
                            font-family: 'Customont';
                        }

                        .imgg{
                            height: 400px;
                            padding: 0 20%
                        }

                        @media only screen and (max-width: 991px) {
                            .imgg{
                                max-height: 190px;
                                padding: 0
                            }

                        }
                    </style>

                    <div class="col-md-12 fir" style="margin: 0px auto">
                        <h2 class="titled">How it works</h2>
                        <object data="{{asset($setting->workflow_image)}}" class="imgg"> </object>

{{--                        <img src="{{asset($setting->workflow_image)}}" class="imgg">--}}
                    </div>

                </div>
                <!-- /section title -->


            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <style>
        .sliding{
            background-color: #1E1F29;
        }
        .text-payment{
            font-size: 18px;
            color: #AFAA99;
            padding-bottom: 25px

        }
        .payment-providers{
            padding: 45px 0;
        }

        @media only screen and (max-width: 991px) {
            .payment-providers{
                padding: 25px 0;
            }
            .text-payment{
                font-size: 13px;
                padding-bottom: 10px
            }
        }
    </style>
    <div class="sliding">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" />
        <section class="payment-providers text-center bg-gradient-payment">
            <h3 class="text-uppercase text-payment" >PAYMENT PROVIDERS</h3>
            <div class="owl-two owl-carousel">
                <div>
                    <img src="{{asset('frontend/img/payment/visa_logo.webp?v3')}}" alt="Visa Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/stripe_logo.webp?v3')}}" alt="Stripe Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/maestro_logo.webp?v3')}}" alt="Maestro Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/amex_logo.webp?v3')}}" alt="AMEX Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/jcb_logo.webp?v3')}}" alt="JCB Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/discover_logo.webp?v3')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/webmoney_logo.webp')}}" alt="Webmoney Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/unionpay_logo.webp?v2')}}" alt="Unionpay Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/payop_logo.webp')}}" alt="Payop Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/trustly_logo.webp')}}" alt="Trustly Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/coinbase_logo.webp')}}" alt="Coinbase Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/skrill_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/safetypay_logo.webp')}}" alt="Safetypay Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/rupay_logo.webp')}}" alt="Rupay Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/qiwi_logo.webp')}}" alt="qiwi Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/przelewy24_logo.webp')}}" alt="przelewy24 Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/poli_logo.webp')}}" alt="Poli Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/pix_logo.webp')}}" alt="Pix Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/perfectmoney_logo.webp')}}" alt="Perfect Money Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/payumoney_logo.webp')}}" alt="Payum Money Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/paysera_logo.webp?v2')}}" alt="Paysera Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/paydo_logo.webp')}}" alt="Paydo Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/payconiq_logo.webp')}}" alt="Payconiq Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/oca_logo.webp')}}" alt="Oca Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/neosurf_logo.webp')}}" alt="Neosurf Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/loterias_logo.webp')}}" alt="Loterias Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/litecoin_logo.webp')}}" alt="Litecoin Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/klarna_logo.webp')}}" alt="Klarna Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/jcb_logo.webp')}}" alt="Jcb Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/itau_logo.webp')}}" alt="Itau Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/hipercard_logo.webp')}}" alt="Hipercard Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/gpay_logo.webp')}}" alt="Gpay Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/giropay_logo.webp')}}" alt="Giropay Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/fawry_logo.webp?v2')}}" alt="Fawry Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/ethereum_logo.webp?v2')}}" alt="Ethereum Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/eps_logo.webp')}}" alt="EPS Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/discover_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/dash_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/caixa_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/bradesco_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/blik_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/bitcoincash_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/bitcoin_logo.webp?v2')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/banrisul_logo.webp?v2')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/banktransfer_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/bancontact_logo.webp?v2')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/bancodobrasil_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/aura_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/applepay_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
                <div>
                    <img src="{{asset('frontend/img/payment/advcash_logo.webp')}}" alt="Discover Logo gg-trade">
                </div>
            </div>
        </section>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script async src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
        <script>
            $(document).ready(function(){
                $(".owl-two").owlCarousel({
                    items: 10,
                    rewindNav: false,
                    stagePadding: 50,
                    loop:true,
                    margin:50,
                    nav:false,
                    dots:false,
                    autoplay:true,
                    autoplayTimeout: 1500,
                    smartSpeed:450,
                    responsive:{
                        0:{
                            items:4
                        },
                        600:{
                            items:6
                        },
                        1000:{
                            items:10
                        },
                        1921:{
                            items:14
                        }
                    }
                });

            });

        </script>
    </div>
@endsection

@section('scripts')


@endsection
