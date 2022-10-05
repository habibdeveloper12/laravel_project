@extends('frontend.layouts.master')
<style>

    .card{
        background-color: #efefef;
        padding: 5% 30%;
        font-size: 15px;
        border: 1px solid black;
    }
    .card-header{
        padding: 10px 5px;
        background-color: #a7e138;
        border-radius: 5px;
        color: black;
        font-weight: bolder;
        font-size: 16px;
        margin-bottom: 5%;
        text-align: center;
        width: 100%;
    }
    .but{
        background-color: black!important;
        margin: 10px;
        margin-left: 25px !important;
        text-decoration: none ;
        color: white!important;
        width: 90%;
    }

    @media only screen and (max-width: 991px) {
        .card{
            padding: 3% 3%;
            font-size: 14px;

        }
        .card-header{
            font-size: 13px;
        }
        .but{
            margin-left: 10px !important;

        }
    }
</style>
<style>
    .topsection{
        display: none;
    }
</style>

@section('content')
    <div class="container" style="margin-top: 3%; margin-bottom: 3%">
        <div class="row justify-content-center">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                            <br/>
                            <br/>
                        {{ __('If you did not receive the email yet, Wait and retry again!') }},

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
