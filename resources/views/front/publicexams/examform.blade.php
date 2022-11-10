@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Exam Hall</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="/public-exams">Exam Hall</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{$exam->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="about-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-5 shadow border-0" style="border-radius: 8px; padding: 10px 50px">
                        <div class="card-body enroll_form">
                            <form method="POST" action="/public-exams/{{$exam->slug}}/attempt">
                                @csrf
        
                                <div class="form-group row">
                                    <label for="name" class="col-md-6 col-form-label">{{ __('Name') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="email" class="col-md-6 col-form-label">{{ __('E-Mail Address') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="contact" class="col-md-6 col-form-label">{{ __('Contact Number') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="number">
        
                                        @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="courses" class="col-md-6 col-form-label">{{ __('Interested Courses ') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="courses" type="text" class="form-control @error('courses') is-invalid @enderror" name="courses" value="{{ old('courses') }}" required autocomplete="number">
        
                                        @error('courses')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row mt-2 justify-content-center">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary register-btn">
                                            {{ __('Start Exam') }}
                                        </button>
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