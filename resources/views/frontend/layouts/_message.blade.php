   <style>
       .fa-arrow-left{
           display: none;
       }

       @media only screen and (max-width: 991px) {

           .fa-arrow-left {
               display: block;
           }
       }
   </style>

    <div class="chat-header clearfix " id="fr">
        <div class="row fnn">
            <div class="col-1">
                <a href="{{route('message.index')}}" class="btn"><i class="fa fa-arrow-left" style="margin-left: -30px; border: 1px solid
black; border-radius: 3px; padding: 3px 5px"></i></a>
            </div>
            <div class="col-lg-8 col-9 pl-3">

                @if($sender)

                    @if($sender == 'announce')
                         <img src="{{$setting->favicon}}" alt="avatar" style="height: 40px">
                        <div class="chat-about">
                            <h6 class="m-b-0">
                                GG-TRADE
                            </h6>
                            <small>
                                    since {{ \Carbon\Carbon::parse('2022-01-01 00:02:37')->diffForHumans() }}
                            </small>
                        </div>

                    @else
                    <a  href="{{route('seller.shop', $sender->username)}}">


                        <div class="" style="background-image: url('{{$sender->photo == null ? Helper::userDefaultImage() : $sender->photo}}');
                            background-size: cover;
                            width: 40px;
                            height: 40px;
                            border-radius: 50%;
                            float: left;
                            ">
                        </div>
                    </a>
                    <div class="chat-about">
                        <h6 class="m-b-0">
                            <a style="color: black" href="{{route('seller.shop', $sender->username)}}">
                            {{$sender->username}}
                            </a>
                        </h6>
                        <small>
                            @if(Cache::has('is_online' . $sender->user_id))
                                <i class="fa fa-circle online text-success"></i> Online
                            @else
                                left {{ \Carbon\Carbon::parse($sender->last_seen)->diffForHumans() }}
                            @endif
                        </small>
                    </div>
                    @endif

            @endif
            </div>
            @auth
                <div class="col-lg-3 col-1 " id="subDiv">

                    <style>
                        .hovertext {
                            padding: 10px 10px;
                            border: 1px solid #17A2B8;
                        }
                        .hovertext:before {
                            content: attr(data-hover);
                            visibility: hidden;
                            opacity: 0;
                            width: max-content;
                            background-color: rgba(99, 187, 201, 0.86);
                            padding: 10px 15px;
                            color: black;
                            text-align: center;
                            border-radius: 5px;
                            transition: opacity 1s ease-in-out;
                            white-space: pre-line;

                            position: absolute;
                            z-index: 1;
                            left: -100;
                            top: -50;
                        }
                        .hovertext:hover:before {
                            opacity: 1;
                            visibility: visible;
                        }
                        .fa-bell-o .fa-bell-slash-o{
                            font-size: 25px;
                        }
                        #butt{
                            margin-top: 10px ;
                        }

                        @media only screen and (max-width: 991px) {

                            .hovertext-text {
                                display: none;
                            }

                            .hovertext:before {
                                display: none;
                            }
                            .fa-bell-o .fa-bell-slash-o{
                                font-size: 15px;
                            }
                            #butt{
                                margin-top: 2px;
                                margin-left: -17px;
                            }
                        }

                    </style>
                    <button id="butt" class="hovertext btn btn-outline-info" onclick="{{$subscribe ? 'disableNotifications()' : 'enableNotifications()' }}" data-hover="{{$subscribe ? 'Disable Notification' : 'Enable Notification' }}"><i class="fa {{$subscribe ? 'fa-bell-slash-o' : 'fa-bell-o' }}"> </i> </button>

                    <script>
                        var _registration = null;
                        function registerServiceWorker() {
                            return navigator.serviceWorker.register('../../js/service-worker.js')
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
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
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
                            location.reload();

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
                </div>
            @endauth
        </div>
    </div>

   @if($sender != 'announce')
   <style>
       .warning{
           padding: 10px;
           text-align: center;
           color: white;
           border-radius: 5px;
           background-color: rgba(255, 128, 0, 0.52);
       }
   </style>
   <div class="warning">
       Don't contact yourself outside this platform. It is against our term & condition
   </div>
   @endif
    <div class="chat-history" id="reload">
        @include('frontend.layouts._message-pd')
    </div>

   <div class="chat-message clearfix">
       <div class="input-group ">

           @if($sender != 'announce')
           <div class="row">
               <style>
                   .bodi:focus {
                       height:70px !important;
                       transition:0.5s;
                       overflow: hidden;

                   }

                   .bodi{
                       border: 0;
                   }


                   input[type=file]{
                       display: none;
                   }
                   .vv{
                       cursor:pointer;
                       font-size: 25px;
                       padding: 6px 10px;

                   }
                   .sen{
                       padding: 0;
                       margin: 0;
                   }

                   .fa-send{
                       border-radius: 30px;
                       margin-left: -5px;
                       padding: 10px;
                       background-color: #a7e138;
                   }
                   .gg{
                       padding-top: 3px ;
                       padding-left: 1px ;

                   }


                   @media only screen and (max-width: 991px) {
                       .fa-send{
                           border-radius: 30px;
                           margin-left: -5px;
                           padding: 10px;
                           background-color: #a7e138;

                       }

                   }

               </style>

               <input  name="body" id="imageName" class=" bodi form-control col-lg-10 col-sm-9 col-9" placeholder="Enter message here..." required style="background: transparent">

               <label for="inputTag" class="gg" >
                   <i class="fa fa-paperclip vv"></i>
                   <input type="file" id="inputTag" class="col-lg-1 col-sm-1 col-1">
               </label>

               <a id="submit" class="btn sen col-lg-1 col-sm-1 col-1"><i class="fa fa-send"></i></a>
               <span id="error" style="color: red; font-size: 13px; padding-left: 10px"> </span>



           </div>
           @endif
       </div>
   </div>

   @if($sender != 'announce')
<script>
    let hh = document.getElementById("fr");

    hh.addEventListener('keypress', logKey);

    function logKey(e) {
        let enter = `${e.code}`

        if(enter === 'Enter'){
            let receiver = {{$sender->user_id}};
            let body = document.getElementById("imageName").value;
            if(!body){
                error.innerText = 'You did not type any message!';
                return;
            }

            $.ajax({
                url: "{{route('message.store')}}",
                type: "post",
                data: {
                    '_token' : '{{ csrf_token() }}',
                    'receiver_id' : receiver,
                    'body' : body
                },
                dataType: 'json',

                success: function (response) {

                    error.innerText = response['error'];

                    if(!response['error']){
                        document.getElementById("imageName").value ='';
                        $('#reload').html(response['header']);
                        objDiv.scrollTop = objDiv.scrollHeight;
                    }


                    // You will get response from your PHP page (what you echo or print)
                },  error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });


        }
    }
</script>
   <script>
       var objDiv = document.getElementById("reload");

       function fun() {

           $.ajax({
               url: '{{route('fetch.message')}}',
               success: function (response) {

                       $('#reload').html(response['header']);
                       objDiv.scrollTop = objDiv.scrollHeight;
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
               }
           });
       }
       var interval = setInterval(fun, 15000);

       objDiv.onscroll = function (){
           clearInterval(interval);

       }

   </script>


   <script>
       let input = document.getElementById("inputTag");
       let error = document.getElementById("error");
       var objDiv = document.getElementById("reload");
       objDiv.scrollTop = objDiv.scrollHeight;


       let formData = new FormData();

       input.addEventListener("click", ()=> {
           error.innerText = '';
       })


       input.addEventListener("change", ()=>{

           let inputImage = document.querySelector("input[type=file]").files[0];

           if(inputImage.size > 4000000){
               error.innerText = 'File too large. Maximum upload is 4MB';
               return
           }

           formData.append("file", inputImage);
           formData.append("_token", '{{ csrf_token() }}');
           formData.append("receiver_id", {{$sender->user_id}});
           $.ajax({
               url: "{{route('message.file')}}",
               type: "post",
               data:  formData,
               contentType: false,
               processData: false,
               dataType: 'json',

               success: function (response) {

                   error.innerText = response['error'];

                   if(!response['error']){

                       console.log(response);
                       $('#reload').html(response['header']);
                       objDiv.scrollTop = objDiv.scrollHeight;

                   }

                   // You will get response from your PHP page (what you echo or print)
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
               }
           });



       })
   </script>

   <script>
       let submit = document.getElementById("submit");

       submit.addEventListener("click", ()=>{
           let receiver = {{$sender->user_id}};
           let body = document.getElementById("imageName").value;
           if(!body){
               error.innerText = 'You did not type any message!';
               return;
           }

           $.ajax({
               url: "{{route('message.store')}}",
               type: "post",
               data: {
                   '_token' : '{{ csrf_token() }}',
                   'receiver_id' : receiver,
                   'body' : body
               },
               dataType: 'json',

               success: function (response) {

                   error.innerText = response['error'];

                   if(!response['error']){
                       document.getElementById("imageName").value ='';
                       $('#reload').html(response['header']);
                       objDiv.scrollTop = objDiv.scrollHeight;
                   }


                   // You will get response from your PHP page (what you echo or print)
               },  error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
               }
           });



       })


   </script>
   @endif
