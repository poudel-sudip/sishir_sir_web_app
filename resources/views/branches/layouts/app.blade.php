<!DOCTYPE html>
<html lang="en">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('admin-title') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/flag-icon-css/css/flag-icon.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.dataTables.min.css') }}" />
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}" />
    {{-- summernote --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" />

     <!-- Global site tag (gtag.js) - Google Analytics -->
     <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZS3KVP4N6H"></script>
     <script>
       window.dataLayer = window.dataLayer || [];
       function gtag(){dataLayer.push(arguments);}
       gtag('js', new Date());
     
       gtag('config', 'G-ZS3KVP4N6H');
     </script>
     
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>

  </head>
  <body>
    <div class="container-scroller">
        @include('branches.includes.header')
      <div class="container-fluid page-body-wrapper">
        <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
            <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="{{ url('/branches/home') }}"><img src="{{ asset('admin/images/logo-mini.png') }}" alt="logo" width="80" /></a>
            <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
              <i class="mdi mdi-menu"></i>
            </button>

            <ul class="navbar-nav navbar-nav-right ml-lg-auto">
              <li class="nav-item">
                <a class="nav-link" target="_blank" href="{{ ('/') }}">Home</a>
              </li>
              <li class="nav-item nav-profile dropdown border-0">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
                  @if(Auth::user()->photo)
                  <img class="nav-profile-img mr-2" alt="" src="/storage/{{Auth::user()->photo}}" />
                  @else
                  <img class="nav-profile-img mr-2" alt="" src="{{ asset('admin/images/face.jpg') }}" />
                  @endif
                  <span class="profile-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item" href="{{ url('/profile') }}">
                    <i class="mdi mdi-cached mr-2 text-success"></i> Profile</a>
                    <a class="dropdown-item" href="{{ url('/change-password') }}">
                      <i class="mdi mdi-key-variant mr-2 text-success"></i> Change Password</a>
                  <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout mr-2 text-primary"></i> Signout
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">
          @yield('content')
          @include('admin.includes.footer')
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('admin/vendors/flot/jquery.flot.pie.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- <script src="{{ asset('admin/js/dashboard.js') }}"></script> -->
    <!-- End custom js for this page -->
    {{-- data table --}}
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/customDatatable.js') }}"></script>

    <script src="{{ asset('admin/js/sweetalert2@11.js') }}"></script>

    {{-- summernote --}}

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->

  </body>
</html>
