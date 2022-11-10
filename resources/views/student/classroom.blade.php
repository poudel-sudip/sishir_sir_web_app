@extends('student.layouts.app')
@section('student-title')
    Active Classrooms
@endsection

@section('student-title-icon')
    <i class="fas fa-laptop"></i>
@endsection

@section('content')
<style>
    .home-booking-details{
        display: none;
    }
</style>
    <div class="news-feeds student-content-wrapper">
        <div class="main-student-classroom">
            <div class="row mb-2">
                <div class="col-md-6">
                   <h4> Classrooms :</h4>  
                </div>
                {{-- <div class="col-6 text-end">
                    <a href="/student/exams" class="btn btn-primary btn-sm"> My Exams</a>
                </div> --}}
                <div class="col-md-6 text-end">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('success_message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success_message') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                @foreach($bookings as $booking)
                <div class="col-md-12">
                    <div class="student-classrooms">
                        <div class="student-classroom-batch">
                            <h5>{{$booking->course->name}} <strong class="tutor-classroom-time text-success">(Time: {{$booking->batch->timeSlot}})</strong> </h5>
                            <h4>{{$booking->batch->name}}</h4>
                        </div>
                        <div class="s-classroom-btn">
                            <a href="/classroom/chat/{{$booking->batch->id}}" class="btn btn-primary">Chat</a>
                            <a href="/classroom/files/{{$booking->batch->id}}" class="btn btn-warning">PDF Files</a>
                            <a href="/classroom/videos/{{$booking->batch->id}}" class="btn btn-danger">Videos</a>
                            <a href="/classroom/assignments/{{$booking->batch->id}}" class="btn btn-info">Assignments</a>
                            <a href="/student/classroom/exams/{{$booking->batch->id}}" class="btn btn-primary">Exams</a>
                            @if($booking->batch->status=='Running' && $booking->features=='All')
                                <a href="/classroom/schedules/{{$booking->batch->id}}" class="btn btn-secondary m-1">Schedules</a>
                                @if($booking->batch->classroomLink!='')
                                <a href="{{$booking->batch->classroomLink}}" target="_blank" class="btn btn-success">Join</a>
                                @endif
                                @if($booking->batch->live_link!='')
                                <a href="{{$booking->batch->live_link}}" target="_blank" class="btn btn-danger">Live</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
        <div class="news-feeds-contact">
            @include('student.studentContact')
        </div>
    </div>
@endsection
