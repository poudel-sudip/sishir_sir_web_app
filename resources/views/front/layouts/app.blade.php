<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>@yield('title') | {{ config('app.name') }}</title>
  <meta name="description" content="Mr. Shisir Kumar Adhikari is a government job holder public health practitioner, young academician, good trainer and author of Mentor Series Books.">
  <meta name="keywords" content="health loksewa, health, books, shishir adhikari, shishir sir, shisir adhikari, loksewa, loksewa health, shishir loksewa, psc, psc health ">

  <meta property="og:image" content="" />
  <meta property="og:description" content="Mr. Shisir Kumar Adhikari is a government job holder public health practitioner, young academician, good trainer and author of Mentor Series Books." />
  <meta property="og:title" content="Health Loksewa" />

  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

  
     <!-- Global site tag (gtag.js) - Google Analytics -->
     <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZS3KVP4N6H"></script>
     <script>
       window.dataLayer = window.dataLayer || [];
       function gtag(){dataLayer.push(arguments);}
       gtag('js', new Date());
     
       gtag('config', 'G-ZS3KVP4N6H');
     </script>

{{--  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">--}}
{{--  <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">--}}
{{--  <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">--}}
{{--  <link rel="stylesheet" href="{{ asset('css/animate.css') }}">--}}
{{--  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">--}}

   <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/libraries/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" async src="https://play.vidyard.com/embed/v4.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>

  <!-- Back to top button -->
  <div class="back-to-top"></div>

  @include('front.includes.header')
  @yield('content')

  @include('front.includes.footer')

<script src="{{ asset('js/libraries/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/libraries/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/libraries/wow.min.js') }}"></script>
{{--<script src="{{ asset('js/main.js') }}"></script>--}}

{{--  <script src="{{ asset('js/libraries.js') }}"></script>--}}
  <script src="{{ asset('js/front.js') }}"></script>

</body>
</html>
