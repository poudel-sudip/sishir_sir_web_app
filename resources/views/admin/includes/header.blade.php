<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
  @csrf
</form>

<div class="sidebar-dark" style="background: #18151e;">
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
      <a class="sidebar-brand brand-logo" href="/admin/home"><img src="{{ asset('admin/images/logo.png') }}" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="/admin/home"><img src="{{ asset('admin/images/logo-mini.png') }}" alt="logo" /></a>
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
            <span class="font-weight-medium mb-2">Shisir Adhikari</span>
            <span class="font-weight-normal">{{ Auth::user()->name }}</span>
          </div>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#dashboard-menu" aria-expanded="false" aria-controls="dashboard-menu">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="dashboard-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/home') }}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/menus') }}">Menus</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/users') }}">Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/wallet-collection') }}">Wallet Collection</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/change-password') }}">Change Password</a>
            </li>
            <li class="nav-item">
              <a 
                class="nav-link" 
                href="{{ route('logout') }}" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
              >Sign-out</a>
            </li>
          </ul>
        </div>
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
              <a class="nav-link" href="{{ url('/admin/exam-category') }}">Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/exams') }}">All Exams</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/open-exams') }}">Open Exams</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/daily-mcq-questions') }}">Daily Questions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/play-puzzle/text') }}">Play Text Puzzle</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/play-puzzle/image') }}">Know The Picture</a>
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
              <a class="nav-link" href="{{ url('/admin/exam-hall/groups') }}">Exam Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/exam-hall') }}">Exam Sets</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/exam-hall/bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/exam-hall/bookings/all') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#pdf_bank" aria-expanded="false" aria-controls="pdf_bank">
          <i class="mdi mdi-file-pdf menu-icon"></i>
          <span class="menu-title">eBooks</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="pdf_bank">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank/categories') }}">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank/pdf-groups') }}">eBook Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank/pdf-singles') }}">eBook Singles</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank-bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank-bookings/all') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#online_course" aria-expanded="false" aria-controls="online_course">
          <i class="mdi mdi-book-open menu-icon"></i>
          <span class="menu-title">Online Courses</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="online_course">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/courses') }}">Courses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/course-bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/course-bookings/all') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#books-menu" aria-expanded="false" aria-controls="books-menu">
          <i class="mdi mdi-alpha-b-box menu-icon"></i>
          <span class="menu-title">Books</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="books-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/books/publishers') }}">Publishers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/books') }}">My Books</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/qr-books') }}">Books For QR</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/physical-book-orders') }}">Physical Book Orders</a>
            </li>
            
           
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/library') }}">
          <i class="mdi mdi-alpha-l-box menu-icon"></i>
          <span class="menu-title">eLibrary</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ticket-coupons-menu" aria-expanded="false" aria-controls="ticket-coupons-menu">
          <i class="mdi mdi-gift menu-icon"></i>
          <span class="menu-title">Coupons & Tickets</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ticket-coupons-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/booking-coupons') }}">Available Coupons</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/booking-coupons/used') }}">Used Coupons</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/user-tickets/open') }}">Open Tickets</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/user-tickets/closed') }}">Closed Tickets</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#news-hub-menu" aria-expanded="false" aria-controls="news-hub-menu">
          <i class="mdi mdi-post menu-icon"></i>
          <span class="menu-title">News Hub</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="news-hub-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/newsroom/categories') }}">Newsroom Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/newsroom') }}">Newsroom</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/careers-tag') }}">Vacancy Tags</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/careers') }}">Vacancies</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/health-days/categories') }}">Health Day Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/health-days') }}">Health Days</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#multimedia-menu" aria-expanded="false" aria-controls="multimedia-menu">
          <i class="mdi mdi-image-multiple menu-icon"></i>
          <span class="menu-title">Multimedia</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="multimedia-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/sliders') }}">Sliders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/advertisement') }}">Advertisement </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/free-videos') }}">Free Videos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/image-gallery') }}">Image Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/home-popup') }}">Home Popup</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#web-tools-menu" aria-expanded="false" aria-controls="web-tools-menu">
          <i class="mdi mdi-alpha-t-box menu-icon"></i>
          <span class="menu-title">Web Tools</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="web-tools-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/provience') }}">Province</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/highlights') }}">Home Highlights </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/imp-links') }}">Important Links</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/testimonials') }}">Testimonials </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/leads/enquiries') }}">Enquiries </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/faqs') }}">FAQ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/dynamic-forms') }}">Dynamic Forms </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/web-pages/about') }}">Web Page Setting</a>
            </li>
            
          </ul>
        </div>
      </li>

      

      </li>
    </ul>
  </nav>
</div>
