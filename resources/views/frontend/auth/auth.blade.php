@extends('frontend.layouts.master')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<style>
    .logg{
        text-align: left;
        box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.71);
    }
</style>




@section('content')

<div class="section">
    <div class="row">
        <div class="col-lg-4 col-sm-12  justify-content-around mt-5 col-lg-offset-4 col-md-offset-4 ">
            <div class=" main-content-area ">
                <div class="wrap-login-item ">
                    <div class="login-form form-item form-stl logg">
                        <form name="frm-login" action="{{route('login.submit')}}" method="post">
                            @csrf
                            <fieldset class="wrap-title">
                                <h3 class="form-title">{{__('auth.log in to your account')}}</h3>
                            </fieldset>
                            <fieldset class="wrap-input">
                                <label for="frm-login-uname">{{__('auth.Email Address')}}:</label>
                                <input type="text"  class="form-control" id="frm-login-uname" name="email" placeholder="{{__('auth.Type your email address')}}" value="{{old('email')}}">
                                @error('email')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror
                            </fieldset>
                            <fieldset class="wrap-input">
                                <label for="frm-login-pass">{{__('auth.password')}}:</label>
                                <input type="password" id="frm-login-pass"  class="form-control" name="password" placeholder="************">
                                @error('password')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror
                            </fieldset>

                            <fieldset class="wrap-input">
                                <label class="remember-field">
                                    <input type="checkbox" class="frm-input form-control" name="remember" id="remember"><span>{{__('auth.Remember me')}}</span>
                                </label>
                                <a class="link-function left-position" href="{{route('reset.password')}}" title="Forgotten password?">{{__('auth.Forgotten password')}}?</a>
                            </fieldset>
                            <button type="submit" class="btn btn-submit" style="border-radius: 5px" > Login</button>
                        </form>


                        <p style="text-align: center; padding: 5px"> {{__("auth.Don't have an account")}}? <a href="{{route('user.register')}}">
                                {{__('auth.Register here')}}</a> </p>

                        <div>
                            <style>
                                .gmail{
                                    background-color: #D24736 !important;
                                    border-radius: 5px;
                                }
                            </style>
                            <a href="{{route('login.google')}}" class=" btn gmail">  <i class="fa fa-google" style="font-size: 20px; padding-right: 20px"></i> Sign in with Google</a>
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
