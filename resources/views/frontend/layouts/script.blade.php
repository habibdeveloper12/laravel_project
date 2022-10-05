<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

		<!-- jQuery Plugins -->
        <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
        <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('frontend/js/slick.min.js')}}"></script>
		<script src="{{asset('frontend/js/nouislider.min.js')}}"></script>
		<script src="{{asset('frontend/js/jquery.zoom.min.js')}}"></script>
		<script src="{{asset('frontend/js/main.js')}}"></script>


{{--autosearch--}}
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>





<script>
    const trustbox = document.getElementById('trustbox');
    window.Trustpilot.loadFromElement(trustbox);
</script>

<script src="{{asset('frontend/assets/js/bootstrap-notify.js')}}"></script>


        <script>
            setTimeout(function (){
                $('#alert').slideUp();
            },3000)
        </script>


<script>
    @if(\Illuminate\Support\Facades\Session::has('success'))
        $.notify("Success: {{\Illuminate\Support\Facades\Session::get('success')}}", {
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            }
        });
    @endif

    @php
            \Illuminate\Support\Facades\Session::forget('success');
    @endphp


    @if(\Illuminate\Support\Facades\Session::has('error'))
    $.notify("Sorry: {{\Illuminate\Support\Facades\Session::get('error')}}", {
        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        }
    });
    @endif

    @php
        \Illuminate\Support\Facades\Session::forget('error');
    @endphp

</script>



{{--<!--Start of Tawk.to Script-->--}}
{{--<script type="text/javascript">--}}
{{--    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();--}}
{{--    (function(){--}}
{{--        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];--}}
{{--        s1.async=true;--}}
{{--        s1.src='https://embed.tawk.to/624edc33c72df874911dc334/1g020oanp';--}}
{{--        s1.charset='UTF-8';--}}
{{--        s1.setAttribute('crossorigin','*');--}}
{{--        s0.parentNode.insertBefore(s1,s0);--}}
{{--    })();--}}
{{--</script>--}}
{{--<!--End of Tawk.to Script-->--}}


@yield('scripts')

