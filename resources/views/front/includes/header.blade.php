<header>
  <div class="topbar">
    <div class="container">
      <div class="row">
        <div class="col-md-2 text-sm">
          <div class="site-logo">
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
          </div>
        </div>
        <div class="col-md-5">
          <div class="search-area">
              <form action="/search/" method="GET">
                  <div class="input-group input-home-search">
                      <input type="text" class="form-control" placeholder="Search (courses)" aria-label="Recipient's username" aria-describedby="button-addon2" name="query">
                      <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                  </div>
              </form>
          </div>
        </div>
        <div class="col-sm-5 text-right text-sm">
          <nav class="navbar navbar-expand-md">
              {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                  <i class="fa fa-bars" aria-hidden="true"></i>
              </button> --}}

              <div class="auth-navbar" id="navbarSupportedContent">
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav justify-content-end">
                      <!-- Authentication Links -->
                      <li class="nav-item manual-booking">
                        <a class="nav-link login-user" href="/manual-booking" role="button">
                          Manual Booking
                      </a>
                      </li>
                      @guest
                          @if (Route::has('login'))
                              <li class="nav-item">
                                  <a class="nav-link btn-login" href="{{ route('login') }}">{{ __('Login') }}</a>
                              </li>
                          @endif

                          @if (Route::has('register'))
                              {{-- <li class="nav-item">
                                  <a class="nav-link btn-register" href="{{ route('register') }}">{{ __('Register') }}</a>
                              </li> --}}
                              <li class="nav-item dropdown">
                                <a class="nav-link btn-register dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">{{ __('Register') }}</a>
                                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdown">
                                  <li><a class="dropdown-item" href="{{ route('register') }}"><strong>As Student</strong></a></li>
                                </ul>
                            </li>
                          @endif
                      @else
                        <li class="nav-item login-username-home">
                          <a class="nav-link login-user" href="#" role="button">
                            <i class="fa fa-user"></i>
                            {{ Auth::user()->name }}
                        </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn-login" href="{{route('login')}}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn-register" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        
                      @endguest
                  </ul>
              </div>
          </nav>
        </div>
      </div> <!-- .row -->
    </div> <!-- .container -->
  </div> <!-- .topbar -->

  <nav class="navbar navbar-expand-lg shadow-sm main-navbar">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
        {{-- <span class="navbar-toggler-icon"></span> --}}
        <i class="fa fa-bars" aria-hidden="true"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupport">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="{{ url('/about-us') }}">About Us</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/courses') }}">Courses</a>
          </li>
          
          {{-- <li class="nav-item">
            <a class="nav-link" href="/blogs">Blogs</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="/public-exams">Exam Hall</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/ebooks">E-Books</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/video-courses">Video Courses</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Notice</a>
            {{-- <a class="nav-link" href="/notice">Notice</a> --}}
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/results">Exam Results</a></li>
              <li><a class="dropdown-item" href="/study-materials">Study Materials</a></li>
              <li><a class="dropdown-item" href="/syllabus">Syllabus</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/tutors">Tutors</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/manual-booking">Manual Booking</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="/eps-registration">EPS Registration</a>
          </li> --}}

        </ul>
      </div> <!-- .navbar-collapse -->
    </div> <!-- .container -->
  </nav>
</header>
