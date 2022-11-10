<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>@yield('student-title') | {{ config('app.name') }}</title>

  <meta name="description" content="E-Tutor Class is Nepal’s First Open Online Tutoring Class  which connects Teachers, Students, Institutions, School, Colleges in a single platform and fulfills the common needs of both the teacher and the students i.e., the giver and the receiver. It is dedicated to enhancing Learning system quality and access through the integration of technology. It manages expert resources from various fields in our work ecosystem and utilizes their skills, experiences, knowledge as well as time to provide bundle-up services to the students at reasonable charges so that they can excel in their future and career.">
  <meta name="keywords" content="E-tutor Class, e-tutor, online class, online class in Nepal, best online class, Loksewa class, online psc. class">

  <meta property="og:image" content="https://www.etutorclass.com/images/logo.webp" />
  <meta property="og:description" content="E-Tutor Class is Nepal’s First Open Online Tutoring Class which connects Teachers, Students, Institutions, School, Colleges in a single platform and fulfills the common needs of both the teacher and the students i.e., the giver and the receiver. It is dedicated to enhancing Learning system quality and access through the integration of technology." />
  <meta property="og:title" content="Nepal’s First Open Online Tutoring Class" />

  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    <style>
      .page-footer, .lower-footer{
          display: block;
        }
      @media (max-width:767px){
        .page-footer, .lower-footer{
          display: none;
        }
      }
      body{
      background: #F7F7F7;
      position: relative;
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
    
     <!-- Global site tag (gtag.js) - Google Analytics -->
     <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZS3KVP4N6H"></script>
     <script>
       window.dataLayer = window.dataLayer || [];
       function gtag(){dataLayer.push(arguments);}
       gtag('js', new Date());
     
       gtag('config', 'G-ZS3KVP4N6H');
     </script>

    <!-- Scripts -->
    <script src="{{ asset('js/libraries/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" async src="https://play.vidyard.com/embed/v4.js"></script>
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
   {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

   {{-- summernote --}}
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" />

</head>
<body>

  <!-- Back to top button -->
  <div class="back-to-top"></div>

  @include('front.includes.header')

  <section class="student-top-header">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-8">
          <h2 class=""><span>@yield('student-title-icon')</span> @yield('student-title')</h2>
        </div>
        <div class="col-md-6 col-4">
          <div class="student-top-right">
            <div class="student-notification-icon">
              <div class="dropdown student-user-setting">
                <a href="" title="setting" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-cog"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                  <li><a class="dropdown-item" href="/profile"><i class="fas fa-user-tie"></i> Profile</a></li>
                  <li><a class="dropdown-item" href="/change-password"><i class="fas fa-key"></i> Change Password</a></li>
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                      <form id="logout-form" action="{{ route('logout') }}"` method="POST" class="d-none">
                        @csrf
                      </form>
                  </li>
                </ul>
              </div>
              <a href="/student/notifications" class="dashboard-notification position-relative" title="notification">
                <i class="fa fa-bell" aria-hidden="true"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{auth()->user()->userNotifications()->where('read','=','No')->count()}}
                    <span class="visually-hidden">unread messages</span>
                  </span>
              </a>
            </div>
            <div class="student-details">
              <h5>{{ Auth::user()->name }}</h5>
              <span>{{ Auth::user()->email }}</span>
              <span>{{ Auth::user()->contact }}</span>
            </div>
            <div class="student-image">
              @if(auth()->user()->photo)
                <img src="/storage/{{auth()->user()->photo }}" alt="{{auth()->user()->name }}" width="50">
              @else
                <img src="{{ asset('images/student.jpg') }}" alt="{{auth()->user()->name }}" width="50">
              @endif
            </div>
          </div>
          <div class="justify-content-end student-notification-mobile">
            <a href="/student/notifications" class="position-relative" title="notification">
              <i class="fa fa-bell" aria-hidden="true"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  {{auth()->user()->userNotifications()->where('read','=','No')->count()}}
                  <span class="visually-hidden">unread messages</span>
                </span>
            </a>
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

  <section class="student">
    <div class="container">
      <div class="student-main-container">
        <div class="student-side-navbar" id="student-side-navbar">
          <ul class="nav flex-column student-sidebar-list" id="student-nav">
            <li class="active nav-item">
              <a class="nav-link" aria-current="page" href="/student/home"><i class="fas fa-house-user"></i> Student Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/enrolled"><i class="far fa-calendar-check text-primary"></i>Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/enrolled/classroom"><i class="fas fa-laptop text-pink"></i> My Classroom</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/tutor-special/courses"><i class="fas fa-chalkboard-teacher text-info"></i>Tutor Specials</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/video-course"><i class="far fa-list-alt text-orange"></i>Video Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/ebook"><i class="fas fa-book-open text-black"></i>E-Book Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/exam-hall"><i class="fas fa-laptop-house text-info"></i>Exam Hall</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student/messenger"><i class="fas fa-comments text-success" aria-hidden="true"></i>Messenger</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/profile"><i class="fas fa-user text-primary" aria-hidden="true"></i>Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/change-password"><i class="fas fa-key text-success" aria-hidden="true"></i>Change Password</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt text-danger"></i>Logout</a>
              <form id="logout-form" action="{{ route('logout') }}"` method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </div>
        <div class="student-container">
          @yield('content')
        </div>
      </div>
    </div>
  </section>  

  @include('front.includes.footer')
<script src="//npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>

<script>
  function myNavbar() {
    var x = document.getElementById("student-side-navbar");
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

<script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
      integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
      crossorigin="anonymous"
    ></script>

<script src="{{ asset('js/libraries/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/libraries/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/libraries/wow.min.js') }}"></script>
{{--<script src="{{ asset('js/main.js') }}"></script>--}}

{{--  <script src="{{ asset('js/libraries.js') }}"></script>--}}

<script src="{{ asset('js/front.js') }}"></script>
{{-- summernote --}}

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
</body>
</html>
