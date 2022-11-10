@extends('student.layouts.app')
@section('student-title')
   My Notifications
@endsection
@section('student-title-icon')
    <i class="fas fa-bell"></i>
@endsection
@section('content')
    <div class="student-content-wrapper">
        <div class="row">
            @foreach($notifications as $notification)
            <div class="col-md-12">
                <div class="student-notification">
                    <div class="notification-icon">
                        <span class="icon-bell"></span>
                    </div>
                    <div>
                        <h3>
                            <a class="@if($notification->pivot->read=='No') text-primary @endif" href="/student/notifications/{{$notification->id}}">
                                {{$notification->title}}
                            </a>
                        </h3>
                        <span>{{date('Y-m-d',strtotime($notification->created_at))}}</span>
                        <div class="notification-message">
                            {!! $notification->message !!}
                            {{-- {!! \Illuminate\Support\Str::words($notification->message, 15,'...') !!} --}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
