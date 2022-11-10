@extends('student.layouts.app')

@section('student-title')
    Booking Details
@endsection
@section('student-title-icon')
    <i class="fas fa-eye"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
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
                    <div class="single-details">
                        <div class="booking-title">Allowed Booking Features:</div>
                        <div class="booking-data">{{$booking->features}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Course Name:</div>
                        <div class="booking-data">{{$booking->course->name}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Batch Name:</div>
                        <div class="booking-data">{{$booking->batch->name}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Course Fee:</div>

                        
                        <div class="booking-data">Rs. {{($booking->batch->fee)-($booking->batch->discount)}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Course Duration:</div>
                        <div class="booking-data">{{$booking->batch->duration}}  {{$booking->course->durationType}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Course Start Date:</div>
                        <div class="booking-data">{{$booking->batch->startDate}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Course End Date:</div>
                        <div class="booking-data">{{$booking->batch->endDate}}</div>
                    </div>
                    <div class="single-details">
                        <div class="booking-title">Batch Status:</div>
                        <div class="booking-data">{{$booking->batch->status}}</div>
                    </div>

                </div>
                {{-- <div class="card mt-4">
                    <div class="card-header">{{ __('Payment Details') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mode</th>
                                            <th>Account | Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$booking->verificationMode}}</td>
                                            <td>{{$booking->accountNo}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Payment Document</h6>
                                <a href="{{ asset('storage/'.$booking->verificationDocument) }}">
                                    <img src="{{ asset('storage/'.$booking->verificationDocument) }}" alt="Verification Document" class="w-100 img img-responsive">
                                </a>
                            </div>
                        </div>       
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
