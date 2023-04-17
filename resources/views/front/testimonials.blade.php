@extends('front.layouts.app')
@section('page_title', 'All Testimonials')
@section('content')
<style>
    .single-blog p, .single-blog .blog-description span {
    overflow: visible !important;
    text-overflow: unset !important;
    -webkit-line-clamp: unset !important;
}
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>All Testimonials</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-container mt-5">
            
            <div class="row">
                @foreach($testimonials as $testimonial)
                    <div class="col-md-4">
                        <div class="border shadow rounded p-3">
                            <div class="profile-image">
                                <img src="/storage/{{$testimonial->image}}" class="img img-fluid" alt="" style="max-height:200px !important;">
                            </div>
                            <div class="profile-details">
                                <h5>{{$testimonial->name}}</h5>
                                <p>{{$testimonial->role}}</p>
                            </div>
                            <div class="review">
                                <p>{{$testimonial->message}}</p>
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>

    <hr>

    <section class="contact-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-5">
                        <div class="card-header">
                            Add Testimonial
                        </div>
                        <div class="card-body enroll_form">
                            <form action="/testimonials/add" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Your Full Name" required >
                
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
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Your Email Address" required >
                
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="testimonial_as" class="col-md-4 col-form-label text-md-right">{{ __('Testimonial As') }}</label>
                
                                    <div class="col-md-8">
                                        <select name="testimonial_as" id="testimonial_as" class="form-control @error('testimonial_as') is-invalid @enderror" required>
                                            <option value="Visitor">Visitor</option>
                                            <option value="Teacher">Teacher</option>
                                            <option value="Student">Student</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        @error('testimonial_as')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>
                
                                    <div class="col-md-8">
                                        <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" required>
                
                                        @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="message" class="col-md-4 col-form-label text-md-right">{{ __('Message') }}</label>
                
                                    <div class="col-md-8">
                                        <textarea name="message" rows="2" class="form-control @error('message') is-invalid @enderror" placeholder="Write your message" required></textarea>
                
                                        @error('message')
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
