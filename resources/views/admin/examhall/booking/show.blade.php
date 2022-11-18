@extends('admin.layouts.app')
@section('admin-title')
    Show Exam Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Exam Booking</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exam-hall') }}">Exam Sets</a> </li>
                <li class="breadcrumb-item"><a href="/admin/exam-hall/{{$booking->category_id}}/bookings">Bookings</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Exam Bookings Details</div>
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
                            <div>Exam Category Name:</div>
                            <div>{{$booking->category->title ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Fee:</div>
                            <div>Rs. {{($booking->category->price ?? '0') - ($booking->category->discount ?? '0')}}</div>
                        </div>
                        
                        <hr>
                        <div class="course-row">
                            <div>Payment Amount:</div>
                            <div>Rs. {{$booking->paymentAmount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Discount:</div>
                            <div>Rs. {{$booking->discount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Mode:</div>
                            <div>{{$booking->verificationMode}}</div>
                        </div>
                        
                        <div class="course-row">
                            <div>Description:</div>
                            <div>{{$booking->description}}</div>
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
