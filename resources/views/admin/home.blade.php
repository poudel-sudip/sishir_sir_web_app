{{-- @extends('layouts.adminapp') --}}
@extends('admin.layouts.app')
@section('admin-title')
    Admin Dashboard
@endsection

@section('content')
<div class="content-wrapper pb-0">
    <div class="page-header flex-wrap">
      <h3 class="mb-0">
        Hi, welcome back! 
        <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">
          {{ __('You are logged in as Admin') }}
          
          @if (session('status'))
          <div class="alert alert-success admin-session-alert" role="alert">
              {{ session('status') }}
          </div>
          @endif

        </span>
      </h3>
      <div class="d-flex">
        <a href="{{ ('/admin/notifications/create') }}"><button type="button" class="btn btn-sm ml-3 btn-primary">
           Create Notification </button>
        </a>
        <a href="{{ ('/admin/users/create') }}">
          <button type="button" class="btn btn-sm ml-3 btn-success">Add User</button>
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12 stretch-card grid-margin">
        <div class="card">
          <div class="card-body">
           
            <div class="row">
              <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-warning">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Total Users</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->user->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-account-multiple bg-inverse-icon-warning"></i>
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
                        <p class="mb-0 color-card-head">Total Bookings</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->booking->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-calendar-multiple bg-inverse-icon-danger"></i>
                    </div>
                    <div class="row">
                      <div class="col-8 booking-un-verified">
                        <p class="text-success">Verified<span class="booking-badge">{{ $data->booking->verified }}</p>
                          <p class="text-warning">Unverified<span class="booking-badge-un">{{ $data->booking->unverified }}</p>
                            <p class="text-warning">Processing<span class="booking-badge-un">{{ $data->booking->processing }}</p>
                            </div>
                      <div class="text-right col-4">
                        <a class="view-from-dashboard-button" href="{{ $data->booking->link }}">View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-success">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Enquiries</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->enquiry->count }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-comment-question-outline bg-inverse-icon-success"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->enquiry->link }}">View</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @if(count($batches))
            <div class="row">
              <div class="col-md-12 mt-4">
                <h3>Batches</h3>
              </div>
              @foreach($batches as $batch)
              <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                <div class="card mb-3 mb-sm-0">
                  <div class="card-body py-3 px-4">
                    <p class="m-0 survey-head text-center">{{ $batch->course->name ?? '' }}</p>
                    <p class="m-0 survey-head text-primary text-center">{{$batch->name}}</p>
                    <h2 class="text-center">{{ $batch->bookings->count() }}</h2>
                    <div class="justify-content-between align-items-end flot-bar-wrapper">
                      <div class="row">
                        <div class="col-8 booking-un-verified">
                          <p class="text-success">Verified<span class="booking-badge">{{ $batch->bookings()->where('status','=','Verified')->count() }}</p>
                          <p class="text-warning">Unverified<span class="booking-badge-un">{{ $batch->bookings()->where('status','!=','Verified')->count() }}</p>
                        </div>
                        <div class="text-right col-4" style="padding-left: 0;padding-right:0">
                          <a class="view-from-dashboard-button text-primary" href="{{ url('/admin/batches/'.$batch->id.'/Verified') }}">View</a>
                          <a class="view-from-dashboard-button text-primary" href="{{ url('/admin/batches/'.$batch->id.'/Unverified') }}" style="line-height: 2">View</a>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif

            @if(count($exams))
            <div class="row">
              <div class="col-md-12 mt-4">
                <h3>Exams</h3>
              </div>
              @foreach($exams as $exam)
              <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 mb-3">
                <div class="card mb-3 mb-sm-0">
                  <div class="card-body py-3 px-4">
                    <p class="m-0 survey-head text-primary text-center">{{$exam->title}}</p>
                    <h2 class="text-center">{{ $exam->bookings->count() }}</h2>
                    <div class="justify-content-between align-items-end flot-bar-wrapper">
                      <div class="row">
                        <div class="col-8 booking-un-verified">
                          <p class="text-success">Verified<span class="booking-badge">{{ $exam->bookings()->where('status','=','Verified')->count() }}</p>
                          <p class="text-warning">Unverified<span class="booking-badge-un">{{ $exam->bookings()->where('status','!=','Verified')->count() }}</p>
                        </div>
                        <div class="text-right col-4" style="padding-left: 0;padding-right:0">
                          <a class="view-from-dashboard-button text-primary" href="{{ url('/admin/exam-hall/'.$exam->id.'/bookings') }}">View</a>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif

          </div>
        </div>
      </div>
    </div>


  </div>
@endsection
