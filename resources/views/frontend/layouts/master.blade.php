<!DOCTYPE html>
<html lang="en">
	<head>
    @include('frontend.layouts.head')
    </head>
	<body>
		<!-- HEADER -->
		<header id="header-ajax">
        @include('frontend.layouts.header')
        </header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation" >
        @include('frontend.layouts.nav')
		</nav>
		<!-- /NAVIGATION -->

        <div class="hisb">

        </div>

@yield('content')


        <!-- FOOTER -->
        <footer id="footer">

        @include('frontend.layouts.footer')

        </footer>
        <!-- /FOOTER -->

	</body>
</html>



@include('frontend.layouts.script')

<script>
    $(document).ready(function () {
        var path = "{{route('autosearch')}}";
        $('#search_text').autocomplete({
            source:function (request, response) {
                $.ajax({
                    url: path,
                    dataType: "JSON",
                    data:{
                        term:request.term
                    },
                    success:function (data) {
                        response(data);
                    }
                });
            },
            minLength:1,
        });
    });

</script>

<script>
    function currency_change(currency_code){
        $.ajax({
            type: 'post',
            url: '{{route('currency.load')}}',
            data:{
                currency_code: currency_code,
                _token: '{{csrf_token()}}',
            },
            success:function (response) {
                if(response['status']){
                    location.reload();
                }else{
                    alert('Server error');
                }
            }
        });
    }
</script>
