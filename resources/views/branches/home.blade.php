@extends('branches.layouts.app')
@section('admin-title')
    Branch Dashboard
@endsection

@section('content')
<div class="content-wrapper pb-0">
    <div class="page-header flex-wrap">
      <h3 class="mb-0">
        Hi, welcome back! 
        <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">
            You are logged in in Branch : {{$branch->name}}

          @if (session('status'))
          <div class="alert alert-success admin-session-alert" role="alert">
              {{ session('status') }}
          </div>
          @endif
        </span>
      </h3>
    </div>

    <div class="row">
      <div class="col-xl-12 stretch-card grid-margin">
        <div class="card">
          <div class="card-body">
           
            <div class="row">

              Dashboard....
              {{-- {{$branch}} --}}
              {{-- <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-primary">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">My Registered Users</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->user->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-account-multiple bg-inverse-icon-primary"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->user->link }}">View Details</a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-danger">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Total Course Bookings</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->course->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-calendar-multiple bg-inverse-icon-danger"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->course->link }}">View Details</a>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-info">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Total Exam Bookings</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->exam->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-calendar-multiple bg-inverse-icon-info"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->exam->link }}">View Details</a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-success">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Total Video Bookings</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->video->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-calendar-multiple bg-inverse-icon-success"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->video->link }}">View Details</a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-warning">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Total E-Book Bookings</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->ebook->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-calendar-multiple bg-inverse-icon-warning"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->ebook->link }}">View Details</a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-dark">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Total Students</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->allusers->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-calendar-multiple bg-inverse-icon-dark"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->allusers->link }}">View Details</a>
                    </div>
                  </div>
                </div>
              </div> --}}

            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
