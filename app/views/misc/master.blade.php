<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta property="og:image" content="{{asset('images/meta_for_fb.jpg')}}"/>
    <meta property="og:url" content="http://technothlon.techniche.org"/>
    <meta property="og:description" content="Technothlon is an international school championship organized by the students of IIT Guwahati. The ultimate test of logic, Inspiring Young Minds since 2004!"/>
    <meta property="og:title" content="Technothlon | IIT Guwahati" />
    <meta name="description" content="Technothlon is the international school championship conducted by the students of IIT Guwahati!" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="distribution" content="web">
    <link href="https://plus.google.com/+technothlon" rel="publisher"/>
    <meta name="google-site-verification" content="cM5V2LaW9KuvVYaafRbwCqPTqOhh-nbkBKgM0iKX7eA" />
    <title>@yield('title', 'Technothlon | Home')</title>
    <link href="{{asset('bootstrap_site/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap_site/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap_site/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap_site/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap_site/css/stickyfooter.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap_site/css/prettyPhoto.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('sprites/landing.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('sprites/home.css') }}">
    <script src="{{asset('bootstrap_site/js/jquery.js')}}"></script>
    
    <!--[if lt IE 9]>
    <script src="{{asset('bootstrap_site/js/html5shiv.js')}}"></script>
    <script src="{{asset('bootstrap_site/js/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{asset('logo.ico')}}">

    @yield('head')
</head><!--/head-->
<body>
<header class="navbar navbar-inverse navbar-fixed-top midnight-blue" role="banner">
    <div class="container" style="padding: 0 0 0 0; max-width: 1300px !important;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
</header><!--/header-->
<div id="body_template" style="height: 100%">
    @yield('body')
</div>


<script src="{{asset('bootstrap_site/js/bootstrap.min.js')}}"></script>
<script src="{{asset('bootstrap_site/js/main.js')}}"></script>
<script src="{{asset('bootstrap_site/js/jquery.prettyPhoto.js')}}"></script>
<script src="https://npmcdn.com/isotope-layout@3.0/dist/isotope.pkgd.min.js"></script>

@yield('script')

</body>
</html>