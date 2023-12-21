<div class="sidebar-dark">
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
      <a class="sidebar-brand brand-logo" href="/moderator/home"><img src="{{ asset('admin/images/logo.png') }}" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="/moderator/home"><img src="{{ asset('admin/images/logo-mini.png') }}" alt="logo" /></a>
    </div>
    <ul class="nav">

      <li class="nav-item nav-profile">
        <a href="{{ url('/profile') }}" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{ asset('admin/images/face.jpg') }}" alt="profile" />
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column pr-3">
            <span class="font-weight-medium mb-2">Moderator Panel</span>
            <span class="font-weight-normal">{{ Auth::user()->name }}</span>
          </div>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/moderator/home') }}">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
           

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#exams-basic" aria-expanded="false" aria-controls="exams-basic">
          <i class="mdi mdi-playlist-check menu-icon"></i>
          <span class="menu-title">MCQ Exams</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="exams-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/moderator/exam-category') }}">Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/moderator/exams') }}">All Exams</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/moderator/open-exams') }}">Open Exams</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#examhall-basic" aria-expanded="false" aria-controls="examhall-basic">
          <i class="mdi mdi-message-text-clock menu-icon"></i>
          <span class="menu-title">Exam Hall</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="examhall-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/moderator/exam-hall') }}">Exam Sets</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('moderator/exam-hall/bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/moderator/exam-hall/bookings/all') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>
    

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/moderator/blogs') }}">
            <i class="mdi mdi-file-delimited menu-icon"></i>
            <span class="menu-title">Blogs</span>
        </a>
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
</div>
