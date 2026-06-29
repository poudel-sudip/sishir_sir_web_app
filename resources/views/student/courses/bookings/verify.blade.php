@extends('student.layouts.app')

@section('student-title')
    Verify Course Batch Booking
@endsection
@section('student-title-icon')
    <i class="far fa-calendar-check"></i>
@endsection


@section('content')

    <style>
        .payment-images span img {
            cursor: pointer;
            border-radius: 5px;
            max-height: 60px;
        }

        .payment-images span img.active{
            border-color: #027a20 !important;
            border-width: 2px !important;
        }

    </style>

    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card student_verify_card">
                    <div class="card-header">Course Batch Booking Update</div>

                    <div class="card-body enroll_form">
                        <form id="verifyCourseForm" method="POST" action="#" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            @if(session('error_message'))
                            <div class="form-group row">
                                <div class="col-12 alert alert-danger">{{ session('error_message') }}</div>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label for="bookingid" class="col-md-4 col-form-label text-md-right">{{ __('Booking ID') }}</label>

                                <div class="col-md-8">
                                    <input id="bookingid" type="text" class="form-control @error('bookingid') is-invalid @enderror" name="bookingid" value="{{ old('bookingid') ?? $booking->id }}" readonly>

                                    @error('bookingid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="course_id" class="col-md-4 col-form-label text-md-right">{{ __('Course') }}</label>

                                <div class="col-md-8">
                                    <input id="course_id" type="text" class="form-control @error('course_id') is-invalid @enderror" name="course_id" value="{{ old('course_id') ?? optional(optional($booking->batch)->course)->name }}" readonly>

                                    @error('course_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="batch_id" class="col-md-4 col-form-label text-md-right">{{ __('Batch') }}</label>

                                <div class="col-md-8">
                                    <input id="batch_id" type="text" class="form-control @error('batch_id') is-invalid @enderror" name="batch_id" value="{{ old('batch_id') ?? ($booking->batch->name.' @ Rs.'. ($booking->batch->fee - $booking->batch->discount)) }}" readonly>

                                    @error('batch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verificationMode" class="col-md-4 col-form-label text-md-right">{{ __('Verification Mode') }}</label>

                                <div class="col-md-8">

                                    <div class="d-flex payment-images">                                        
                                        <span class="p-1"><img src="/images/card10.jpg" alt="Manual" class="border img img-fluid active"  ></span>                                     
                                        
                                    </div>
                                    
                                </div>
                            </div>  

                            <div id="otherFormFields" class="d-none">

                            </div>

                            <div class="form-group row d-none">
                                <div class="col-12 text-center alert " id="alert_message">
                                    
                                </div>
                            </div>
                                                        
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    {{-- <button type="button" class="btn btn-primary d-none" id="submitbtn" disabled>
                                        {{ __('Verify') }}
                                    </button> --}}

                                    <div id="getPaymentBtn" class="d-inline"></div>
                                    
                                    <a href="{{ url('/student/course-bookings') }}" class="btn btn-secondary">Verify Later</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 text-center mt-2 d-none" id="qr-payment-image">
                <img src="{{ asset('images/payment-details.png') }}" alt="" class="img img-fluid" style="max-height:400px;">
            </div>
        </div>
    </div>   

    <script>       
        $(document).ready(function() {
            $("#verifyCourseForm").attr('action','#');
            $('#getPaymentBtn').html('');
            $('#alert_message').html('');
            $('#alert_message').parent().addClass('d-none');
            $('#otherFormFields').html('');                
            $('#qr-payment-image').removeClass('d-none');
            getManualPayment();
        });

        function getManualPayment() 
        {
            $("#verifyCourseForm").attr('action','/student/course-bookings/{{$booking->id}}/manual-pay');

            var extrahtml = `
            <div class="form-group row">
                <label for="paymentAmount" class="col-md-4 col-form-label text-md-right">{{ __('Payment Amount') }}</label>

                <div class="col-md-8">
                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? $booking->paymentAmount ?? ($booking->batch->fee - $booking->batch->discount) }}" >

                    @error('paymentAmount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="verificationDocument" class="col-md-4 col-form-label text-md-right">{{ __('Verification Document') }} </label>

                <div class="col-md-8">
                    <input id="verificationDocument" type="file" class="form-control @error('verificationDocument') is-invalid @enderror" name="verificationDocument" value="{{ old('verificationDocument') ?? $booking->verificationDocument }}" required>

                    @error('verificationDocument')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <input type="hidden" name="verificationMode" value="Manual">
            `;

            $('#otherFormFields').removeClass('d-none');
            $('#otherFormFields').html(extrahtml);

            var btn = `
            <button type="submit" class="btn btn-primary"> Verify Manually </button>
            `;
            $('#getPaymentBtn').html(btn);
        }
        

    </script>

@endsection
