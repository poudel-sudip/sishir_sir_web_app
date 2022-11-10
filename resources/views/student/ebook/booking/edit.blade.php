@extends('student.layouts.app')

@section('student-title')
    Edit E-Book Booking
@endsection
@section('student-title-icon')
    <i class="far fa-check-circle"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row">
            <div class="col-md-8">
                <div class="card student_verify_card">
                    <div class="card-header">{{ __('Booking ID: ') }} {{$booking->id}} | {{$booking->book->title ?? ''}}</div>

                    <div class="card-body enroll_form">
                        <form id="verifyCourseForm" method="POST" action="/student/ebook/{{$booking->id}}" enctype="multipart/form-data">
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
                                <label for="book" class="col-md-4 col-form-label text-md-right">{{ __('E-Book Name') }}</label>

                                <div class="col-md-8">
                                    <input id="book" type="text" class="form-control @error('book') is-invalid @enderror" name="book" value="{{ old('book') ?? ($booking->book->title.' @ Rs.'. ($booking->book->price - $booking->book->discount)) }}" readonly>

                                    @error('book')
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
                                        <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? $booking->paymentAmount ?? ($booking->book->price - $booking->book->discount) }}" >

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
                                    <button type="button" class="btn btn-primary" id="submitbtn">
                                        {{ __('Verify') }}
                                    </button>
                                    <a href="{{ url('/student/ebook') }}" class="btn btn-secondary">Verify Later</a>
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

      function pay_esewa()
      {
        var path="https://esewa.com.np/epay/main";
        var params= {
            amt: {{ $booking->book->price - $booking->book->discount }},
            psc: 0,
            pdc: 0,
            txAmt: 0,
            tAmt: {{$booking->book->price - $booking->book->discount}},
            pid: "{{$booking->id.'-'.time()}}",
            scd: "NP-ES-ODADEPL",
            su: '{{url("student/ebook/$booking->id/esewaSuccess")}}',
            fu: '{{url("student/ebook/$booking->id/payment-failed")}}'
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

    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <script>
        function pay_khalti()
        {
            var config = {
                // replace the publicKey with yours
                "publicKey": "test_public_key_bc744f8267dc4775a38af37cab5591d0",
                "productIdentity": "{{$booking->id.'-'.time()}}",
                "productName": "{{$booking->book->title}}",
                "productUrl": "{{url('student/ebook')}}",
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
                                url: '{{url("student/ebook/$booking->id/khaltiSuccess")}}',
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
                                        window.location = '{{url("student/ebook/$booking->id/payment-failed")}}';
                                    }
                                },

                                error: function(data) {
                                    // console.log('Error:',data);
                                    window.location = '{{url("student/ebook/$booking->id/payment-failed")}}';
                                },
                            });
                        }
                    },
                    onError (error) {
                        // console.log(error);
                        window.location = '{{url("student/ebook/$booking->id/payment-failed")}}';
                    },
                    onClose () {
                        console.log('widget is closing');
                    }
                }
            };

            var amt = {{ $booking->book->price - $booking->book->discount}};
            var checkout = new KhaltiCheckout(config);

            checkout.show({amount: amt * 100});
        }
    </script>

@endsection
