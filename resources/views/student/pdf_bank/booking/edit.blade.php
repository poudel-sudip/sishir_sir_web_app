@extends('student.layouts.app')

@section('student-title')
    Edit PDF Bank Booking
@endsection
@section('student-title-icon')
    <i class="far fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card student_verify_card">
                    <div class="card-header">{{ __('Booking ID: ') }} {{$booking->id}} | {{$booking->book->title ?? ''}}</div>

                    <div class="card-body enroll_form">
                        <form id="verifyCourseForm" method="POST" action="/student/pdf-bank-bookings/{{$booking->id}}" enctype="multipart/form-data">
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
                                <label for="pdf_bank" class="col-md-4 col-form-label text-md-right">{{ __('PDF Bank') }}</label>

                                <div class="col-md-8">
                                    <input id="pdf_bank" type="text" class="form-control @error('pdf_bank') is-invalid @enderror" name="pdf_bank" value="{{ old('pdf_bank') ?? ($booking->book->title.' @ Rs.'. ($booking->book->price - $booking->book->discount)) }}" readonly>

                                    @error('pdf_bank')
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
                                        @if($esewa_pay_data)
                                        <option value="Esewa">Esewa</option>
                                        @endif
                                        @if($fonepay_pay_data)
                                        <option value="FonePay">FonePay</option>
                                        @endif

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
                                    <a href="{{ url('/student/pdf-bank-bookings') }}" class="btn btn-secondary">Verify Later</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4 row">
                <div class="col-12">
                    <img src="{{ asset('images/payment-details.png') }}" alt="" class="w-100">
                </div> 
            </div> --}}
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
            else if(mode=="FonePay")
            {
                pay_fonepay();
            }
            // else if(mode=="Khalti")
            // {
            //     pay_khalti();
            // }
            else
            {
                alert("Please Select One Verification Mode");
            }
        });
    </script>

    @if($esewa_pay_data)
        <script>

            function pay_esewa()
            {
                var path = "{{Config::get('payment.esewa_pay_url')}}";
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", path);

                @foreach($esewa_pay_data as $key=>$value) 
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "{{$key}}");
                    hiddenField.setAttribute("value", "{{$value}}");
                    form.appendChild(hiddenField);
                @endforeach

                document.body.appendChild(form);
                form.submit();
            }

        </script>
    @endif

    @if($fonepay_pay_data)
        <script>
            function pay_fonepay()
            {
                var path = "{{Config::get('payment.fonepay_pay_url')}}";
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", path);

                @foreach($fonepay_pay_data as $key=>$value) 
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "{{$key}}");
                    hiddenField.setAttribute("value", "{{$value}}");
                    form.appendChild(hiddenField);
                @endforeach

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    @endif

@endsection
