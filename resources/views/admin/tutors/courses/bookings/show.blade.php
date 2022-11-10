@extends('admin.layouts.app')
@section('admin-title')
    Show Special Course Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Tutor Special Course Booking</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses">Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/bookings">Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Bookings Details : {{$course->course}}</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Booking ID:</div>
                            <div>{{$booking->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Booked By:</div>
                            <div>{{$booking->user_name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact No:</div>
                            <div>{{$booking->user->contact}}</div>
                        </div>
                        <div class="course-row">
                            <div>Booking Status:</div>
                            <div>{{$booking->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Booking Description:</div>
                            <div>{{$booking->description}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Name:</div>
                            <div>{{$booking->course->course}}</div>
                        </div>
                        
                        <div class="course-row">
                            <div>Course Fee:</div>
                            <div>Rs. {{($booking->course->fee)-($booking->course->discount)}}</div>
                        </div>
                        
                        <div class="course-row">
                            <div>Course Start Date:</div>
                            <div>{{$booking->course->startDate}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Duration:</div>
                            <div>{{$booking->course->duration}} </div>
                        </div>
                        <div class="course-row">
                            <div>Course Status:</div>
                            <div>{{$booking->course->status}}</div>
                        </div>
                        <hr>
                        <div class="course-row">
                            <div>Payment Amount:</div>
                            <div>{{$booking->paymentAmount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Mode:</div>
                            <div>{{$booking->verificationMode}}</div>
                        </div>
                        <div class="course-row">
                            <div>Account:</div>
                            <div>{{$booking->accountNo}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Document:</div>
                            <div><img src="/storage/{{$booking->verificationDocument}}" class="w-100 img img-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
