@extends('student.layouts.app')
@section('student-title')
    Enrolled Courses
@endsection

@section('student-title-icon')
    <i class="fas fa-calendar-check"></i>
@endsection

@section('content')
<div class="news-feeds student-content-wrapper">
    <div class="student-enroll-section">
        <div class="row">
            <div class="col-md-12">
                <a class="student-enroll-btn" href="{{ url('/student/courses/enroll') }}">Create New Bookings</a>
            </div>
            <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                {{-- <th>Date</th> --}}
                                {{-- <th>Course</th> --}}
                                <th>Batch</th>
                                {{-- <th>Duration</th>
                                <th>Start Date</th>
                                <th>Time</th>
                                <th>Batch Status</th> --}}
                                <th>Verification</th>
                                {{-- <th>Due Amt.</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr style=" @if($booking->suspended) color:red !important @endif ">
                                <td>{{$booking->id}}</td>
                                {{-- <td>{{date('Y/m/d',strtotime($booking->created_at))}}</td> --}}
                                {{-- <td>{{$booking->course->name}}</td> --}}
                                <td>{{$booking->batch->name}}</td>
                                {{-- <td>{{$booking->batch->duration}} {{$booking->batch->durationType}}</td>
                                <td>{{date('Y/m/d',strtotime($booking->batch->startDate))}}</td>
                                <td>{{$booking->batch->timeSlot}}</td>
                                <td>{{$booking->batch->status}}</td> --}}
                                <td>
                                    {{$booking->status}}
                                </td>
                                {{-- <td>@if($booking->dueAmount>0) Rs. {{$booking->dueAmount}} @endif</td> --}}
                                <td>
                                    <a href="/student/courses/{{$booking->id}}" class="btn-primary btn btn-sm mb-1">Details</a>
                                    @if($booking->status=="Unverified" && $booking->batch->status!="Closed")
                                        <a href="/student/courses/{{$booking->id}}/edit" class="btn btn-success btn-sm mb-1 ">Verify</a>
                                    @endif
                                    {{-- @if($booking->status=="Verified" && $booking->batch->status!="Inactive" && $booking->suspended==false)
                                        <a href="/classroom/chat/{{$booking->batch->id}}" class="text-success">Classroom</a>
                                    @endif --}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="news-feeds-contact">
        @include('student.studentContact')
    </div>
</div>
@endsection
