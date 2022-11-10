<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
      <a class="sidebar-brand brand-logo" href="/team/home"><img src="{{ asset('admin/images/logo.png') }}" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="/team/home"><img src="{{ asset('admin/images/logo-mini.png') }}" alt="logo" /></a>
    </div>
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="{{ url('/profile') }}" class="nav-link">
          <div class="nav-profile-image">
            @if(auth()->user()->photo)
            <img src="/storage/{{auth()->user()->photo}}" alt="" />
            @else
            <img src="{{asset('admin/images/face.jpg') }}" alt="" />
            @endif
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column pr-3">
            {{-- <span class="font-weight-medium mb-2">E-Tutor Class</span> --}}
            <span class="font-weight-normal">{{ auth()->user()->name }}</span>
            <span class="font-weight-normal">( {{ auth()->user()->team ? (auth()->user()->team->vendor ? (auth()->user()->team->vendor->name) : '') : '' }} )</span>
          </div>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/team/home') }}">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
            
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#users-section" aria-expanded="false" aria-controls="users-section">
          <i class="mdi mdi-account-multiple menu-icon"></i>
          <span class="menu-title">Users</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="users-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/users') }}">Add Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/all-users') }}">All Users</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#course-booking-section" aria-expanded="false" aria-controls="course-booking-section">
          <i class="mdi mdi-book-open-variant menu-icon"></i>
          <span class="menu-title">Course Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="course-booking-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/course-bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/all-course-bookings') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#exam-booking-section" aria-expanded="false" aria-controls="exam-booking-section">
          <i class="mdi mdi-message-text-clock menu-icon"></i>
          <span class="menu-title">Exam Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="exam-booking-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/exam-bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/all-exam-bookings') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#video-booking-section" aria-expanded="false" aria-controls="video-booking-section">
          <i class="mdi mdi-clipboard-play menu-icon"></i>
          <span class="menu-title">Video Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="video-booking-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/video-bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/all-video-bookings') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ebook-booking-section" aria-expanded="false" aria-controls="ebook-booking-section">
          <i class="mdi mdi-book menu-icon"></i>
          <span class="menu-title">E-Books Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ebook-booking-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/ebook-bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/all-ebook-bookings') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/team/manual-bookings') }}">
          <i class="mdi mdi-account-cash menu-icon"></i>
          <span class="menu-title">Manual Bookings</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#followup-section" aria-expanded="false" aria-controls="followup-section">
          <i class="mdi mdi-cast-education menu-icon"></i>
          <span class="menu-title">Followup</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="followup-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/followup/pending') }}">Pending</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/team/followup/followed') }}">Followed</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item sidebar-actions">
        <a class="nav-link" href="{{ url('/change-password') }}">
          <i class="mdi mdi-key-variant menu-icon"></i>
          <span class="menu-title">Change Password</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
          onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="mdi mdi-logout mr-2 text-primary"></i>
          <span class="menu-title">Sign Out</span>
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>

      </li>
    </ul>
  </nav>
