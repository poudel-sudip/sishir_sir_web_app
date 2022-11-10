@extends('teams.layouts.app')
@section('admin-title')
    Folowed Followups
@endsection

@section('content')
  <div class="content-wrapper pb-0">
    <div class="page-header">
      <h3 class="page-title">Followed Followups</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/team/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Followed Followups</li>
        </ol>
      </nav>
    </div>  

    <div class="row">
      <div class="col-xl-12 stretch-card grid-margin">
        <div class="card">
          <div class="card-body">
           
            <div class="row justify-content-center">

              <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-info">
                  <div class="card-body px-3 py-4">
                    <div class="color-card text-center">
                      <p class="mb-0 color-card-head">Registered Users</p>
                      <h2 class="text-white mt-3 ">{{$data->reguser->count}}</h2>
                      <a class="btn btn-warning rounded" href="/team/followup/followed/registered-users">View</a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-success">
                  <div class="card-body px-3 py-4">
                    <div class="color-card text-center">
                      <p class="mb-0 color-card-head">Admin Dynamic Forms</p>
                      <h2 class="text-white mt-3 ">{{$data->adminforms->count}}</h2>
                      <a class="btn btn-warning rounded" href="/team/followup/followed/admin-forms">View</a>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-sm-3 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-info">
                  <div class="card-body px-3 py-4">
                    <div class="color-card text-center">
                      <p class="mb-0 color-card-head">Vendor Dynamic Forms</p>
                      <h2 class="text-white mt-3 ">{{$data->vendorforms->count}}</h2>
                      <a class="btn btn-warning rounded" href="/team/followup/followed/vendor-forms">View</a>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

@endsection
