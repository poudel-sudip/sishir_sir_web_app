<div class="sidebar-dark">
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
        <a class="nav-link" href="{{ url('/admin/home') }}">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/users') }}">
          <i class="mdi mdi-account-multiple menu-icon"></i>
          <span class="menu-title">Users</span>
        </a>
      </li>

      {{-- <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-book-variant menu-icon"></i>
          <span class="menu-title">Courses</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/categories') }}">Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/courses') }}">Courses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/batches') }}">Batches</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#booking-basic" aria-expanded="false" aria-controls="booking-basic">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Course Bookings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="booking-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/bookings/verifylist') }}">Verify</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/bookings/all') }}">All Bookings</a>
            </li>
            
          </ul>
        </div>
      </li> --}}

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
          <span class="menu-title">PDF Bank</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="pdf_bank">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank/categories') }}">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank/pdf-groups') }}">PDF Bank Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/pdf-bank/pdf-singles') }}">PDF Bank Singles</a>
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

      {{-- <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ebooks" aria-expanded="false" aria-controls="ebooks">
          <i class="mdi mdi-book menu-icon"></i>
          <span class="menu-title">E-Books</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ebooks">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/ebook/categories') }}">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/ebook/books') }}">All Books</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/ebook-bookings') }}">Latest Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/ebook-bookings/all') }}">All Bookings</a>
            </li>
          </ul>
        </div>
      </li> --}}

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/menus') }}">
          <i class="mdi mdi-alpha-m-box menu-icon"></i>
          <span class="menu-title">Menus</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#books" aria-expanded="false" aria-controls="books">
          <i class="mdi mdi-alpha-b-box menu-icon"></i>
          <span class="menu-title">My Books</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="books">
          <ul class="nav flex-column sub-menu">
            {{-- <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/books/categories') }}">Categories</a>
            </li> --}}
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/books/publishers') }}">Publishers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/books') }}">All Books</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/library') }}">
          <i class="mdi mdi-alpha-l-box menu-icon"></i>
          <span class="menu-title">Material Library</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/blogs') }}">
            <i class="mdi mdi-file-delimited menu-icon"></i>
            <span class="menu-title">Blogs</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/highlights') }}">
            <i class="mdi mdi-alpha-h-box menu-icon"></i>
            <span class="menu-title">Home Highlights</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/qr-books') }}">
          <i class="mdi mdi-alpha-b-box menu-icon"></i>
          <span class="menu-title">Books For QR</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/testimonials') }}">
          <i class="mdi mdi-comment-processing menu-icon"></i>
          <span class="menu-title">Testimonials</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/wallet-collection') }}">
          <i class="mdi mdi-currency-usd menu-icon"></i>
          <span class="menu-title">Wallet Collection</span>
        </a>
      </li>
      
      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/notifications') }}">
          <i class="mdi mdi-bell menu-icon"></i>
          <span class="menu-title">Notifications</span>
        </a>
      </li> --}}

      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/sms') }}">
          <i class="mdi mdi-comment menu-icon"></i>
          <span class="menu-title">SMS</span>
        </a>
      </li> --}}


      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/sliders') }}">
          <i class="mdi mdi-image-filter menu-icon"></i>
          <span class="menu-title">Sliders</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/home-popup') }}">
          <i class="mdi mdi-select-all menu-icon"></i>
          <span class="menu-title">Home Popup</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#forms-section" aria-expanded="false" aria-controls="forms-section">
          <i class="mdi mdi-alpha-f-box menu-icon"></i>
          <span class="menu-title">Dynamic Forms</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="forms-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/dynamic-forms/groups') }}">Form Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/dynamic-forms') }}">Form List</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#upload-basic" aria-expanded="false" aria-controls="upload-basic">
          <i class="mdi mdi-cloud-upload menu-icon"></i>
          <span class="menu-title">Uploads</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="upload-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/free-videos') }}">Videos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/image-gallery') }}">Image Gallery</a>
            </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/audios') }}">Audios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/studyMaterials') }}">Study Materials</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/syllabus') }}">Syllabus</a>
            </li> --}}
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/provience') }}">
            <i class="mdi mdi-map-marker menu-icon"></i>
            <span class="menu-title">Provience</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#vaccancies-section" aria-expanded="false" aria-controls="vaccancies-section">
          <i class="mdi mdi-alpha-v-box menu-icon"></i>
          <span class="menu-title">Vaccancies</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="vaccancies-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/careers-category') }}">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/careers') }}">Vaccancies</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/leads/enquiries') }}">
            <i class="mdi mdi-comment-account menu-icon"></i>
            <span class="menu-title">Enquiries</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/advertisement') }}">
          <i class="mdi mdi-alpha-a-box menu-icon"></i>
          <span class="menu-title">Advertisement</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/imp-links') }}">
          <i class="mdi mdi-alpha-l-box menu-icon"></i>
          <span class="menu-title">Important Links</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/physical-book-orders') }}">
          <i class="mdi mdi-alpha-b-box menu-icon"></i>
          <span class="menu-title">Physical Book Orders</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#coupons-basic" aria-expanded="false" aria-controls="coupons-basic">
          <i class="mdi mdi-gift menu-icon"></i>
          <span class="menu-title">Booking Coupons</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="coupons-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/booking-coupons') }}">Available Coupons</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/booking-coupons/used') }}">Used Coupons</a>
            </li>
            
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#user-ticket-section" aria-expanded="false" aria-controls="user-ticket-section">
          <i class="mdi mdi-alpha-t-box menu-icon"></i>
          <span class="menu-title">User Tickets</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="user-ticket-section">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/user-tickets/open') }}">Open Tickets</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/user-tickets/closed') }}">Closed Tickets</a>
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
</div>
