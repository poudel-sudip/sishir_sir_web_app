@extends('student.layouts.app')

@section('student-title')
    Verify Booking
@endsection

@section('student-title-icon')
<i class="fas fa-user-check"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">
        <div class="row">
            <div class="col-md-8">
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
                </div>
                <div class="card student_verify_card">
                    <div class="card-header">{{ __('Booking. ID: ') }} {{$booking->id}} {{$booking->course->name.' '.$booking->batch->name}}</div>

                    <div class="card-body enroll_form">
                        <form id="verifyCourseForm" method="POST" action="/student/course-bookings/{{$booking->id}}" enctype="multipart/form-data">
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
                                <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Course Name') }}</label>

                                <div class="col-md-8">
                                    <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') ?? $booking->course->name.' - '.$booking->batch->name }}" readonly>

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
                                    <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $booking->batch->duration.' '.$booking->batch->durationType }}" readonly>

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
                                    <select name="verificationMode" id="verificationMode" class="form-control @error('verificationMode') is-invalid @enderror" value="{{ old('verificationMode') ?? $booking->verificationMode }}" required>
                                        <option value="">Choose One....</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="Khalti">Khalti</option>
                                        
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
                                    <label for="paymentAmount" class="col-md-4 col-form-label text-md-right">{{ __('Payment Amount') }}</label>

                                    <div class="col-md-8">
                                        <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? $booking->paymentAmount ?? ($booking->batch->fee-$booking->batch->discount) }}" >

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
                            </div>
                           
                            <div class="form-group row d-none">
                                <div class="col-12 text-center alert " id="alert_message">
                                    
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary " id="submitbtn">
                                        {{ __('Verify') }}
                                    </button>
                                    <a href="{{ url('/student/home') }}" id="redirectbtn" class="btn btn-secondary">Verify Later</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 row">
                <div class="col-12">
                    <img src="{{ asset('images/payment-details.png') }}" alt="" class="w-100">
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
            if(mode=="Manual")
            {
                $( "#verifyCourseForm" ).submit(); 
            }
            else if(mode=="Esewa")
            {
                pay_esewa();
            }
            else if(mode=="Khalti")
            {
                pay_khalti();
            }
            else
            {
                alert("Please Select One Verification Mode");
            }
        });
    </script>


    <script>

        function pay_esewa()
        {
            var path="{{Config::get('payment.esewa_pay_url')}}";
            var params= {
                amt: {{ $booking->batch->fee - $booking->batch->discount }},
                psc: 0,
                pdc: 0,
                txAmt: 0,
                tAmt: {{ $booking->batch->fee - $booking->batch->discount}},
                pid: "{{$booking->id.'-'.time()}}",
                scd: "{{Config::get('payment.esewa_scd')}}",
                su: '{{url("student/course-bookings/$booking->id/esewaSuccess")}}',
                fu: '{{url("student/course-bookings/$booking->id/payment-failed")}}'
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

    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <script>
        function pay_khalti()
        {
            var config = {
                // replace the publicKey with yours
                "publicKey": "{{Config::get('payment.khalti_public_key')}}",
                "productIdentity": "{{$booking->id.'-'.time()}}",
                "productName": "{{$booking->batch->name}}",
                "productUrl": "{{url('student/course-bookings/'.$booking->id)}}",
                "paymentPreference": [
                    "KHALTI",
                    "EBANKING",
                    "MOBILE_BANKING",
                    "CONNECT_IPS",
                ],
                "eventHandler": {
                    onSuccess (payload) {
                        // console.log(payload);
                        checkout.hide();
                        $('#submitbtn').addClass('disabled btn-warning').html('Please Wait').val('Please Wait');
                        $('#alert_message').parent().removeClass('d-none');
                        $('#alert_message').addClass('alert-info').html('<strong> Please Wait a Minute Patiently.</strong>');
                        
                        if(payload.idx)
                        {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                                }
                            });

                            $.ajax({
                                method: 'POST',
                                url: '{{url("student/course-bookings/$booking->id/khaltiSuccess")}}',
                                data: payload,

                                success: function(response) {
                                    // console.log(response);
                                    if(response.success == 1)
                                    {
                                        window.location = response.redirecto;
                                    }
                                    else
                                    {
                                        checkout.hide();
                                        window.location = '{{url("student/course-bookings/$booking->id/payment-failed")}}';
                                    }
                                },

                                error: function(data) {
                                    // console.log('Error:',data);
                                    window.location = '{{url("student/course-bookings/$booking->id/payment-failed")}}';
                                },
                            });
                        }
                    },
                    onError (error) {
                        // console.log(error);
                        window.location = '{{url("student/course-bookings/$booking->id/payment-failed")}}';
                    },
                    onClose () {
                        console.log('widget is closing');
                    }
                }
            };

            var amt = {{ $booking->batch->fee - $booking->batch->discount}};
            var checkout = new KhaltiCheckout(config);

            checkout.show({amount: amt * 100});
        }
    </script>

@endsection
