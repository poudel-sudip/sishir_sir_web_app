@extends('front.layouts.app')
@section('title')
  Course Enquiry
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Enquiry Form for {{$course->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/enquiry') }}">Enquiry</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$course->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-5">
                        <div class="card-header">
                            Enquiry Form of {{$course->name}}
                        </div>
                        <div class="card-body enroll_form">
                            <form action="/leads/enquiries/add" method="post" enctype="multipart/form-data">
                                @csrf

                                @if (Session::has('successMessage'))
                                <div class="form-group row">
                                    <div class="alert alert-success">{!! Session::get('successMessage') !!}</div>
                                </div>
                                @endif
                                                               
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Your Full Name" >
                
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
                                    <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" placeholder="Your Contact Number" >
                
                                        @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="provience" class="col-md-4 col-form-label text-md-right">{{ __('Provience') }}</label>
            
                                    <div class="col-md-8">
                                        <select name="provience" id="provience" class="enroll-form-control @error('provience') is-invalid @enderror" onchange="getCities()">
                                            <option value="">Select your Provience</option>
                                            @foreach($proviences as $pro)
                                                <option value="{{$pro->name}}">{{$pro->name}}</option>
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
                                        <select name="district" id="district" class="enroll-form-control @error('district') is-invalid @enderror">
                                            <option value="">Select an District</option>
                                        </select>
                                        @error('course')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                

                                <div class="form-group row">
                                    <label for="message" class="col-md-4 col-form-label text-md-right">{{ __('Message') }}</label>
                
                                    <div class="col-md-8">
                                        <textarea name="message" rows="2" class="form-control @error('message') is-invalid @enderror" placeholder="Write your message"></textarea>
                
                                        @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <input id="course" type="hidden" name="course" value="{{$course->id}}" >
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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