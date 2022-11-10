<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
      <a class="sidebar-brand brand-logo" href="/branch/home"><img src="{{ asset('admin/images/logo.png') }}" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="/branch/home"><img src="{{ asset('admin/images/logo-mini.png') }}" alt="logo" /></a>
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
            <span class="font-weight-normal"> ({{$branch->name ?? ''}}) </span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/branch/home') }}">
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
            @if(auth()->user()->branchProfile)
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/members') }}">Members</a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/students') }}">Students</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/all-students') }}">All Students</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#section-courses" aria-expanded="false" aria-controls="section-courses">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Courses</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="section-courses">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/courses') }}">Courses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/course-bookings/') }}">Bookings</a>
            </li>
          </ul>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#section-examhall" aria-expanded="false" aria-controls="section-examhall">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Exam Hall</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="section-examhall">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/exam-hall') }}">Exam Hall</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/exam-hall-bookings') }}">Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#section-videocourse" aria-expanded="false" aria-controls="section-videocourse">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Video Course</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="section-videocourse">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/video-courses') }}">Video Courses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/video-course-bookings') }}">Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#section-ebooks" aria-expanded="false" aria-controls="section-ebooks">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">E-Books</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="section-ebooks">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/ebooks') }}">E-Books</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/ebook-bookings') }}">Bookings</a>
            </li>
          </ul>
        </div>
      </li>
      
      <li class="nav-item sidebar-actions">
        <a class="nav-link" href="{{ url('/branch/account') }}">
          <i class="mdi mdi-book-open menu-icon"></i>
          <span class="menu-title">Account</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/branch/manual-booking') }}">
          <i class="mdi mdi-code-equal menu-icon"></i>
          <span class="menu-title">Manual Bookings</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/branch/mcq-exams') }}">
          <i class="mdi mdi-console menu-icon"></i>
          <span class="menu-title">MCQ Exams</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/branch/open-mcq-exams') }}">
          <i class="mdi mdi-console menu-icon"></i>
          <span class="menu-title">Open MCQ Exams</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/branch/notifications') }}">
          <i class="mdi mdi-bell menu-icon"></i>
          <span class="menu-title">Notifications</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/branch/reports') }}">
          <i class="mdi mdi-google-analytics menu-icon"></i>
          <span class="menu-title">Reports</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/branch/sms') }}">
          <i class="mdi mdi-comment-processing menu-icon"></i>
          <span class="menu-title">SMS</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#section-uploads" aria-expanded="false" aria-controls="section-ebooks">
          <i class="mdi mdi-cloud-upload menu-icon"></i>
          <span class="menu-title">Uploads</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="section-uploads">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/videos') }}">Videos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/audios') }}">Audios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/syllabus') }}">Syllabus</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/branch/study-materials') }}">Study Materials</a>
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
