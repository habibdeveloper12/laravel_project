@extends('frontend.layouts.master')
<style>
    .topsection{
        display: none;
    }
    body{
        background-image: url({{asset('/frontend/img/bg10.jpg')}});
    }
    .card{
        box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
        border-radius: 5px;
        background-color: rgba(255, 255, 255, .15);
        backdrop-filter: blur(3px);

        margin-top: 40px;
        padding: 5% 0%;
        padding-bottom: 1%;
        font-size: 15px;
        padding-top: 0;
    }
    .card-header{
        padding: 10px 5px;
        border-radius: 5px;
        background-color: #a7e138;
        color: black;
        font-weight: bolder;
        font-size: 16px;
        text-align: center;
        width: 100%;
    }
    .card-body{
        padding: 2% 30%;
    }
    .but{
        background-color: black!important;
        margin: 10px;
        margin-top: 10%;
        margin-left: 50%;
        width: 100%;
    }
    .row{
        margin-top: 15px;
    }
    .invalid-feedback{
        color: red;
        font-weight: lighter;
        font-size: 14px;
    }
    .form-control{
        width: 100%;
    }
    @media only screen and (max-width: 991px) {
        .card{
            padding-bottom: 1%;
        }
        .but{
            margin: 0;
            margin-top: 10%;
            width: 100%;
        }
        .card-body{
            padding: 2% 5%;
        }

    }

</style>

@section('content')
    <div class="container" style="margin-top: 3%; margin-bottom: 4%">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('user.password.reset')}}">
                            @csrf
                            <input type="hidden" value="{{$token}}" name="token">
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 ">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label for="password" class="col-md-4 ">{{ __('New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 ">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class=" but btn btn-primary">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
