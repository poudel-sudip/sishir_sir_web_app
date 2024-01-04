<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<meta content="text/html; charset=utf-8" http-equiv="Content-Type">-->
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>@yield('page_title') | {{ config('app.name') }}</title>
  <meta name="description" content="Mr. Shisir Kumar Adhikari is a government job holder public health practitioner, young academician, good trainer and author of Mentor Series Books.">
  <meta name="keywords" content="health loksewa, health, books, shishir adhikari, shishir sir, shisir adhikari, loksewa, loksewa health, shishir loksewa, psc, psc health ">
  
  <meta property="og:type" content="article" />
  <meta property="og:site_name" content="Shisir Adhikari" />
  <meta property="og:title" content="@yield('og-title','')" />
  <meta property="og:url" content="@yield('og-url', url(''))" />
  <meta property="og:image" content="@yield('og-image', asset('images/default-post.png'))" />
  <meta property="og:image:alt" content="{{asset('images/default-post.png')}}" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:description" content="@yield('og-description','')" />

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
    {{-- <script type="text/javascript" async src="https://play.vidyard.com/embed/v4.js"></script> --}}
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=63ce36b638862e00198c0bcc&product=inline-share-buttons&source=platform" async="async"></script> 
    <script src="{{ asset('js/app.js') }}" defer></script>   

</head>
<body>  

  <?php 
    $page_title = View::getSection('page_title', '');
    $page_url = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $view_count = Helper::addViewCount($page_title,$page_url);
  ?>

  @include('front.includes.header')

  @yield('content')

  @include('front.includes.footer')

  <!-- Back to top button -->
  <div class="back-to-top" id="back_to_top"> <i class="fa fa-angle-up"></i></div>

  <script src="{{ asset('js/libraries/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/libraries/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('js/libraries/wow.min.js') }}"></script>
  {{--<script src="{{ asset('js/main.js') }}"></script>--}}

  {{--  <script src="{{ asset('js/libraries.js') }}"></script>--}}
  <script src="{{ asset('js/front.js') }}"></script>

  <script type="text/javascript" src="{{asset('js/noprint.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/misc.js')}}"></script>

</body>
</html>
