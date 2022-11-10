@extends('admin.layouts.app')
@section('admin-title')
    Show Video Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Video Booking</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/video-booking') }}">Video Bookings</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Video Bookings Details</div>
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
                            <div>{{$booking->user->contact ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Booking Status:</div>
                            <div>{{$booking->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Name:</div>
                            <div>{{$booking->course->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Category Name:</div>
                            <div>{{$booking->course->category->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Fee:</div>
                            <div>Rs. {{($booking->course->fee)-($booking->course->discount)}}</div>
                        </div>
                       
                        <hr>
                        <div class="course-row">
                            <div>Payment Amount:</div>
                            <div>{{$booking->paymentAmount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Discount:</div>
                            <div>{{$booking->discount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Mode:</div>
                            <div>{{$booking->accountNo}}  {{$booking->verificationMode}}</div>
                        </div>
                        <div class="course-row">
                            <div>Remarks:</div>
                            <div>{{$booking->remarks}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Document:</div>
                            <div><img src="/storage/{{$booking->verificationDocument}}" alt="" class="w-100 img img-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
