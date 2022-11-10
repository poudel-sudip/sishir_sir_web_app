@extends('admin.layouts.app')
@section('admin-title')
    Create Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/bookings') }}">Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Booking</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Booking</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/bookings" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>
                                <div class="col-md-8">
                                        <select name="course_name" id="course_name" class="form-control @error('course_name') is-invalid @enderror" value="{{ old('course_name') }}" autofocus required>
                                           <option value=""></option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}" slug="{{$course->slug}}"> {{$course->name}} </option>
                                            @endforeach
                                    </select>
                                    @error('course_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="batch_name" class="col-md-4 col-form-label">{{ __('Batch Name') }}</label>

                                <div class="col-md-8">
                                        <select name="batch_name" id="batch_name" class="form-control @error('batch_name') is-invalid @enderror" value="{{ old('batch_name') }}"  required>
                                    </select>
                                    @error('batch_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="userid" class="col-md-4 col-form-label">{{ __('User ID') }}</label>

                                <div class="col-md-8">
                                    <input id="userid" type="text" class="form-control @error('userid') is-invalid @enderror" name="userid" value="{{ old('userid') }}" >

                                    @error('userid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label">{{ __('User Full Name') }}</label>

                                <div class="col-md-8">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username" >

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">{{ __('Booking Description') }} </label>

                                <div class="col-md-8">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verificationMode" class="col-md-4 col-form-label">{{ __('Verification Mode') }}</label>

                                <div class="col-md-8">
                                    <select name="verificationMode" id="verificationMode" class="form-control @error('verificationMode') is-invalid @enderror" value="{{ old('verificationMode') }}"  required>
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
                                <label for="accountNo" class="col-md-4 col-form-label ">{{ __('Account No') }}</label>

                                <div class="col-md-8">
                                    <input id="accountNo" type="text" class="form-control @error('accountNo') is-invalid @enderror" name="accountNo" value="{{ old('accountNo') }}" >

                                    @error('accountNo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="paymentAmount" class="col-md-4 col-form-label ">{{ __('Payment Amount') }}</label>

                                <div class="col-md-8">
                                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? 0 }}" required >

                                    @error('paymentAmount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label ">{{ __('Discount') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? 0 }}" required >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verificationDocument" class="col-md-4 col-form-label">{{ __('Verification Document Photo') }} </label>

                                <div class="col-md-8">
                                    <input id="verificationDocument" type="file" class="form-control @error('verificationDocument') is-invalid @enderror" name="verificationDocument" value="{{ old('verificationDocument') }}" >

                                    @error('verificationDocument')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="features" class="col-md-4 col-form-label">{{ __('Booking Features') }}</label>

                                <div class="col-md-8">
                                    <select name="features" id="features" class="form-control @error('features') is-invalid @enderror" value="{{ old('features') }}"  required>
                                        <option value="All">All</option>
                                        <option value="Classroom">Classroom</option>
                                    </select>
                                    @error('features')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Booking Status') }}</label>

                                <div class="col-md-8">
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') }}"  required>
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

    <script>



    </script>

@endsection
