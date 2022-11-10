@extends('teams.layouts.app')
@section('admin-title')
    Show Video Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Video Booking</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/team/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/team/video-bookings') }}">Video Bookings</a> </li>
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
                            <div>Video Course Name:</div>
                            <div>{{$booking->course->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Video Course Fee:</div>
                            <div>Rs. {{($booking->course->fee ?? '0') - ($booking->course->discount ?? '0')}}</div>
                        </div>
                        
                        <hr>
                        <div class="course-row">
                            <div>Payment Amount:</div>
                            <div>Rs. {{$booking->paymentAmount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Vendor Charge + Discount:</div>
                            <div>Rs. {{$booking->discount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Mode:</div>
                            <div>{{$booking->verificationMode}}</div>
                        </div>
                        
                        <div class="course-row">
                            <div>Remarks:</div>
                            <div>{{$booking->remarks}}</div>
                        </div>
                        
                        <div class="course-row">
                            <div>Created Date:</div>
                            <div>{{$booking->created_at}}</div>
                        </div>

                        <div class="course-row">
                            <div>Updated Date:</div>
                            <div>{{$booking->updated_at}}</div>
                        </div>
                        @if($booking->verificationDocument)
                        <div class="course-row">
                            <div>Payment Document:</div>
                            <div><img src="/storage/{{$booking->verificationDocument}}" class="img img-fluid" alt=""></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
