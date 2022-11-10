<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>@yield('tutor-title') | {{ config('app.name') }}</title>

  <meta name="description" content="E-Tutor Class is Nepal’s First Open Online Tutoring Class  which connects Teachers, Students, Institutions, School, Colleges in a single platform and fulfills the common needs of both the teacher and the students i.e., the giver and the receiver. It is dedicated to enhancing Learning system quality and access through the integration of technology. It manages expert resources from various fields in our work ecosystem and utilizes their skills, experiences, knowledge as well as time to provide bundle-up services to the students at reasonable charges so that they can excel in their future and career.">
  <meta name="keywords" content="E-tutor Class, e-tutor, online class, online class in Nepal, best online class, Loksewa class, online psc. class">

  <meta property="og:image" content="https://www.etutorclass.com/images/logo.webp" />
  <meta property="og:description" content="E-Tutor Class is Nepal’s First Open Online Tutoring Class which connects Teachers, Students, Institutions, School, Colleges in a single platform and fulfills the common needs of both the teacher and the students i.e., the giver and the receiver. It is dedicated to enhancing Learning system quality and access through the integration of technology." />
  <meta property="og:title" content="Nepal’s First Open Online Tutoring Class" />

  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">

    
     <!-- Global site tag (gtag.js) - Google Analytics -->
     <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZS3KVP4N6H"></script>
     <script>
       window.dataLayer = window.dataLayer || [];
       function gtag(){dataLayer.push(arguments);}
       gtag('js', new Date());
     
       gtag('config', 'G-ZS3KVP4N6H');
     </script>

   <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
  {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

  {{-- summernote --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" />
<style>
  body{
    background: #F7F7F7;
  }
  
  @media (min-width: 1400px){
.container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    max-width: 1200px;
}
}
  .login-username-home{
    display: none;
  }
</style>
</head>
<body>

  <!-- Back to top button -->
  <div class="back-to-top"></div>

  @include('front.includes.header')

  <section class="tutor-top-header">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-9">
        <h2 class=""><span>@yield('tutor-title-icon')</span> @yield('tutor-title')</h2>
      </div>
      <div class="col-md-6 col-3">
        <div class="tutor-top-right">
          <div class="tutor-details">
            <h5>{{ Auth::user()->name }} (Tutor) </h5>
            <span>{{ Auth::user()->email }}</span>
          </div>
          <div class="tutor-image">
            @if(auth()->user()->photo)
              <img src="/storage/{{auth()->user()->photo }}" alt="{{auth()->user()->name }}" width="50">
            @else
              <img src="{{ asset('images/student.jpg') }}" alt="{{auth()->user()->name }}" width="50">
            @endif
          </div>
        </div>
        <div class="justify-content-end">
          <button class="mobile-view-student-btn" onclick="myNavbar()">
          @if(auth()->user()->photo)
            <img src="/storage/{{auth()->user()->photo }}" alt="">
          @else
            {{ $firstStringCharacter = substr(Auth::user()->name, 0, 1) }}
          @endif
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="tutor-home-container">
  <div class="container">
    <div class="tutor-main-container">
      <div class="tutor-side-navbar" id="tutor-side-navbar">
        <ul class="nav flex-column" id="student-nav">
          <li class="active nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/home"><i class="fas fa-house-user"></i>Tutor Home</a>
          </li>
          <li class=" nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/classroom"><i class="fas fa-laptop"></i>Classroom</a>
          </li>
          <li class=" nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/reviews"><i class="fas fa-comment-dots"></i>Reviews</a>
          </li>
          <li class=" nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/special-courses"><i class="fas fa-book"></i>My Courses</a>
          </li>
          <li class=" nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/video-course"><i class="fas fa-book"></i>Video Courses</a>
          </li>
          <li class=" nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/payment-requests"><i class="fas fa-money-check-alt"></i>Payment Requests</a>
          </li>
          <li class=" nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/posts"><i class="far fa-newspaper"></i>Posts</a>
          </li>
          {{-- <li class=" nav-item">
            <a class="nav-link" aria-current="page" href="/tutor/messenger"><i class="fa fa-comments"></i>Messenger</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="/profile"><i class="fa fa-user"></i>Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/change-password"><i class="fa fa-key"></i>Change Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
      <div class="tutor-container">
        @yield('content')
      </div>
    </div>
  </div>
</section>

  @include('front.includes.footer')
<script src="//npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>

<script>
  function myNavbar() {
    var x = document.getElementById("tutor-side-navbar");
    if (x.style.width === "80%") {
      x.style.width = "0";
    } else {
      x.style.width = "80%";
    }
  }
  </script>

<script>
  $(document).ready(function() {
  "use strict";

  $('ul#student-nav > li').click(function(e) {
    // e.preventDefault();
    $('ul#student-nav > li').removeClass('active');
    $(this).addClass('active');
  });
});
</script>

<script>
  // for summer note
  $(document).ready(function() {
    $('.summernote').summernote({
      height: 200,
    });
  });
  /***/
</script>
<!-- Scripts -->
<script src="{{ asset('js/libraries/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" async src="https://play.vidyard.com/embed/v4.js"></script>
<script src="{{ asset('js/libraries/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/libraries/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/front.js') }}"></script>
<script src="{{ asset('admin/js/sweetalert2@11.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
{{-- summernote --}}

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
</body>
</html>
