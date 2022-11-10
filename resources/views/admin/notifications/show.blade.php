@extends('admin.layouts.app')
@section('admin-title')
    Show Notification
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Notification</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/notifications') }}">Notifications</a></li>
              <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Notification Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Notification ID:</div>
                            <div>{{$notification->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Notification Title:</div>
                            <div>{{$notification->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Notification Group:</div>
                            <div>{{$notification->groups}}</div>
                        </div>
                        <div class="course-row">
                            <div>Notification Date:</div>
                            <div>{{$notification->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Notification Message:</div>
                            <div>{!! $notification->message !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Notification Image:</div>
                            <div><img src="/storage/{{$notification->image}}" alt="" class="img img-fluid"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
