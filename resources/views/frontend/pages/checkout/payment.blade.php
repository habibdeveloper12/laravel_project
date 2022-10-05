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
    <main id="main" class="main-site" style="padding: 0">

        <style>
            .ord{
                margin-bottom: 30px;
                margin-top: 30px;
                padding: 20px;
                background-color: rgba(239, 239, 239, 0.8);
                border-radius: 5px;

            }

            @media only screen and (max-width: 991px) {
                .ord{
                    margin-top: 25px;
                }
            }
        </style>

        <div class="container ord" >
            <div class="wrap-breadcrumb">
                <style>
                    h3{
                        margin: 1% 0;
                    }
                    @media only screen and (max-width: 991px) {
                        h3{
                            font-size: 15px!important;
                            text-align: center;
                            margin-top: 20px;
                            margin-bottom: 20px;
                        }
                    }
                    .border{
                        border: 1px solid red;
                    }
                </style>
                <H3>Order review and Payment </H3>
            </div>


                    <div class="table-responsive mb-5">
                        <table class="table border">
                    <thead>
                    <tr>
                        <th>Game</th>
                        <th>Price Unit</th>
                        <th>Quantity</th>
                        <th>Total</th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>{{ucfirst($product->title)}} {{ucfirst(\App\Models\Category::where('id', $product->cat_id)->first()->title)}}</strong>
                                <br/>
                                <p style="max-width: 350px">{!! html_entity_decode($product->summary) !!}</p>
                                <br/>
                            </td>
                            <td>
                                {{Helper::currency_converter($product->offer_price)}}
                            </td>
                            <td>
                                {{\Illuminate\Support\Facades\Session::get('checkout')['quantity']}}
                            </td>
                            <td style="font-weight: bold">
                             {{Helper::currency_converter(\Illuminate\Support\Facades\Session::get('checkout')['total'])}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                    </div>

             <div class=" main-content-area">
                 <div class=" summary-item shipping-method">
                     <h4 class="title-box">Payment Method</h4>

                     <div style="height: 25px">
                         <p id="fund_max"  style="font-size: 15px; font-weight:bold; padding: 0px 0 5px 0; color: red;text-align: center"></p>

                     </div>


                     <style>
                         label.single-payment{
                             height: 100px;
                             min-width: 100%;
                         }
                         label.single-payment>.payment-method-info {
                             position: relative;
                             display: flex;
                             flex-wrap: wrap;
                             align-content: center;
                             justify-content: center;
                             border-radius: 10px;
                             background: rgba(0, 0, 0, 0.35);
                             padding: 20px;
                             height: 150px;
                             min-width: 100%;
                         }
                         .single-payment input[type="radio"]
                         {
                             width:100%;height:100%;position:absolute;top:0;left:0;opacity:0;
                         }
                         .single-payment>img{
                             max-width: 100px;
                         }
                         .single-payment input[type="radio"]:checked ~ .payment-method-info
                         {
                             box-shadow: 0px 3px 3px 0px #fdd02f
                         }
                         .single-payment input[type="radio"]:checked ~ .payment-method-info>.ischecked
                         {
                             display: block;
                             position: absolute;
                             top: 10px;
                             right: 10px;
                             border-radius: 10px;
                             background-color: var(--col);
                             box-shadow: 0 0 5px 3px rgb(253 208 47 / 39%);
                             width: 15px;
                             height: 15px;
                         }
                         .payment-method-info .ischecked {
                             display: block;
                             position: absolute;
                             top: 10px;
                             right: 10px;
                             border-radius: 10px;
                             background-color: #ebebeb;
                             box-shadow: 0 0 1px 2px rgb(253 208 47 / 39%);
                             width: 15px;
                             height: 15px;
                         }
                         .stripe{
                             transform: scale(1.8);
                         }
                         .payment-method-info{
                             margin: 0px!important;
                         }
                         .payment-method-logo{
                             height: 70px;
                         }

                         @media only screen and (max-width: 991px) {
                             .payment-meth{
                                 margin-top: 55px;
                             }
                         }

                     </style>
                     <div class="row payment-methods-list justify-content-between">
                         <div class="col-md-3 payment-meth">
                             <label class="single-payment" for="balance">
                                 <input id="balance" type="radio" name="payment-method" value="balance" checked>
                                 <div class="payment-method-info">
                                     <div class="ischecked"></div>
                                     <img src="{{asset('frontend/img/logo.png')}}" alt="" class="payment-method-logo" style="height: 40px;">
                                     <img  alt="" class="payment-method-ms">
                                 </div>
                             </label>
                         </div>
{{--                         <div class="col-md-3 payment-meth">--}}
{{--                             <label class="single-payment" for="skrill">--}}
{{--                                 <input id="skrill" type="radio" name="payment-method" value="skrill" >--}}
{{--                                 <div class="payment-method-info">--}}
{{--                                     <div class="ischecked"></div>--}}
{{--                                     <img src="{{asset('frontend/img/skrill.png')}}" alt="" class="payment-method-logo">--}}
{{--                                     <img src="{{asset('frontend/img/payment/stripe-ms.webp')}}" alt="" class="payment-method-ms" >--}}
{{--                                 </div>--}}
{{--                             </label>--}}
{{--                         </div>--}}
                         <div class="col-md-3 payment-meth">
                             <label class="single-payment" for="stripe">
                                 <input id="stripe" type="radio" name="payment-method" value="stripe">
                                 <div class="payment-method-info">
                                     <div class="ischecked"></div>
                                     <img src="{{asset('frontend/img/stripe.svg')}}" alt="" class="stripe payment-method-logo">
                                     <img src="{{asset('frontend/img/payment/strie-ms.webp')}}" alt="" class="payment-method-ms">
                                 </div>
                             </label>
                         </div>
                         <div class="col-md-3 payment-meth">
                                 <label class="single-payment" for="payop">
                                     <input id="payop" type="radio" name="payment-method" value="payop">
                                     <div class="payment-method-info">
                                         <div class="ischecked"></div>
                                         <img src="{{asset('frontend/img/payment/payop.svg')}}" alt="" class="payment-method-logo mb-5" style="height: 30px !important;">
                                         <img src="{{asset('frontend/img/payment/payop-ms.webp?v1.2')}}" alt="" class="payment-method-ms">
                                     </div>
                                 </label>
                         </div>
                     </div>

                     <div class="row mt-4">
                         <button class="btn btn-success "  onclick="f()" style="width: 100%; border-radius: 5px; margin:  50px 100px"> Proceed</button>
                     </div>

                 </div>



                </div><!--end main content area-->

        </div><!--end container-->

    </main>
    <!--main area-->

@endsection


@section('scripts')

    <script>
        function f() {

            var radioValue = $("input[name='payment-method']:checked").val();

            $.ajax({
            url: "{{route('payment.processing')}}",
            type: "POST",
            data: {
                '_token': '{{ csrf_token() }}',
                'body': radioValue,
            },
            success: function (response) {

                if(response['error']){

                    {{--//You don't have sufficient fund! Your balance is {{Helper::currency_converter($user->balance)}}--}}
                    document.getElementById("fund_max").innerHTML = response['error']

                    setTimeout(remove , 4000);
                    function remove(){
                        document.getElementById("fund_max").innerHTML = ''
                    }

                }else{
                    if(response['success']){
                        window.location = response['redirect'];
                    }else{
                        window.location = response;
                    }
                }

            }, error: function (jqXHR, textStatus, errorThrown) {
                // console.log(textStatus, errorThrown);

            }

        })

        }
    </script>

@endsection
