<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
      <a class="sidebar-brand brand-logo" href="/vendor/home"><img src="{{ asset('admin/images/logo.png') }}" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="/vendor/home"><img src="{{ asset('admin/images/logo-mini.png') }}" alt="logo" /></a>
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
            <span class="font-weight-normal"> {{ '(Vendor)' }} </span>
          </div>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/vendor/home') }}">
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
              <a class="nav-link" href="{{ url('/vendor/users') }}">Add Users</a>
            </li>
            @if(ucwords(auth()->user()->vendor->user_access) == 'Yes')
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/provience-users') }}">Provience Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/all-users') }}">All Users</a>
            </li>
            @endif
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#booking-course" aria-expanded="false" aria-controls="booking-course">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Course Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="booking-course">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/bookings') }}">Latest Course Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/bookings/all') }}">All Course Bookings</a>
            </li>
            @if(ucwords(auth()->user()->vendor->manual_booking_access	) == 'Yes')
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/manual-bookings') }}">Manual Bookings</a>
            </li>
            @endif
          </ul>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#booking-exam" aria-expanded="false" aria-controls="booking-exam">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Exam Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="booking-exam">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/exam-hall/bookings') }}">Latest Exam Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/exam-hall/bookings/all') }}">All Exam Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#booking-video" aria-expanded="false" aria-controls="booking-video">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Video Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="booking-video">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/video-booking') }}">Latest Video Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/video-booking/all') }}">All Video Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#booking-ebook" aria-expanded="false" aria-controls="booking-ebook">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">E-Book Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="booking-ebook">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/ebook-booking') }}">Latest E-Book Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/ebook-booking/all') }}">All E-Book Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      @if(ucwords(auth()->user()->vendor->enquiry_access	) == 'Yes')
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#enquiries-section" aria-expanded="false" aria-controls="enquiries-section">
          <i class="mdi mdi-comment menu-icon"></i>
          <span class="menu-title">Leads/Enquiries</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="enquiries-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/enquiries') }}">All Enquiries</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/enquiries/filter') }}">Filter Enquiries</a>
            </li>
          </ul>
        </div>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#forms-section" aria-expanded="false" aria-controls="forms-section">
          <i class="mdi mdi-alpha-f-box menu-icon"></i>
          <span class="menu-title">Dynamic Forms</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="forms-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/dynamic-forms') }}">Admin Forms</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/vendor-dynamic-forms/groups') }}">Form Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/vendor/vendor-dynamic-forms') }}">Vendor Forms</a>
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
