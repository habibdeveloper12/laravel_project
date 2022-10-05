<!DOCTYPE html>
<html lang="en">
@php

    $setting = \App\Models\Settings::first();
@endphp

    <head>
    @include('support.layouts.head')
    </head>


	<body>
        @include('support.layouts.header')


@yield('content')


        <!-- FOOTER -->
        <footer class="border-top">

        @include('support.layouts.footer')

        </footer>
        <!-- /FOOTER -->

	</body>

</html>



@include('support.layouts.script')
