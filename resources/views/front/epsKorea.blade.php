@extends('front.layouts.app')
@section('title')
    EPS Registration
@endsection

@section('content')
<style>
    .eps-image-validation{
        font-size: 14px;
        color: #0d6efd;
        font-style: italic;
    }
    #subsector2{
        display: none;
    }
    .photo-note{
        border: 1px solid #0d6efd;
        padding: 5px 10px;
        border-radius: 4px;
        text-align: justify;
        margin-top: 1em;
        background: #ffffff;
    }

    .manual-booking-scan {
        padding: 15px 15px 20px;
        background: #ffffff;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    }
    .manual-booking-scan strong{
        color: #3490dc;
    }
    .manual-booking-scan .mannual-note{
        color: #f30808;
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
        font-weight: 500;
    }
    .manual-payment{
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 10px;
        position: relative;
        text-align: center;
        border: 3px ridge #90b7d6;
    }
    .manual-booking-scan .manual-bank{
        justify-self: center;
        border-right: 3px ridge #90b7d6;
        position: relative;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .manual-booking-scan .manual-bank .logo-img{
        width: 100%;
    }
    .manual-booking-scan .manual-esewa{
        justify-self: center;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .manual-booking-scan .manual-esewa .logo-img{
        width: 40%;
        height: 40px;
    }
    .manual-payment .manual-qr{
        width: 48%; 
        place-self: center;
    }
    .manual-booking-scan .manual-footer{
        text-align: center;
    }
    .manual-footer h6{
        margin-top: 10px;
    }
    @media(max-width:767px){
        .manual-payment{
            grid-template-columns: 1fr !important;
        }
        .manual-booking-scan .manual-bank{
            border-right: 0 !important;
        }
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>EPS Registration</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">EPS Registration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-7">
                <div class="eps-registration enroll_form card">
                    <div class="card-header"><h5>EPS-Korea Registration Form</h5></div>
                    <div class="card-body">
                        @if (Session::has('success'))
                        <p class="alert alert-success alert-block">{{ session('success') }}</p>
                    @endif
                    <form method="POST" action="/eps-registration" enctype="multipart/form-data">
                        @csrf
        
                        <div class="form-group row">
                            <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>
        
                            <div class="col-md-8">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" placeholder="Your Full Name" >
        
                                @error('fname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobileNo" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Number') }}</label>
        
                            <div class="col-md-8">
                                <input id="mobileNo" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" placeholder="Your Contact Number" >
        
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
        
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Your Validate Email Address" >
        
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="Sector" class="col-md-4 col-form-label text-md-right">{{ __('Sector') }}</label>
        
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sector" class="@error('sector') is-invalid @enderror" id="sector1" value="Manufacture" checked>
                                    <label class="form-check-label" for="sector1">Manufacturing Sector</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sector" class="@error('sector') is-invalid @enderror" id="sector2" value="Agriculture">
                                    <label class="form-check-label" for="sector2">Agricultural Sector</label>
                                  </div>
                            </div>
                                @error('sector')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <label for="subsector" class="col-md-4 col-form-label text-md-right">{{ __('Sub Sector') }}</label>
        
                            <div class="col-md-8">
                                <select class="form-select" aria-label="Default select example" class="form-control @error('subsector') is-invalid @enderror" name="subsector" id="subsector1">
                                    <option selected="true" disabled="disabled">Select Sub Sector</option>
                                    <option value="Assemble">Assemble</option>
                                    <option value="Measures">Measures</option>
                                    <option value="Join">Join</option>
                                  </select>

                                  <select class="form-select" aria-label="Default select example" class="form-control @error('subsector') is-invalid @enderror" name="subsector" id="subsector2">
                                    <option selected="true" disabled="disabled">Select Sub Sector</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Livestock">Livestock</option>
                                  </select>
        
                                @error('subsector')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>
                            
                            <div class="col-md-8">
                                <span class="eps-image-validation">Please upload MRP-size color photo with white background, upper chest</span>
                                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo">
        
                                @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="passport" class="col-md-4 col-form-label text-md-right">{{ __('Passport') }}</label>
        
                            <div class="col-md-8">
                                <span class="eps-image-validation">Please upload color image of bio page</span>
                                <input id="passport" type="file" class="form-control @error('passport') is-invalid @enderror" name="passport">
        
                                @error('passport')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="payment_slip" class="col-md-4 col-form-label text-md-right">{{ __('Payment 
                            Slip') }}</label>
        
                            <div class="col-md-8">
                                <input id="payment_slip" type="file" class="form-control @error('payment_slip') is-invalid @enderror" name="payment_slip">
        
                                @error('payment_slip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="remarks" class="col-md-4 col-form-label text-md-right">{{ __('Remarks') }}</label>
        
                            <div class="col-md-8">
                                <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" placeholder="Remarks" >
        
                                @error('remarks')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}
        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="photo-note">
                        <strong class="text-danger">Note:</strong>
                        1) Must be validated or original email address and mobile number, 2) For Photo <u>(३ महिना यता खीचेको दुवै कान देखिने, MRP Size Photo with white background, Upper Chest देखिने, Color image and not wearing white clothes)</u> and 3) For Passport <u>(राहदानीको फोटो भएको पेज (bio page) को रंगिन (colour) स्क्यान (scan) गरेको image)</u>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="manual-booking-scan">
                    <p class="mannual-note">
                        Note: Only Etutorclass' official payment method is valid for payment verify.
                    </p>
                    <div class="manual-payment">
                        <div class="manual-bank">
                            <img class="logo-img" src="{{ asset('images/mannual/fonepay.png') }}" alt="">
                        </div>
                        <div class="manual-esewa">
                            <div><img class="logo-img" src="{{ asset('images/mannual/esewa-logo.png') }}" alt=""></div>
                            <div><img class="manual-qr" src="{{ asset('images/mannual/esewa.png') }}" alt="etutor esewa QR"></div>
                            <div>Esewa QR Code</div>
                            <div>Name: <strong>ETUTOR CLASS</strong></div>
                            <div>ID: <strong>9857084809</strong></div>
                        </div>
                    </div>
                    <div class="manual-footer">
                        <h6>For Payment Verify <strong> (Time: 10:00 AM to 06:00 PM)</strong></h6>
                        <div>Call to Account Section: <strong>9857084809</strong></div>
                    </div>
                </div>

            </div>
        </div>
        
    </div>

<script type ="text/javascript">
    $(function() {
    $("input[name='sector']").click(function() {
      if ($("#sector2").is(":checked")) {
        $("#subsector2").show();
        $("#subsector1").hide();
      } 
      else if ($("#sector1").is(":checked")) {
        $("#subsector1").show();
        $("#subsector2").hide();
      }
      else {
        $("#subsector2").hide();
      }
      });
  });
</script>

@endsection

