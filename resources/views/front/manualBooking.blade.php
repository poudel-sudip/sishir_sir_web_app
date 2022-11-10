@extends('front.layouts.app')
@section('title')
    Manual Booking
@endsection

@section('content')
<style>
    .manual-booking-container{
        display: grid;
        grid-template-columns: 1.2fr 2fr;
        grid-column-gap: 10px;
    }
    .manual-booking-form{
        background: #ffffff;
        padding: 15px 15px 20px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    }
    .manual-booking-form h5{
        font-size: 17px;
        color: #3490dc;
        font-weight: 600;
        padding-bottom: 5px;
        border-bottom: 3px ridge #90b7d6;
        width: 200px;
        padding-left: 8px;
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
        width: 40%;
        height: 50px;
    }
    .manual-booking-scan .manual-esewa{
        justify-self: center;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .manual-booking-scan .manual-esewa .logo-img{
        width: 40%;
        height: 50px;
    }
    .manual-payment .manual-qr{
        width: 60%; 
        place-self: center;
    }
    .manual-booking-scan .manual-footer{
        text-align: center;
    }
    .manual-footer h6{
        margin-top: 10px;
    }
    @media(max-width:767px){
        .manual-booking-container{
            grid-template-columns: 1fr !important;
        }
        .manual-booking-form{
            margin-bottom: 10px;
        }
        .manual-payment{
            grid-template-columns: 1fr !important;
        }
        .manual-booking-scan .manual-bank{
            border-right: 0 !important;
        }
    }
    
</style>
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Manual Booking</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Manual Booking</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="manual-booking-container">
            <div class="manual-booking-form enroll_form">
                <h5>Manual Booking Form</h5>
                @if (Session::has('success'))
                    <p class="alert alert-success alert-block">{{ session('success') }}</p>
                @endif
                <form method="POST" action="/manual-booking" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="course_name" class="col-md-4 col-form-label text-md-right">{{ __('Course Name') }}</label>

                        <div class="col-md-8">
                            <select name="course" id="course_name" class="enroll-form-control @error('course') is-invalid @enderror">
                                <option value="">Select a Course</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" slug="{{$course->slug}}"> {{$course->name}} </option>
                                @endforeach
                            </select>
                            @error('course')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                        <div class="col-md-8">
                            <input id="fname" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Your Full Name" >

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Your Email Address" >

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mobileNo" class="col-md-4 col-form-label text-md-right">{{ __('Contact No.') }}</label>

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
                        <label for="provience" class="col-md-4 col-form-label text-md-right">{{ __('Provience') }}</label>

                        <div class="col-md-8">
                            <select name="provience" id="provience" class="form-control @error('provience') is-invalid @enderror" required onchange="getCities()">
                                <option value="">Choose a Provience...</option>
                                @foreach($proviences as $pro)
                                <option value="{{ucwords($pro->name)}}">{{ucwords($pro->name)}}</option>
                                @endforeach
                            </select>
                            @error('provience')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="district" class="col-md-4 col-form-label text-md-right">{{ __('District') }}</label>

                        <div class="col-md-8">
                            <select name="district" id="district" class="form-control @error('district') is-invalid @enderror">
                            <option value="">Choose District...</option>
                            </select>
                            @error('district')
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
                    <div class="form-group row">
                        <label for="remarks" class="col-md-4 col-form-label text-md-right">{{ __('Remarks') }}</label>

                        <div class="col-md-8">
                            <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" placeholder="Remarks" >

                            @error('remarks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="manual-booking-scan">
                <p class="mannual-note">
                    Note: Only Etutorclass' official payment method is valid for payment verify.
                </p>
                <div class="manual-payment">
                    <div class="manual-bank">
                        <img class="logo-img" src="{{ asset('images/mannual/megha-logo.png') }}" alt="">
                        <img class="manual-qr" src="{{ asset('images/mannual/megha.png') }}" alt="etutor megha bank QR">
                        <div><strong>Megha Bank Nepal Limited, Butwal Branch</strong></div>
                        <div>Account Name: <strong>ETUTOR CLASS</strong></div>
                        <div>Account Number: <strong>0410011447432</strong></div>
                    </div>
                    <div class="manual-esewa">
                        <img class="logo-img" src="{{ asset('images/mannual/esewa-logo.png') }}" alt="">
                        <img class="manual-qr" src="{{ asset('images/mannual/esewa.png') }}" alt="etutor esewa QR">
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
        {{-- <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Manual Booking') }}</div>

                    <div class="card-body enroll_form">
                        @if (Session::has('success'))
                            <p class="alert alert-success alert-block">{{ session('success') }}</p>
                        @endif
                        <form method="POST" action="/manual-booking" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label text-md-right">{{ __('Course Name') }}</label>

                                <div class="col-md-8">
                                    <select name="course" id="course_name" class="enroll-form-control @error('course') is-invalid @enderror">
                                        <option value="">Select a Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}" slug="{{$course->slug}}"> {{$course->name}} </option>
                                        @endforeach
                                    </select>
                                    @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                                <div class="col-md-8">
                                    <input id="fname" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="your full name" >

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="your email" >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobileNo" class="col-md-4 col-form-label text-md-right">{{ __('Contact No.') }}</label>

                                <div class="col-md-8">
                                    <input id="mobileNo" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" placeholder="your contact number" >

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="col-md-4 col-form-label text-md-right">{{ __('District') }}</label>

                                <div class="col-md-8">
                                    <input id="district" type="text" class="form-control @error('district') is-invalid @enderror" name="district" placeholder="your district" >

                                    @error('district')
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
                            <div class="form-group row">
                                <label for="remarks" class="col-md-4 col-form-label text-md-right">{{ __('Remarks') }}</label>

                                <div class="col-md-8">
                                    <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" placeholder="Remarks" >

                                    @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
        </div> --}}
    </div>

    <script>
        var proviences = {
            @foreach($proviences as $pro)
            '{{$pro->name}}' : [
                @foreach($pro->cities as $city)
                "{{$city->name}}",
                @endforeach
            ],
            @endforeach
        };

        function getCities()
        {
            var provience = $('#provience').find(":selected").val();
            $("#district").html("");
            if(provience)
            {
                var cities = proviences[provience];
                var op='';
                cities.forEach((city) => {
                    op += '<option value="' + city + '">' + city + '</option>';
                });
                // console.log(op);
                $("#district").append(op);
            }
        }
    </script>

@endsection
