@extends('student.layouts.app')

@section('student-title')
   Special Course Booking Details
@endsection
@section('student-title-icon')
    <i class="fas fa-eye"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center student_verify_card">
            <div class="col-md-12">
                <div class="show-booking-courses">
                    @if($booking->suspended)
                    <div class="">
                        <h6 class="alert alert-danger">This Booking Suspended</h6>
                    </div>
                    @endif
                    <div class="single-details">
                        <div class="booking-title">Booking ID:</div>
                        <div class="booking-data">{{$booking->id}}</div>
                    </div>
                   
                    <div class="single-details">
                        <div class="booking-title">Booked By:</div>
                        <div class="booking-data">{{$booking->user_name}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Contact No:</div>
                        <div class="booking-data">{{$booking->user->contact}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Booking Status:</div>
                        <div class="booking-data">{{$booking->status}}</div>
                    </div>
                    {{-- <div class="single-details">
                        <div class="booking-title">Booking Description:</div>
                        <div class="booking-data">{{$booking->description}}</div>
                    </div> --}}
                    <div class="single-details">
                        <div class="booking-title">Course Name:</div>
                        <div class="booking-data">{{$booking->course->course}}</div>
                    </div>
                   
                    <div class="single-details">
                        <div class="booking-title">Course Fee:</div>
                        <div class="booking-data">Rs. {{($booking->course->fee)-($booking->course->discount)}}</div>
                    </div>
                   
                    <div class="single-details">
                        <div class="booking-title">Course Start Date:</div>
                        <div class="booking-data">{{$booking->course->startDate}}</div>
                    </div>
                    
                    <div class="single-details">
                        <div class="booking-title">Course Duration:</div>
                        <div class="booking-data">{{$booking->course->duration}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Course Status:</div>
                        <div class="booking-data">{{$booking->course->status}}</div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">{{ __('Payment Details') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Amount</th>
                                            <th>Mode</th>
                                            <th>Account | Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$booking->paymentAmount}}</td>
                                            <td>{{$booking->verificationMode}}</td>
                                            <td>{{$booking->accountNo}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Payment Document</h6>
                                @if($booking->verificationDocument)
                                <a href="{{ asset('storage/'.$booking->verificationDocument) }}">
                                    <img src="{{ asset('storage/'.$booking->verificationDocument) }}" alt="Verification Document" class="w-100 img img-responsive">
                                </a>
                                @endif
                            </div>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
