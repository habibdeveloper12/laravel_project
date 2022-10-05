<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{get_setting('meta_description')}}">
        <meta name="keywords" content="{{get_setting('meta_keywords')}}">

@php
    $setting = \App\Models\Settings::first();
@endphp

        <meta name="author" content="Elenor ray">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>GG-Trade</title>

        <link rel="icon" href="{{asset($setting->favicon)}}" type="image/x-icon">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Rubik Moonrocks' rel='stylesheet'>

		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>


		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="{{asset('frontend/css/slick.css')}}"/>
		<link type="text/css" rel="stylesheet" href="{{asset('frontend/css/slick-theme.css')}}"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="{{asset('frontend/css/nouislider.min.css')}}"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxygen">

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}">

        <link type="text/css" rel="stylesheet" href="{{asset('frontend/css/style1.css')}}"/>

		<!-- Custom stylesheet -->
		<link type="text/css" rel="stylesheet" href="{{asset('frontend/css/style.css')}}"/>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->


        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


        {{--auto complete--}}
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">


        <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
        <script src="https://kit.fontawesome.com/6fb9646234.js" crossorigin="anonymous"></script>



<style>
    .donot{
        display: none;
    }
    @media only screen and (max-width: 991px) {
        .donot {
            display: block;

        }
    }
    body{
        background-image: url({{asset($setting->background)}}) !important;
        background-size: cover;


    }
</style>

@yield('styles')
