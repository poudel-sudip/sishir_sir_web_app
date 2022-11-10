@extends('admin.layouts.app')
@section('admin-title')
    Verify Special Course Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Verify Tutor Special Course Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses">Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/bookings">Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Verify  {{$course->course}} of {{$booking->user_name}}</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/bookings/{{$booking->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="bookingid" class="col-md-4 col-form-label">{{ __('Booking ID') }}</label>

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
                                <label for="courseid" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>

                                <div class="col-md-8">
                                    <input id="courseid" type="text" class="form-control @error('courseid') is-invalid @enderror" name="courseid" value="{{ old('courseid') ?? $booking->course->course}}" readonly>

                                    @error('courseid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="duration" class="col-md-4 col-form-label">{{ __('Course Duration') }}</label>

                                <div class="col-md-8">
                                    <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $booking->course->duration }}" readonly>

                                    @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="paymentAmount" class="col-md-4 col-form-label">{{ __('Payment Amount') }}</label>

                                <div class="col-md-8">
                                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? ($booking->paymentAmount ?? 0)}}" >
                                    <label class="">Out of Rs. {{(($booking->course->fee)-($booking->course->discount))}} </label>

                                    @error('paymentAmount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verificationMode" class="col-md-4 col-form-label">{{ __('Payment Mode') }}</label>

                                <div class="col-md-8">
                                    <select name="verificationMode" id="verificationMode" class="form-control @error('verificationMode') is-invalid @enderror" required>
                                        <option value="{{$booking->verificationMode ?? ''}}">{{$booking->verificationMode ?? ''}}</option>
                                        <option value="">----------</option>
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
                                <label for="accountNo" class="col-md-4 col-form-label">{{ __('Account No') }}</label>

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
                                <label for="verificationDocument" class="col-md-4 col-form-label">{{ __('Verification Document') }}</label>
                                <div class="col-md-8">
                                    <a href="/storage/{{$booking->verificationDocument}}" target="_blank">
                                        <img src="/storage/{{$booking->verificationDocument}}" class="w-100 img img-responsive">
                                    </a>
                                    <br><br>
                                    <input type="hidden" name="oldDocument" value="{{$booking->verificationDocument}}">

                                    <label for="uploadDocument" class="@error('uploadDocument') is-invalid @enderror" style="cursor:pointer">Edit Document</label>

                                    <input type="file" id="uploadDocument" name="uploadDocument" class="d-none">
                                    @error('uploadDocument')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Booking Status') }}</label>

                                <div class="col-md-8">
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') ?? $booking->status }}"  required>
                                        <option value="{{$booking->status}}">{{$booking->status}}</option>
                                        <option value="">-----------</option>
                                        <option value="Unverified">Unverified</option>
                                        <option value="Verified">Verified</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="coursefee" value="{{($booking->course->fee)-($booking->course->discount)}}">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
