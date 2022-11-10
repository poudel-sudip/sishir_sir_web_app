@extends('student.layouts.app')
@section('student-title')
    Tutor Special Courses
@endsection
@section('student-title-icon')
    <i class="fas fa-calendar-check"></i>
@endsection

@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row mb-2">
            {{-- <div class="col-md-6">
                {{ __('You are logged in as Student!') }}
            </div> --}}
            <div class="col-md-12 text-end">
                {{-- @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif --}}
                <a class="student-enroll-btn" href="{{ url('/student/tutor-special/courses/enroll') }}">Book Tutor Course</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Course</th>
                                <th>Start Date</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                <td>{{$booking->course->course ?? ''}}</td>
                                <td>{{date('Y-m-d',strtotime($booking->course->startDate)) ?? ''}}</td>
                                <td>{{$booking->course->duration ?? ''}}</td>
                                <td>{{$booking->status}}</td>
                                <td>
                                    <a href="/student/tutor-special/courses/{{$booking->id}}" class="btn-primary btn btn-sm mb-1">Details</a>
                                    @if($booking->status=="Unverified" && $booking->course->status!="Closed")
                                        <a href="/student/tutor-special/courses/{{$booking->id}}/edit" class="btn btn-warning btn-sm mb-1 ">Verify</a>
                                    @endif
                                    @if($booking->status=="Verified" && !$booking->suspended)
                                    <a href="/special-course/classroom/chat/{{$booking->course_id}}" class="btn btn-success btn-sm mb-1 ">Classroom</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody>
                            
                        </tbody>
                        
                    </table>
                </div>
                

                </div>

            </div>
        </div>
    @endsection
