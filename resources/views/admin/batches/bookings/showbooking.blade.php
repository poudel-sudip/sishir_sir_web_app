@extends('admin.layouts.app')
@section('admin-title')
    Show Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Booking</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a> </li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/batches/'.$batch->id.'/bookings') }}">Bookings</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Bookings Details</div>
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
                            <div>Batch Name:</div>
                            <div>{{$booking->batch->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Fee:</div>
                            <div>Rs. {{($booking->batch->fee ?? '')-($booking->batch->discount ?? '')}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Duration:</div>
                            <div>{{$booking->batch->duration ?? ''}}  {{$booking->batch->durationType ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Start Date:</div>
                            <div>{{$booking->batch->startDate ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course End Date:</div>
                            <div>{{$booking->batch->endDate ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Status:</div>
                            <div>{{$booking->batch->status ?? ''}}</div>
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
                            <div>{{$booking->verificationMode}}</div>
                        </div>
                        <div class="course-row">
                            <div>Booking Description:</div>
                            <div>{{$booking->description}}</div>
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
