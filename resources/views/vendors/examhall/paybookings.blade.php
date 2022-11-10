@extends('vendors.layouts.app')
@section('admin-title')
    Exam Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Exam Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/vendor/exam-hall/bookings') }}">Exam Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Exam Bookings</div>
                    <div class="card-body">
                        <form method="POST" id="verifyCourseForm" action="/vendor/exam-hall/bookings" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="exam_name" class="col-md-4 col-form-label">{{ __('Exam Category Name') }}</label>
                                <div class="col-md-8">
                                    <select name="exam_name" id="exam_name" class="form-control @error('exam_name') is-invalid @enderror" value="{{ old('exam_name') }}" required readonly>
                                        <option value="{{$exam->id}}">{{$exam->title}}</option>
                                    </select>
                                    @error('exam_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="examPrice" class="col-md-4 col-form-label">{{ __('Exam Price') }}</label>

                                <div class="col-md-8">
                                    <input id="examPrice" type="text" class="form-control @error('examPrice') is-invalid @enderror" name="examPrice" value="{{ $exam->price - $exam->discount }}" readonly >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="myPrice" class="col-md-4 col-form-label">{{ __('Vendor Discounted Price') }}</label>

                                <div class="col-md-8">
                                    <input id="myPrice" type="text" class="form-control @error('myPrice') is-invalid @enderror" name="myPrice" value="{{ floor(($exam->price - $exam->discount) * (auth()->user()->vendor->vendor_discount/100)) }}" readonly >
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
                                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? (floor(($exam->price - $exam->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count)) }}" >
                                    <label class="">Out of Rs. {{ floor(($exam->price - $exam->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count) }} </label>

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
        var initurl='{{url("vendor/exam-hall/bookings/exam/$exam->id/users")}}';
        var params= {
          amt: {{ floor(($exam->price - $exam->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count) }},
          psc: 0,
          pdc: 0,
          txAmt: 0,
          tAmt: {{ floor(($exam->price - $exam->discount) * (auth()->user()->vendor->vendor_discount/100) * $user_count)}},
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
