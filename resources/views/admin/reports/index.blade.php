@extends('admin.layouts.app')
@section('admin-title')
    Reports
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">All Reports</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reports</li>
            </ol>
        </nav>
    </div> 
    <div class="row">
        <div class="col-md-12 stretch-card grid-margin">
            <div class="card report-container">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="card mb-3 mb-sm-0">
                        <div class="card-body py-3 px-4">
                            <i class="mdi mdi-book-open-page-variant report-icon"></i>
                          <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                            <div>
                              <h3 class="m-0 survey-value">Course Report</h3>
                              <a href="/admin/reports/course" class="text-success m-0">View</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="card mb-3 mb-sm-0">
                        <div class="card-body py-3 px-4">
                            <i class="mdi mdi-bookmark-check report-icon"></i>
                          <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                            <div>
                              <h3 class="m-0 survey-value">Batch Report</h3>
                              <a href="/admin/reports/batch" class="text-success m-0">View</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="card">
                        <div class="card-body py-3 px-4">
                            <i class="mdi mdi-account-settings report-icon"></i>
                          <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                            <div>
                              <h3 class="m-0 survey-value">User Report</h3>
                              <a href="/admin/reports/user" class="text-success m-0">View</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                          <div class="card-body py-3 px-4">
                            <i class="mdi mdi-calendar-multiple-check report-icon"></i>
                            <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                              <div>
                                <h3 class="m-0 survey-value">Tutor Report</h3>
                                <a href="/admin/reports/tutor" class="text-success m-0">View</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3 mt-3">
                        <div class="card">
                          <div class="card-body py-3 px-4">
                            <i class="mdi mdi-book-open-page-variant report-icon"></i>
                            <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                              <div>
                                <h3 class="m-0 survey-value">Bookings Report</h3>
                                <a href="/admin/reports/booking" class="text-success m-0">View</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  
                </div>
              </div>


            {{-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class=""><a href="/admin/reports/course">Course Report</a></div>
                        <div class=""><a href="/admin/reports/batch">Batch Report</a></div>
                        <div class=""><a href="/admin/reports/user">User Report</a></div>
                        <div class=""><a href="/admin/reports/tutor">Tutor Report</a></div>
                        <div class=""><a href="/admin/reports/booking">Bookings Report</a></div>
                    <br>
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
