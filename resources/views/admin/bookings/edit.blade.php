@extends('admin.layouts.app')
@section('admin-title')
    Verify Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Verify Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/bookings') }}">Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Verify</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Verify Booking | {{$booking->course->name ??''}} | {{$booking->user->name ?? ''}}</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/bookings/{{$booking->id}}" enctype="multipart/form-data">
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
                                <label for="student" class="col-md-4 col-form-label">{{ __('Student') }}</label>

                                <div class="col-md-8">
                                    <input id="student" type="text" class="form-control @error('student') is-invalid @enderror" name="student" value="{{$booking->user->name .' | '. $booking->user->contact ?? ''}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>
                                <div class="col-md-8">
                                        <select name="course_name" id="course_name" class="form-control @error('course_name') is-invalid @enderror" value="{{ old('course_name') }}" autofocus required>
                                            <option value="{{$booking->course->id}}">{{$booking->course->name}}</option>
                                            <option value="">---------</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}"> {{$course->name}} </option>
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
                                        <option value="{{$booking->batch->id}}">{{$booking->batch->name}}</option>
                                    </select>
                                    @error('batch_name')
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
                                    <label class="">Out of Rs. {{(($booking->batch->fee)-($booking->batch->discount))}} </label>

                                    @error('paymentAmount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label">{{ __('Discount') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? ($booking->discount ?? 0)}}" >

                                    @error('discount')
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
                                <label for="verificationDocument" class="col-md-4 col-form-label">{{ __('Verification Document') }}</label>
                                <div class="col-md-8">
                                    <a href="/storage/{{$booking->verificationDocument}}" target="_blank">
                                        <img src="/storage/{{$booking->verificationDocument}}" alt="" class="w-100 img img-responsive">
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
                                        <option value="">-------------</option>
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
                                <label for="suspended" class="col-md-4 col-form-label">{{ __('Suspended') }}</label>

                                <div class="col-md-8">
                                    <select name="suspended" id="suspended" class="form-control @error('suspended') is-invalid @enderror" value="{{ old('suspended') ?? $booking->suspended }}"  required>
                                        <option value="{{$booking->suspended}}">
                                            @if($booking->suspended) Suspended @else Unsuspended @endif
                                        </option>
                                        <option value="">--------------</option>
                                        <option value="0">Unsuspended</option>
                                        <option value="1">Suspended</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarks" class="col-md-4 col-form-label">{{ __('Remarks') }}</label>

                                <div class="col-md-8">
                                    <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') ?? $booking->remarks }}">

                                    @error('remarks')
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
        $(document).ready(function () 
        {
            $(document).on('change', '#course_name', function() {
                var course_id = $(this).find(":selected").attr('value');
                // console.log(course_id);
                get_batches(course_id);                
            });

            function get_batches(id)
            {
                $('#batch_name').html("");
                var op='';
                var request = new XMLHttpRequest()
                request.open('GET', '/courses/'+id+'/batchnames', true)
                request.onload = function () {
                    // Begin accessing JSON data here
                    if (request.status >= 200 && request.status < 400) {
                        var data = JSON.parse(this.response);
                        var batches=data.batches;
                        batches.forEach((batch) => {
                            op += '<option value="' + batch.id + '">' + batch.name + '</option>';
                        });
                        // console.log(op);
                        $('#batch_name').append(op);
                    } else {
                        console.log('error');
                        $('#batch_name').html("");
                    }
                }
                request.send();
            }
        });
    </script>

@endsection
