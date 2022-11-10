@extends('publishers.layouts.app')
@section('admin-title')
    Publisher Dashboard
@endsection

@section('content')
<div class="content-wrapper pb-0">
    <div class="page-header flex-wrap">
      <h3 class="mb-0">
        Hi, welcome back! 
        <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">
            You are logged in as Publisher

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
              
              {{-- <div class="col-xl-4 col-md-4 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-dark">
                  <div class="card-body px-3 py-4">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="color-card">
                        <p class="mb-0 color-card-head">Total Students</p>
                        <h2 class="text-white mt-3 text-center">{{ $data->allusers->count ?? '' }}</h2>
                      </div>
                      <i class="card-icon-indicator mdi mdi-calendar-multiple bg-inverse-icon-dark"></i>
                    </div>
                    <div class="text-right">
                      <a class="view-from-dashboard-button" href="{{ $data->allusers->link ?? '' }}">View Details</a>
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
