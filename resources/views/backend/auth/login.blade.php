<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GG-Trade Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset('backend/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/base/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/style.css')}}">
    <!-- endinject -->
</head>
<style>
    .mn{
        background-color: #A7E138;
    }
    .nb{
        background-color: transparent;
        border-radius: 10px;
        border: 1px solid black;

    }
    .form-control, .dataTables_wrapper select{
        border-color: inherit;

    }
    hr{
        background-color: black;
    }

    .mn:hover{
        background-color: #5f8019;
        border: 1px solid black;
    }
    .nb:hover{
        border-radius: 10px;
        border: 1px solid #A7E138;
    }

    .mt-1, .my-1 {
        margin-top: -4rem !important;
    }

    @media only screen and (max-width: 991px) {
        .nb{
            width: 90% !important;
            text-align: center;
            margin: 5px 15px !important;
        }

    }



</style>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="ml-5  nb">
                    <a href="{{route('home')}}" class="btn"><i class="fa fa-undo" style="font-size: 14px" aria-hidden="true"></i>
                        Go Back Home</a>
                </div>

                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>
                <div class="col-lg-4 mx-auto">

                    <div class="auth-form-light text-left py-5 px-4 px-sm-5 " >
                        <div class="text-center mt-4 mb-2" >
                            <a href="{{route('home')}}">
                                <img class="mt-1 pt-0" src="{{get_setting('logo')}}"  width="220px" height="55px">
                            </a>
                        </div>

                 <h2>Admin Login</h2>
                        <h6 class="font-weight-light mt-4">Sign in to continue.</h6>
                        <form class="pt-3" method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Type your email address" id="exampleInputEmail1" >
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color:red">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" id="exampleInputPassword1" name="password" placeholder="************" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color:red">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input" name="rememberme" id="rememberme" value="forever" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                        Keep me signed in
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                <a class="auth-link text-black" href="#" title="Forgotten password?">Forgot password?</a>
                                @endif

                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg auth-form-btn font-weight-medium btn-submit">{{ __('Login') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{asset('backend/assets/vendors/base/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{asset('backend/assets/js/off-canvas.js')}}"></script>
<script src="{{asset('backend/assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('backend/assets/js/template.js')}}"></script>
<!-- endinject -->
</body>

</html>

