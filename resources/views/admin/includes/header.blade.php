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
            <span class="font-weight-medium mb-2">E-Tutor Class</span>
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

      <li class="nav-item">
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
        <a class="nav-link" data-toggle="collapse" href="#video-course" aria-expanded="false" aria-controls="video-course">
          <i class="mdi mdi-book-variant menu-icon"></i>
          <span class="menu-title">Video Course</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="video-course">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/video-category') }}">Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/video-course') }}">Courses</a>
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
            @if(auth()->user()->permission>=40)
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/bookings/verifylist') }}">Verify</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/bookings/duelist') }}">Due Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/bookings/suspendedlist') }}">Suspended Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/bookings/all') }}">All Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/vendor-course-bookings') }}">Vendor Bookings</a>
            </li>
            @endif
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#videoBooking" aria-expanded="false" aria-controls="videoBooking">
          <i class="mdi mdi-clipboard-play menu-icon"></i>
          <span class="menu-title">Video Booking</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="videoBooking">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/video-booking') }}">Latest Video Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/video-booking/all') }}">All Video Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/vendor-video-bookings') }}">Vendor Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
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
              <a class="nav-link" href="{{ url('/admin/ebook-booking') }}">Bookings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/vendor-ebook-bookings') }}">Vendor Bookings</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/exam-hall') }}">
          <i class="mdi mdi-message-text-clock menu-icon"></i>
          <span class="menu-title">Exam Hall</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/booking-through-merchant') }}">
          <i class="mdi mdi-alpha-m-box menu-icon"></i>
          <span class="menu-title">Merchant Bookings</span>
        </a>
      </li>

      @if(auth()->user()->permission>=40)
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#account-basic" aria-expanded="false" aria-controls="account-basic">
          <i class="mdi mdi-book-variant menu-icon"></i>
          <span class="menu-title">Accounts</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="account-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/accounts/incomes') }}">Incomes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/accounts/expenses') }}">Expenses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/accounts/reports') }}">Reports</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/accounts/collections') }}">Collections</a>
            </li>
          </ul>
        </div>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/eps-registration') }}">
          <i class="mdi mdi-account-multiple-plus menu-icon"></i>
          <span class="menu-title">EPS Registration</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/followup') }}">
          <i class="mdi mdi-book-open-variant menu-icon"></i>
          <span class="menu-title">Follow Up</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/home-popup') }}">
          <i class="mdi mdi-select-all menu-icon"></i>
          <span class="menu-title">Home Popup</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/manual-booking') }}">
          <i class="mdi mdi-calendar-multiple-check menu-icon"></i>
          <span class="menu-title">Manual Booking</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/zoom/meetings') }}">
          <i class="mdi mdi-voice menu-icon"></i>
          <span class="menu-title">Zoom Meetings</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/sliders') }}">
          <i class="mdi mdi-image-filter menu-icon"></i>
          <span class="menu-title">Sliders</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/testimonials') }}">
          <i class="mdi mdi-comment-processing menu-icon"></i>
          <span class="menu-title">Testimonials</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/tutors') }}">
          <i class="mdi mdi-account-multiple-outline menu-icon"></i>
          <span class="menu-title">Tutors</span>
        </a>
      </li>
      
      @if(auth()->user()->permission>20)
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/vendor') }}">
          <i class="mdi mdi-account-multiple-outline menu-icon"></i>
          <span class="menu-title">Vendors</span>
        </a>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/notifications') }}">
          <i class="mdi mdi-bell menu-icon"></i>
          <span class="menu-title">Notifications</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/sms') }}">
          <i class="mdi mdi-comment menu-icon"></i>
          <span class="menu-title">SMS</span>
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
              <a class="nav-link" href="{{ url('/admin/exam-category') }}">Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/exams') }}">All Exams</a>
            </li>
          </ul>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/open-exams') }}">
            <i class="mdi mdi-playlist-check menu-icon"></i>
            <span class="menu-title">Open MCQ Exams</span>
        </a>
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
              <a class="nav-link" href="{{ url('/admin/videos') }}">Videos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/audios') }}">Audios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/studyMaterials') }}">Study Materials</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/syllabus') }}">Syllabus</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/free-videos') }}">
              <i class="mdi mdi-video menu-icon"></i>
              <span class="menu-title">Free Videos</span>
          </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/reports') }}">
          <i class="mdi mdi-receipt menu-icon"></i>
          <span class="menu-title">Reports</span>
        </a>
      </li>

      <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/blogs') }}">
              <i class="mdi mdi-file-delimited menu-icon"></i>
              <span class="menu-title">Blogs</span>
          </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#enquiries-basic" aria-expanded="false" aria-controls="enquiries-basic">
          <i class="mdi mdi-comment-account menu-icon"></i>
          <span class="menu-title">Enquiries</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="enquiries-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/leads/enquiries') }}">Enquiry Lists</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/leads/enquiries/filter') }}">Enquiry Filter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/enquiry-form') }}">Enquiry Form</a>
            </li>
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
        <a class="nav-link" href="{{ url('/admin/publishers') }}">
            <i class="mdi mdi-city menu-icon"></i>
            <span class="menu-title">Publishers</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/careers') }}">
            <i class="mdi mdi-alpha-c-box menu-icon"></i>
            <span class="menu-title">Careers</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/orientations') }}">
            <i class="mdi mdi-alpha-o-box menu-icon"></i>
            <span class="menu-title">Orientations</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#dynamic-forms-basic" aria-expanded="false" aria-controls="dynamic-forms-basic">
          <i class="mdi mdi-alpha-f-box menu-icon"></i>
          <span class="menu-title">Dynamic Forms</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="dynamic-forms-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/dynamic-forms/groups') }}">Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/admin/dynamic-forms/categories') }}">All Forms</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/teams') }}">
            <i class="mdi mdi-alpha-t-box menu-icon"></i>
            <span class="menu-title">Teams</span>
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
