@extends('student.layouts.app')

@section('student-title')
    Special Course Verify Booking
@endsection
@section('student-title-icon')
    <i class="fas fa-user-check"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="processing verify-processing">
                    <div class="first-step">
                        <div class="f-point point"></div>
                        <div class="line"></div>
                        <div class="f-point-l point"></div>
                        <p>Booking</p>
                    </div>
                    <div class="second-step">
                        <div class="line"></div>
                        <div class="point"></div>
                        <p class="processing-verify">Verify</p>
                        <p class="processing-classroom">Classroom</p>
                    </div>
                   
                </div>
            </div>
            <div class="col-md-8">
                <div class="card student_verify_card">
                    <div class="card-header">{{ __('Booking. ID: ') }} {{$booking->id}} {{$booking->course->course}}</div>

                    <div class="card-body enroll_form">
                        <form method="POST" action="/student/tutor-special/courses/{{$booking->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
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
                                <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Course Name') }}</label>

                                <div class="col-md-8">
                                    <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') ?? $booking->course->course}}" readonly>

                                    @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('Course Duration') }}</label>

                                <div class="col-md-8">
                                    <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $booking->course->duration}}" readonly>

                                    @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verificationMode" class="col-md-4 col-form-label text-md-right">{{ __('Verification Mode') }}</label>

                                <div class="col-md-8">
                                    <select name="verificationMode" id="verificationMode" class="form-control @error('verificationMode') is-invalid @enderror" value="{{ old('verificationMode') ?? $booking->verificationMode }}"  required>
                                        <option value="Self">Self</option>
                                        <option value="Connect IPS">Connect IPS</option>
                                        <option value="IME Pay">IME Pay</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="Khalti">Khalti</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                    @error('verificationMode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="accountNo" class="col-md-4 col-form-label text-md-right">{{ __('Account No') }}</label>

                                <div class="col-md-8">
                                    <input id="accountNo" type="text" class="form-control @error('accountNo') is-invalid @enderror" name="accountNo" value="{{ old('accountNo') ?? $booking->accountNo }}" >

                                    @error('accountNo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="paymentAmount" class="col-md-4 col-form-label text-md-right">{{ __('Payment Amount') }}</label>

                                <div class="col-md-8">
                                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? $booking->paymentAmount ?? ($booking->course->fee-$booking->course->discount) }}" required >

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




                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Verify') }}
                                    </button>
                                    <a href="{{ url('/student/tutor-special/courses') }}" class="btn btn-secondary">Verify Later</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('images/payment-details.png') }}" alt="" class="w-100">
            </div>
        </div>
    </div>
@endsection
