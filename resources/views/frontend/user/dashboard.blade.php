@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">



<style>
    .donot{
        display: none;

    }
    .ord{
        margin-top: 20px !important;
    }
    .topsection{
        display: none;
    }
    .text-danger{
        margin-left: 45%;
    }
    .btn-secondary{
        margin-left: 35%;
    }
    .col-sm-4{
        margin-left: 35%;
    }


    @media only screen and (max-width: 991px) {
        .text-danger{
            margin-left: 17%;
        }
        .text{
            margin-top: 15px;
        }
        .ord{
            margin-top: 50px !important;
            padding: 0 28px!important;
        }
        .btn-secondary{
            margin-left: 7%;
        }
        .col-sm-4{
            margin-left: 7%;
        }
        .donot{
            display: block;

        }
    }
</style>


@section('content')

    <div class="container col-12 ord" >

        <div class="row" style="margin-bottom: 0px">
            <div class="col-md-12 col-lg-12">
                @if($user->photo)
                <div class="d-flex flex-column align-items-center text-center p-3 py-5" style="
                    background-image: url('{{$user->photo}}');
                    background-position: center;
                    background-size: cover;
                    margin: 0 auto;
                    border-radius: 50%;
                    height: 200px;
                    width:200px
                    "  >


                    @else
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" src="{{Helper::userDefaultImage()}}">
                    @endif
                </div>
            </div>
        </div>

        <div class="row ">
            <span class=" col-12 font-weight-bold text-center pb-4" style="color: #efefef" >{{$user->username}}</span>

            <span id="error" class="col-12 text-center" style="color: red; font-size: 15px; margin-left:15px;"></span>
        </div>

            <div class="row">

                <style>
                    input[type=file]{
                        display: none;
                    }
                </style>

                <label for="inputTag" class="col-md-4 col-sm-12 p-4 mt-2 btn btn-primary " style="margin: 0 auto">

                        Change Avatar
                         <input type="file" id="inputTag" name="photo" class="form-control" >

                </label>
            </div>

        <a href="{{route('user.changePass')}}">   <div class="row">
                <div class="col-md-4 col-sm-12 p-4 mt-2 btn btn-primary" style="margin: 0 auto">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    Change Password
                </div>
            </div>
        </a>

        <a data-toggle="modal" data-target="#changemail"> <div class="row">
                <div class="col-md-4 col-sm-12 p-4 mt-2 btn btn-primary" style="margin: 0 auto">
                    <i class="fa fa-envelope-o" aria-hidden="true"> </i>
                    Change Email
                </div>
            </div>
        </a>

            <!-- Modal -->
            <div class="modal fade" id="changemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Email confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Enter New Email Address :</p>
                            <form action="{{route('change.email')}}" method="post">
                                @csrf
                                <input type="text" class="form-control" name="email" style="width: 70%;  float: left">
                                <button type="submit" class="btn btn-primary ml-1">Send Link</button>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row" style="padding: 15px; background-color: rgba(239,239,239,0.64); border-radius: 5px;margin-top: 50px">
                    <div class="col-md-2 col-sm-12"> <i class="fa fa-bell-o" style="font-size: 100px; border-radius: 50%; background-color: var(--col); padding: 20px"> </i></div>
                    <div class="col-md-9 col-sm-12 text ">
                        <h3>Push Notifications</h3>
                        <p>These are small pop-up notifications displayed on various devices. </p>
                        <p>They work in browsers such as Chrome, Firefox, Chromium, Opera and Yandex Browser)
                        as well as Android devices. They do not run on iOS.
                        </p>
                        @if($subscribe)
                            <button class="subs btn btn-danger" style="padding: 10px 80px;" onclick="disableNotifications()"> Disable</button>
                        @else
                            <button class="subs btn btn-success" style="padding: 10px 80px;" onclick="enableNotifications()"> Enable</button>
                        @endif

                    </div>
                </div>

            <script>
                function sendNotification(){
                    var data = new FormData();
                    {{--data.append('title', 'lolol');--}}
                    {{--data.append('_token', '{{ csrf_token() }}');--}}
                    {{--data.append('body', 'mumumum');--}}
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', "{{url('/api/send-notification/'.auth()->user()->id)}}", true);
                    xhr.onload = function () {
                        // do something to response
                        console.log(this.responseText);
                    };
                    xhr.send(data);
                }
                var _registration = null;
                function registerServiceWorker() {
                    return navigator.serviceWorker.register('../js/service-worker.js')
                        .then(function(registration) {
                            console.log('Service worker successfully registered.');
                            _registration = registration;
                            return registration;
                        })
                        .catch(function(err) {
                            console.error('Unable to register service worker.', err);
                        });
                }
                function askPermission() {
                    return new Promise(function(resolve, reject) {
                        const permissionResult = Notification.requestPermission(function(result) {
                            resolve(result);
                        });
                        if (permissionResult) {
                            permissionResult.then(resolve, reject);
                        }
                    })
                        .then(function(permissionResult) {
                            if (permissionResult !== 'granted') {
                                throw new Error('We weren\'t granted permission.');
                            }
                            else{
                                subscribeUserToPush();
                            }
                        });
                }
                function urlBase64ToUint8Array(base64String) {
                    const padding = '='.repeat((4 - base64String.length % 4) % 4);
                    const base64 = (base64String + padding)
                        .replace(/\-/g, '+')
                        .replace(/_/g, '/');
                    const rawData = window.atob(base64);
                    const outputArray = new Uint8Array(rawData.length);
                    for (let i = 0; i < rawData.length; ++i) {
                        outputArray[i] = rawData.charCodeAt(i);
                    }
                    return outputArray;
                }
                function getSWRegistration(){
                    var promise = new Promise(function(resolve, reject) {
                        // do a thing, possibly async, then…
                        if (_registration != null) {
                            resolve(_registration);
                        }
                        else {
                            reject(Error("It broke"));
                        }
                    });
                    return promise;
                }
                function subscribeUserToPush() {
                    getSWRegistration()
                        .then(function(registration) {
                            console.log(registration);
                            const subscribeOptions = {
                                userVisibleOnly: true,
                                applicationServerKey: urlBase64ToUint8Array(
                                    "{{env('VAPID_PUBLIC_KEY')}}"
                                )
                            };
                            return registration.pushManager.subscribe(subscribeOptions);
                        })
                        .then(function(pushSubscription) {
                            console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
                            sendSubscriptionToBackEnd(pushSubscription);
                            return pushSubscription;
                        });
                }
                function sendSubscriptionToBackEnd(subscription) {
                    return fetch('/api/save-subscription/{{Auth::user()->id}}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(subscription)
                    })
                        .then(function(response) {
                            if (!response.ok) {
                                throw new Error('Bad status code from server.');
                            }
                            return response.json();
                        })
                        .then(function(responseData) {
                            if (!(responseData.data && responseData.data.success)) {
                                throw new Error('Bad response from server.');
                            }

                        });
                }
                async function enableNotifications(){
                    //register service worker
                    //check permission for notification/ask
                    await askPermission();
                    location.reload()

                }

                function disableNotifications(){
                    @if($subscribe)
                    $.ajax({
                        url: "{{route('disable.notification')}}",
                        type: "post",
                        data: {
                            '_token' : '{{ csrf_token() }}',
                            'body' : 'disable',
                            'id': {{$subscribe->id}}
                        },
                        dataType: 'json',

                        success: function (response) {

                            location.reload();

                            // You will get response from your PHP page (what you echo or print)
                        },  error: function(jqXHR, textStatus, errorThrown) {
                            // console.log(textStatus, errorThrown);
                        }
                    });
                    @endif
                }

                registerServiceWorker();
            </script>

            <div class="" style="padding: 30px">
            </div>


        <script>
            let input = document.getElementById("inputTag");
            let error = document.getElementById("error");

            let formData = new FormData();

            input.addEventListener("click", ()=> {
                error.innerText = '';
            })


            input.addEventListener("change", ()=>{

                let inputImage = document.querySelector("input[type=file]").files[0];

                if(inputImage.size > 2000000){
                    error.innerText = 'File too large. Maximum upload is 2MB';
                    return
                }

                formData.append("file", inputImage);
                formData.append("_token", '{{ csrf_token() }}');
                $.ajax({
                    url: "{{route('update.avatar')}}",
                    type: "post",
                    data:  formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',

                    success: function (response) {

                        if(response['error'] == 'The file has invalid image dimensions.'){
                            error.innerText = 'Image dimension must be 450 x 1024 or above.';
                        }else{
                            error.innerText = response['error'];
                        }

                        if(!response['error']){
                            location.reload(true)
                        }

                        // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });



            })
        </script>


    </div>

@endsection
