@extends('vendors.layouts.app')
@section('admin-title')
    Video Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Video Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/vendor/video-booking') }}">Video Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Video Bookings</div>
                    <div class="card-body">
                        <form method="POST" id="verifyCourseForm" action="/vendor/video-booking" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="course" class="col-md-4 col-form-label">{{ __('Video Course Name') }}</label>
                                <div class="col-md-8">
                                    <select name="course" id="course" class="form-control @error('course') is-invalid @enderror" value="{{ old('course') }}" required readonly>
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                    </select>
                                    @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="coursePrice" class="col-md-4 col-form-label">{{ __('Video Course Price') }}</label>

                                <div class="col-md-8">
                                    <input id="coursePrice" type="text" class="form-control @error('coursePrice') is-invalid @enderror" name="coursePrice" value="{{ $course->fee - $course->discount }}" readonly >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="myPrice" class="col-md-4 col-form-label">{{ __('Vendor Discounted Price') }}</label>

                                <div class="col-md-8">
                                    <input id="myPrice" type="text" class="form-control @error('myPrice') is-invalid @enderror" name="myPrice" value="{{ floor(($course->fee - $course->discount) * (auth()->user()->vendor->vendor_discount/100)) }}" readonly >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="count" class="col-md-4 col-form-label">{{ __('No of User Bookings') }}</label>

                                <div class="col-md-8">
                                    <input id="count" type="text" class="form-control @error('count') is-invalid @enderror" name="count" value="{{ $user_count }}" readonly >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="userIds" class="col-md-4 col-form-label">{{ __('User Id Separated  by Comma') }}</label>

                                <div class="col-md-8">
                                    <input id="userIds" type="text" class="form-control @error('userIds') is-invalid @enderror" name="userIds" value="{{ old('userIds') ?? '' }}" >

                                    @error('userIds')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="paymentAmount" class="col-md-4 col-form-label">{{ __('Payment Amount') }}</label>

                                <div class="col-md-8">
                                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? (floor(($course->fee - $course->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count)) }}" >
                                    <label class="">Out of Rs. {{ floor(($course->fee - $course->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count) }} </label>

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
                                        <option value="">Choose One Option....</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Esewa">Esewa</option>
                                    </select>
                                    @error('verificationMode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="manualForm" class="d-none">
                                <div class="form-group row">
                                    <label for="verificationDocument" class="col-md-4 col-form-label">{{ __('Verification Document') }} </label>

                                    <div class="col-md-8">
                                        <input id="verificationDocument" type="file" class="form-control @error('verificationDocument') is-invalid @enderror" name="verificationDocument" value="{{ old('verificationDocument') }}" required>

                                        @error('verificationDocument')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary" id="submitbtn">
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
        $(document).on('change', '#verificationMode', function() {
            var mode = $(this).val();
            if(mode=="Manual")
            {
                $("#manualForm").removeClass("d-none");
            }
            else{
                $("#manualForm").addClass("d-none");
            }
        }); 


        $(document).on('click', '#submitbtn', function() {
            var mode = $('#verificationMode').val();
            var userids = $('#userIds').val(); //get all entered user ids separated by comma
            var count = {{ $user_count }}; // get the total no of bookings
            if(!userids)
            {
                alert("Please Enter User Id");
                exit;
            }
            userids = userids.split(",");  //convert user ids string to array
            userids.splice(count);  // remove the user ids if no of user ids are greater than booking no

            if(mode=="Manual")
            {
                $( "#verifyCourseForm" ).submit(); 
            }
            else if(mode=="Esewa")
            {
                //userids should be an array of numbers
                // exit;
                pay_esewa(userids);
            }
            else
            {
                alert("Please Select One Verification Mode");
            }
        });

    </script>

<script>

    function pay_esewa(userids)
    {
        userids = userids.join("-");
        var path="https://esewa.com.np/epay/main";
        var initurl='{{url("vendor/video-booking/course/$course->id/users")}}';
        var params= {
          amt: {{ floor(($course->fee - $course->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count) }},
          psc: 0,
          pdc: 0,
          txAmt: 0,
          tAmt: {{ floor(($course->fee - $course->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count)}},
          pid: "{{time()}}",
          scd: "NP-ES-ODADEPL",
          su: initurl+"/"+userids+"/esewaSuccess",
          fu: initurl+"/"+userids+"/payment-failed",
        };

        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", path);

        for(var key in params) {
          var hiddenField = document.createElement("input");
          hiddenField.setAttribute("type", "hidden");
          hiddenField.setAttribute("name", key);
          hiddenField.setAttribute("value", params[key]);
          form.appendChild(hiddenField);
        }

        document.body.appendChild(form);
        form.submit();
    }

  </script>

@endsection
