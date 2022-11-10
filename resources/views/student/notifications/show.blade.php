@extends('student.layouts.app')
@section('student-title')
    My Notifications
@endsection

@section('student-title-icon')
    <i class="fas fa-check-double"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">
        <div class="row">
            <div class="col-md-8 notification-detail-title"><h3>{{$notification->title}}</h3></div>
            <div class="col-md-4 text-end notification-detail-date"><span>Date: {{$notification->created_at}}</span></div>
            <div class="col-md-12 notification-detail-message">
               {!! $notification->message !!}
            </div>
            <div class="col-md-12">
                <img src="/storage/{{$notification->image}}" alt="" class="img img-fluid">
            </div>
            <div class="col-md-12 notification-detail-group">
                Notification Group: <span>{{$notification->groups}}</span>
            </div>
        </div>
    </div>
@endsection
