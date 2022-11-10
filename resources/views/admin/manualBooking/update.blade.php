@extends('admin.layouts.app')
@section('admin-title')
    Update Manual Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Update Manual Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update Manual Booking</li>
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
                    <form method="POST" action="/admin/manual-booking/{{$mbooking->id}}" enctype="multipart/form-data">
                        @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="mbookingid" class="col-md-4 col-form-label">{{ __('Mamual Booking ID') }}</label>

                                <div class="col-md-8">
                                    <input id="mbookingid" type="text" class="form-control @error('mbookingid') is-invalid @enderror" name="mbookingid" value="{{ old('id') ?? $mbooking->id }}" readonly>

                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="course_name" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>

                            <div class="col-md-8">
                                <input id="course_name" type="text" class="form-control @error('course') is-invalid @enderror" name="mbookingid" value="{{ old('course') ?? $mbooking->course->name }}" readonly>
                             
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-md-4 col-form-label">{{ __('Full Name') }}</label>

                            <div class="col-md-8">
                                <input id="fname" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $mbooking->name }}" readonly >

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $mbooking->email }}" readonly >

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobileNo" class="col-md-4 col-form-label">{{ __('Contact No.') }}</label>

                            <div class="col-md-8">
                                <input id="mobileNo" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') ?? $mbooking->mobile }}" readonly>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="district" class="col-md-4 col-form-label">{{ __('District') }}</label>

                            <div class="col-md-8">
                                <input id="district" type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district') ?? $mbooking->district }}" readonly>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remarks" class="col-md-4 col-form-label">{{ __('Remarks') }}</label>

                            <div class="col-md-8">
                                <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') ?? $mbooking->remarks }}" readonly >

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label">{{ __('User ID') }}</label>

                            <div class="col-md-8">
                                <input id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') ?? $mbooking->user_id }}" readonly >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_slip" class="col-md-4 col-form-label">{{ __('Payment 
                            Slip') }}</label>

                            <div class="col-md-8">
                                <a href="/storage/{{$mbooking->payment_slip}}" target="_blank">
                                    <img src="/storage/{{$mbooking->payment_slip}}" class="w-100 img img-responsive">
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
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') ?? $mbooking->status }}"  required>
                                    <option value="{{$mbooking->status}}">{{$mbooking->status}}</option>
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

                        <div class="form-group row">
                            <label for="team_member" class="col-md-4 col-form-label">{{ __('Team Member') }}</label>

                            <div class="col-md-8">
                                <input id="team_member" type="text" class="form-control @error('team_member') is-invalid @enderror" name="team_member" value="{{ old('team_member') ?? ucwords($mbooking->team->name ?? '') }}" readonly >

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