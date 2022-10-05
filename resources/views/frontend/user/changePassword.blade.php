@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">


<style>
    .topsection{
        display: none;
    }
    .btn-secondary{
        margin-left: 20%;
    }
    @media only screen and (max-width: 991px) {
        .btn-secondary{
            margin-left: 10%;
        }
    }
</style>


@section('content')
    <div class="row">
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 mt-5 col-md-offset-4">
            <div class=" main-content-area" style="margin-top: 50px;" >
                <div class="wrap-login-item ">
                    <div class="login-form form-item form-stl" style="background-color: rgba(239,239,239,0.70);">
                        <form name="frm-login" action="{{route('password.updates', $user->id)}}" method="post">
                                @csrf
                                <h3 class="form-title">Change your password</h3>
                            </fieldset>
                            <fieldset class="wrap-input">
                                <i class="fa fa-key"></i>
                                <label for="frm-login-pass">Current Password:</label>
                                <input type="password" id="frm-login-pass" name="currentpassword" placeholder="************">
                                @error('password')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror
                            </fieldset>
                            <fieldset class="wrap-input">
                                <i class="fa fa-lock"></i>
                                <label for="frm-login-pass">New Password:</label>
                                <input type="password" id="frm-login-pass" name="newpassword" placeholder="************">
                                @error('password')
                                <p class="text-danger"><strong>{{$message}}</strong></p>                                                    @enderror
                            </fieldset>
                            <fieldset class="wrap-input">
                                <i class="fa fa-lock"></i>
                                <label for="frm-login-pass">Confirm Password:</label>
                                <input type="password" id="frm-login-pass" name="newpassword_confirmation" placeholder="************">
                            </fieldset>
                            <button type="submit" class="btn btn-submit" value="Register" >{{__('Confirm')}}</button>
                        </form>
                    </div>
                    <div class="" style="padding:100px"> </div>

                </div>
            </div><!--end main products area-->

        </div>
    </div><!--end row-->



@endsection

