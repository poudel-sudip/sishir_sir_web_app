@extends('teams.layouts.app')
@section('admin-title')
    Update Manual Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Update Manual Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/team/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/team/manual-bookings') }}">Manual Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Update Manual Booking</h4>
                    </div>
                    <form method="POST" action="/team/manual-bookings/{{$booking->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="bookingid" class="col-md-4 col-form-label">{{ __('Manual Booking ID') }}</label>

                            <div class="col-md-8">
                                <input id="bookingid" type="text" class="form-control @error('bookingid') is-invalid @enderror" name="bookingid" value="{{ old('id') ?? $booking->id }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="course_name" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>

                            <div class="col-md-8">
                                <input id="course_name" type="text" class="form-control @error('course') is-invalid @enderror" name="mbookingid" value="{{ old('course') ?? ($booking->course->name ?? '') }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-md-4 col-form-label">{{ __('Full Name') }}</label>

                            <div class="col-md-8">
                                <input id="fname" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $booking->name }}" readonly >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $booking->email }}" readonly >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobileNo" class="col-md-4 col-form-label">{{ __('Contact No.') }}</label>

                            <div class="col-md-8">
                                <input id="mobileNo" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') ?? $booking->mobile }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="provience" class="col-md-4 col-form-label">{{ __('Provience') }}</label>

                            <div class="col-md-8">
                                <input id="provience" type="text" class="form-control @error('provience') is-invalid @enderror" name="provience" value="{{ old('provience') ?? $booking->provience }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="district" class="col-md-4 col-form-label">{{ __('District') }}</label>

                            <div class="col-md-8">
                                <input id="district" type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district') ?? $booking->district }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label">{{ __('User ID') }}</label>

                            <div class="col-md-8">
                                <input id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') ?? $booking->user_id }}" readonly >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remarks" class="col-md-4 col-form-label">{{ __('Remarks') }}</label>

                            <div class="col-md-8">
                                <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') ?? $booking->remarks }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_slip" class="col-md-4 col-form-label">{{ __('Payment Slip') }}</label>

                            <div class="col-md-8">
                                <a href="/storage/{{$booking->payment_slip}}" target="_blank">
                                    <img src="/storage/{{$booking->payment_slip}}" class="w-100 img img-responsive">
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="create_user" class="col-md-4 col-form-label">{{ __('Create User') }}</label>

                            <div class="col-md-8">
                                <input id="create_user" type="checkbox" class="form-control @error('create_user') is-invalid @enderror" name="create_user" value="yes" style="width: auto; display:inline-block;" > 
                                <label for="create_user" style="vertical-align: baseline;">Create Now</label> 
                                @error('create_user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label">{{ __('Manual Booking Status') }}</label>

                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') ?? $booking->status }}"  required>
                                    <option value="{{$booking->status}}">{{$booking->status}}</option>
                                    <option value="">--------------------</option>
                                    <option value="Unverified">Unverified</option>
                                    <option value="Processing">Processing</option>
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
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection