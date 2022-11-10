<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
      <a class="sidebar-brand brand-logo" href="/publisher/home"><img src="{{ asset('admin/images/logo.png') }}" alt="logo" /></a>
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
          </div>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/publisher/home') }}">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
            
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#section-ebooks" aria-expanded="false" aria-controls="section-ebooks">
          <i class="mdi mdi-book-open-variant menu-icon"></i>
          <span class="menu-title">Ebooks</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="section-ebooks">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/publisher/ebooks/categories') }}">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/publisher/ebooks/all') }}">All Ebooks</a>
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
