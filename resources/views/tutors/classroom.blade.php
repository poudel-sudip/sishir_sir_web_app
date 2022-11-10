@extends('tutors.layouts.app')
@section('tutor-title')
    Tutor Batches & Classrooms
@endsection
@section('tutor-title-icon')
    <i class="fas fa-laptop"></i>
@endsection

@section('content')
    <div class="tutor-content-wrapper student-classroomlist-section">
        <div class="row mb-2">
            <div class="col-md-6">
               <h6> Classromms :</h6>  
            </div>
            <div class="col-md-6 text-end">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            @foreach($batches as $class)
            <div class="col-md-12">
                <div class="tutor-classrooms">
                    <div class="tutor-classroom-batch">
                        <h5>{{$class->course->name}} <span class="tutor-classroom-time">(Time: {{$class->timeSlot}})</span> </h5>
                        <h4>{{$class->name}}</h4>
                    </div>
                    <div class="t-classroom-btn">
                        <a href="/classroom/chat/{{$class->id}}" class="tutor-classroom-btn"><span class="icon-enter"></span> Classroom</a>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    @endsection
