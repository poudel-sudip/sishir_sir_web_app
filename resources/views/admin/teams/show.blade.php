@extends('admin.layouts.app')
@section('admin-title')
    Show Team
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Team</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="/admin/teams">Teams</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$team->name}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>User ID:</div>
                            <div>{{$team->user->id ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Team ID:</div>
                            <div>{{$team->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Full Name:</div>
                            <div>{{$team->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email:</div>
                            <div>{{$team->user->email ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact:</div>
                            <div>{{$team->user->contact ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Vendor:</div>
                            <div>{{$team->vendor->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status:</div>
                            <div>{{$team->user->status ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Image:</div>
                            <div><img src="/storage/{{$team->user->photo ?? ''}}" height="50" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
