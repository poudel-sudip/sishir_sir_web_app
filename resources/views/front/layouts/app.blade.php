<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>@yield('title') | {{ config('app.name') }}</title>
  <meta name="description" content="E-Tutor Class is Nepal’s First Open Online Tutoring Class which connects Teachers, Students, Institutions, School, Colleges in a single platform and fulfills the common needs of both the teacher and the students i.e., the giver and the receiver. It is dedicated to enhancing Learning system quality and access through the integration of technology. It manages expert resources from various fields in our work ecosystem and utilizes their skills, experiences, knowledge as well as time to provide bundle-up services to the students at reasonable charges so that they can excel in their future and career.">
  <meta name="keywords" content="E-tutor Class, e-tutor, online class, online class in Nepal, best online class, Loksewa class, online psc. class, top online preparation class in nepal, top online course preparation in nepal, top online institute near me, online psc course in nepal, psc class 2078, top loksewa aayog preparation in Nepal, top loksewa institute near me, loksewa online preparation, loksewa aayog course, loksewa aayog online exam prepataion, competitive exam preparation in Nepal, Online institute near me, psc online preparation class in nepal, online psc preparation gandaki pradesh">

  <meta property="og:image" content="https://www.etutorclass.com/images/logo.webp" />
  <meta property="og:description" content="E-Tutor Class is Nepal’s First Open Online Tutoring Class which connects Teachers, Students, Institutions, School, Colleges in a single platform and fulfills the common needs of both the teacher and the students i.e., the giver and the receiver. It is dedicated to enhancing Learning system quality and access through the integration of technology." />
  <meta property="og:title" content="Nepal’s First Open Online Tutoring Class" />

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
