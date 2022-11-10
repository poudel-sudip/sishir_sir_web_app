@extends('admin.layouts.app')
@section('admin-title')
    Show Publisher
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Publisher</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="/admin/publishers">Publishers</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$publisher->name}} details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>User ID:</div>
                            <div>{{$publisher->user->id ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Publisher ID:</div>
                            <div>{{$publisher->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Full Name:</div>
                            <div>{{$publisher->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email:</div>
                            <div>{{$publisher->user->email ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact:</div>
                            <div>{{$publisher->user->contact ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Parthership On:</div>
                            <div>{{$publisher->partner_mode}} ({{$publisher->mode_value}})</div>
                        </div>
                        <div class="course-row">
                            <div>Description:</div>
                            <div>{!! $publisher->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Image:</div>
                            <div><img src="/storage/{{$publisher->user->photo ?? ''}}" height="50" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
