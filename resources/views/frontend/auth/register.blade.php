@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<style>
    body{
        background-image: url({{asset('/frontend/img/bg10.jpg')}});
    }
    .logg{
        box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.71);
    }
    .link{
        color: white;
    }
    .item-link{
        color: #efefef;
    }

</style>
@section('content')

<div class="section">

                        <div class="row">
                            <div class="col-lg-4 col-sm-12 mt-5 col-md-offset-4">
                                <div class=" main-content-area">
                                    <div class="wrap-login-item ">
                                        <div class="login-form form-item form-stl logg">
                                            <form action="{{route('register.submit')}}" method="post">
                                            <div name="frm-login">
                                                {{csrf_field()}}
                                                <fieldset class="wrap-title">
                                                    <h3 class="form-title">{{__('auth.Buyer / seller Registration')}}</h3>
                                                </fieldset>

                                                <fieldset class="wrap-input">
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <label for="frm-login-uname">{{__('auth.Username')}}:</label>
                                                    <input type="text" id="frm-login-uname" class="form-control" name="username" placeholder="{{__('auth.Type your username')}}" value="{{old('username')}}">
                                                    @error('username')
                                                    <p class="text-danger"><strong>{{$message}}</strong></p>
                                                    @enderror
                                                </fieldset>

                                                <fieldset class="wrap-input">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                    <label for="frm-login-uname">{{__('auth.Email Address')}}:</label>
                                                    <input type="text" name="email" class="form-control"  placeholder="{{__('auth.Type your email address')}}" value="{{old('email')}}">
                                                           @error('email')
                                                           <p class="text-danger"><strong>{{$message}}</strong></p>
                                                           @enderror
                                                </fieldset>

                                                <fieldset class="wrap-input">
                                                    <i class="fa fa-lock"></i>
                                                    <label for="frm-login-pass">{{__('auth.password')}}:</label>
                                                    <input type="password" class="form-control"  id="frm-login-pass" name="password" placeholder="************">
                                                    @error('password')
                                                    <p class="text-danger"><strong>{{$message}}</strong></p>
                                                    @enderror
                                                </fieldset>
                                                <fieldset class="wrap-input">
                                                    <i class="fa fa-lock"></i>
                                                    <label for="frm-login-pass">{{__('auth.Confirm Password')}}:</label>
                                                    <input type="password" class="form-control"  name="password_confirmation" placeholder="************">
                                                </fieldset>

                                                <fieldset class="wrap-input " style="margin-top: 10px; color: black">
                                                    <label class="remember-field">
                                                        <input class="frm-input form-control" name="terms_and_condition" id="rememberme" value="1" type="checkbox"><span>{{__('auth.terms and condition')}} GG-Trade <a href="{{route('terms.policy')}}" style="color: red">{{__('auth.terms & conditions')}}</a>
                                                            <span class="text-danger" style="font-weight: bold; font-size: 15px">*</span></span>
                                                        @error('terms_and_condition')
                                                        <p class="text-danger"><strong>{{$message}}</strong></p>
                                                        @enderror
                                                    </label>
                                                </fieldset>
                                                <button type="submit" class="btn btn-submit" style="border-radius: 5px" value="Register" >{{__('auth.Register')}}</button>
                                            </div>
                                            </form>

                                            <div style="border-radius: 5px">
                                                <style>
                                                    .gmail{
                                                        border-radius: 5px;
                                                        background-color: #D24736 !important;
                                                    }
                                                </style>
                                                <a href="{{route('login.google')}}" class="btn gmail">  <i class="fa fa-google" style="font-size: 20px; padding-right: 20px"></i> Sign up with Google</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end main products area-->
                            </div>
                        </div><!--end row-->





    </div>


<style>
    .topsection{
        display: none;
    }
</style>

@endsection
