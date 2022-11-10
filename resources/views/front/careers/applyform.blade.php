@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Vaccancy Application Form</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/careers') }}">Careers</a></li>
                        <li class="breadcrumb-item"><a href="/careers/{{$vaccancy->slug}}">Vaccancy</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Apply</li>
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
                            {{ucwords($vaccancy->title)}}
                        </div>
                        <div class="card-body enroll_form">
                            <form action="/careers/apply/{{$vaccancy->slug}}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if (Session::has('successMessage'))
                                <div class="form-group row">
                                    <div class="alert alert-success">{!! Session::get('successMessage') !!}</div>
                                </div>
                                @endif
                                
                                <div class="form-group row">
                                    <label for="post_name" class="col-md-4 col-form-label text-md-right">{{ __('Applied Post') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="post_name" type="text" class="form-control @error('post_name') is-invalid @enderror" name="post_name" value="{{old('post_name')}}" placeholder="Applied Post" required>
                
                                        @error('post_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="applicant_name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="applicant_name" type="text" class="form-control @error('applicant_name') is-invalid @enderror" name="applicant_name" value="{{old('applicant_name')}}" placeholder="Full Name" required>
                
                                        @error('applicant_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                    
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Your Email Address" required>
                
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
                                        <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" placeholder="Your Contact Number" required>
                
                                        @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                
                                <div class="form-group row">
                                    <label for="qualification" class="col-md-4 col-form-label text-md-right">{{ __('Academic Qualification') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" placeholder="Your Qualification" required>
                
                                        @error('qualification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="photo" class="col-md-4 col-form-label">{{ __('PP Size Photo') }}</label>
                                    <div class="col-md-8">
                                        <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value="{{ old('photo') }}" >
    
                                        @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="applicant_cv" class="col-md-4 col-form-label">Your CV <br> <small>(CV File in PDF Format)</small> </label>
                                    <div class="col-md-8">
                                        <input id="applicant_cv" type="file" class="form-control @error('applicant_cv') is-invalid @enderror" name="applicant_cv" value="{{ old('applicant_cv') }}" required >
    
                                        @error('applicant_cv')
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
            </div>
        </div>
    </section>


@endsection