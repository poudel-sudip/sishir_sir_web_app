@extends('student.layouts.app')

@section('student-title')
    Verify Exam Set Booking
@endsection
@section('student-title-icon')
    <i class="far fa-check-circle"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card student_verify_card">
                    <div class="card-header">{{ __('Booking. ID: ') }} {{$booking->id}} {{$booking->category->title ?? ''}}</div>

                    <div class="card-body enroll_form">
                        <form id="verifyCourseForm" method="POST" action="#" enctype="multipart/form-data">
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
                                <label for="exam_category" class="col-md-4 col-form-label text-md-right">{{ __('Exam Set') }}</label>

                                <div class="col-md-8">
                                    <input id="exam_category" type="text" class="form-control @error('exam_category') is-invalid @enderror" name="exam_category" value="{{ old('exam_category') ?? ($booking->category->title.' @ Rs.'. ($booking->category->price - $booking->category->discount)) }}" readonly>

                                    @error('exam_category')
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
                                        @if($esewa_pay_data)
                                        <option value="Esewa">Esewa</option>
                                        @endif
                                        @if($fonepay_pay_data)
                                        <option value="FonePay">FonePay</option>
                                        @endif
                                        @if($nepalpay_pay_data)
                                        <option value="NepalPay">Nepal Pay Wallet</option>
                                        @endif
                                        <option value="Coupon">Coupon</option>
                                        <option value="Manual">Manual</option>

                                        {{-- <option value="Khalti">Khalti</option> --}}
                                        
                                    </select>
                                    @error('verificationMode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="otherFormFields" class="d-none">

                            </div>

                            <div class="form-group row d-none">
                                <div class="col-12 text-center alert " id="alert_message">
                                    
                                </div>
                            </div>
                                                        
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    {{-- <button type="button" class="btn btn-primary d-none" id="submitbtn" disabled>
                                        {{ __('Verify') }}
                                    </button> --}}

                                    <div id="getPaymentBtn" class="d-inline"></div>
                                    
                                    <a href="{{ url('/student/exam-bookings') }}" class="btn btn-secondary">Verify Later</a>
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
            $("#verifyCourseForm").attr('action','#');
            $('#getPaymentBtn').html('');
            $('#alert_message').html('');
            $('#alert_message').parent().addClass('d-none');
            $('#otherFormFields').html('');

            var mode = $(this).val();

            if(mode=="Manual")
            {
                getManualPayment(); 
            }
            else if(mode=="Coupon")
            {
                getCouponPayment();
            }
            else if(mode=="Esewa")
            {
                getEsewaPayment();
            }
            else if(mode=="FonePay")
            {
                getFonePayPayment();
            }
            else if(mode=="NepalPay")
            {
                getNepalPayPayment();
            }
            else{}
          
        }); 
        
        function getManualPayment() 
        {
            $("#verifyCourseForm").attr('action','/student/exam-bookings/{{$booking->id}}/manual-pay');

            var extrahtml = `
            <div class="form-group row">
                <label for="paymentAmount" class="col-md-4 col-form-label text-md-right">{{ __('Payment Amount') }}</label>

                <div class="col-md-8">
                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? $booking->paidAmount ?? ($booking->category->price - $booking->category->discount) }}" >

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
            
            `;

            $('#otherFormFields').removeClass('d-none');
            $('#otherFormFields').html(extrahtml);

            var btn = `
            <button type="submit" class="btn btn-primary"> Verify Manually </button>
            `;
            $('#getPaymentBtn').html(btn);
        }

        function getCouponPayment()
        {
            $("#verifyCourseForm").attr('action','/student/exam-bookings/{{$booking->id}}/coupon-pay');
            
            var extrahtml = `
            <div class="form-group row">
                <label for="coupon_code" class="col-md-4 col-form-label text-md-right">{{ __('Coupon Code') }}</label>

                <div class="col-md-8">
                    <input id="coupon_code" type="text" class="form-control @error('coupon_code') is-invalid @enderror" name="coupon_code" value="{{ old('coupon_code') }}" required>
                    
                    @error('coupon_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            `;

            $('#otherFormFields').removeClass('d-none');
            $('#otherFormFields').html(extrahtml);

            var btn = `
            <button type="submit" class="btn btn-primary"> Verify Using Coupon Code</button>
            `;

            $('#getPaymentBtn').html(btn);
        }

    </script>

    @if($esewa_pay_data)
        <script>
            function getEsewaPayment() 
            {
                var path = "{{Config::get('payment.esewa_pay_url')}}";
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", path);
                form.setAttribute("class", 'd-inline');

                @foreach($esewa_pay_data as $key=>$value) 
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "{{$key}}");
                    hiddenField.setAttribute("value", "{{$value}}");
                    form.appendChild(hiddenField);
                @endforeach

                var submit = document.createElement("input");
                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "submit");
                submit.setAttribute("value", "Pay With Esewa");
                submit.setAttribute("class", "btn btn-primary");
                form.appendChild(submit);

                $('#getPaymentBtn').html(form);
            }
        </script>
    @endif

    @if($fonepay_pay_data)
        <script>
            function getFonePayPayment() 
            {
                var path = "{{Config::get('payment.fonepay_pay_url')}}";
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", path);
                form.setAttribute("class", 'd-inline');

                @foreach($fonepay_pay_data as $key=>$value) 
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "{{$key}}");
                    hiddenField.setAttribute("value", "{{$value}}");
                    form.appendChild(hiddenField);
                @endforeach

                var submit = document.createElement("input");
                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "submit");
                submit.setAttribute("value", "Pay With FonePay");
                submit.setAttribute("class", "btn btn-primary");
                form.appendChild(submit);

                $('#getPaymentBtn').html(form);
            }
        </script>
    @endif

    @if($nepalpay_pay_data && count($nepalpay_pay_wallets))
        <script>
            function getNepalPayPayment()
            {
                $('#alert_message').parent().addClass('d-none');
                $('#alert_message').html('');

                var op =`<option value="" BankType="" BankUrl="" InstitutionName="" InstrumentCode="" InstrumentName="" InstrumentValue="" > Please Choose One Nepal Pay Wallet Options... </option>`;
                @foreach($nepalpay_pay_wallets as $row)
                op += `<option value="" BankType="{{$row['BankType']}}" BankUrl="{{$row['BankUrl']}}" InstitutionName="{{$row['InstitutionName']}}" InstrumentCode="{{$row['InstrumentCode']}}" InstrumentName="{{$row['InstrumentName']}}" InstrumentValue="{{$row['InstrumentValue']}}" > {{$row['InstitutionName']}} </option>`;
                @endforeach
                
                var extrahtml = `
                <div class="form-group row">
                    <label for="nepalPayWallet" class="col-md-4 col-form-label text-md-right">{{ __('Nepal Pay Wallet Type') }}</label>

                    <div class="col-md-8">
                        <select name="nepalPayWallet" id="nepalPayWallet" class="form-control @error('nepalPayWallet') is-invalid @enderror" value="{{ old('nepalPayWallet') }}" >
                            ${op}
                        </select>
                        @error('nepalPayWallet')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                `;

                $('#otherFormFields').removeClass('d-none');
                $('#otherFormFields').html(extrahtml);
                
            }

            $(document).on('change', '#nepalPayWallet', function() {
                var BankType = $(this).find(":selected").attr('BankType');
                var BankUrl = $(this).find(":selected").attr('BankUrl');
                var InstitutionName = $(this).find(":selected").attr('InstitutionName');
                var InstrumentCode = $(this).find(":selected").attr('InstrumentCode');
                var InstrumentName = $(this).find(":selected").attr('InstrumentName');
                var InstrumentValue = $(this).find(":selected").attr('InstrumentValue');
                var processId = "{{$nepalpay_pay_data->process_id}}";
                var transRem = 'PDF Booking Payment For {{ucwords($booking->book->title ?? "")}}' ; 
                var hash_data = '{{$booking->booking_price}}' + InstrumentCode + '{{$nepalpay_pay_data->merchantId}}' + '{{$nepalpay_pay_data->mercahntName}}' + '{{$booking->trans_id}}' + processId + transRem;
                var hash_sign = '{{ hash_hmac("sha512", "' + hash_data + '" , $nepalpay_pay_data->secret) }}';

                var path = "{{$nepalpay_pay_data->redirect_url}}";
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", path);
                form.setAttribute("class", 'd-inline');

                function appendInput(name, value) {
                    var input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", name);
                    input.setAttribute("value", value);
                    form.appendChild(input);
                }

                appendInput("MerchantId", "{{ $nepalpay_pay_data->merchantId }}");
                appendInput("MerchantName", "{{ $nepalpay_pay_data->mercahntName }}");
                appendInput("MerchantTxnId", "{{ $booking->trans_id }}");
                appendInput("Amount", "{{ $booking->booking_price }}");
                appendInput("ProcessId", processId);
                appendInput("InstrumentCode", InstrumentCode);
                appendInput("TransactionRemarks", transRem);
                appendInput("Signature", hash_sign);

                var submit = document.createElement("input");
                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "submit");
                submit.setAttribute("value", "Pay With "+InstitutionName);
                submit.setAttribute("class", "btn btn-primary");
                form.appendChild(submit);

                $('#getPaymentBtn').html(form);                

            });

        </script>
    @endif


@endsection
