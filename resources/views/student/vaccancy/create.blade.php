@extends('student.layouts.app')
@section('student-title')
    Post New Vaccancy
@endsection

@section('student-title-icon')
    <i class="fas fa-graduation-cap "></i>
@endsection

@section('content')

    <section class="about-page">
        <div class="container-fluid p-5">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card mb-5 shadow border border-primary border-2" style="border-radius: 8px; padding: 10px 50px">
                        <div class="card-body enroll_form">
                            <form method="POST" action="/student/vaccancies" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group text-center">
                                  <div class="h3" style="color:#005cb3;">Add New Vaccancy Post</div>  
                                </div>
                                <hr style="margin-top:0;height:2px;background:#0084ff;opacity:1;">
                                
                                <div class="form-group row">
                                    <label for="title" class="col-md-6 col-form-label">{{ __('Vaccancy Title') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
        
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="author" class="col-md-6 col-form-label">{{ __('Author') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? auth()->user()->name ?? '' }}" required autocomplete="author">
        
                                        @error('author')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label for="pdf_file" class="col-md-6 col-form-label">{{ __('Vaccancy PDF File') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file') }}" accept=".pdf">
        
                                        @error('pdf_file')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="thumbnail" class="col-md-6 col-form-label">{{ __('Vaccancy Thumbnail') }}</label>
        
                                    <div class="col-md-12">
                                        <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}" accept="image/png, image/jpeg" required>
        
                                        @error('thumbnail')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-6 col-form-label">{{ __('Vaccancy Description ') }}</label>
        
                                    <div class="col-md-12">
                                        <textarea id="description"  class="summernote form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required >{{ old('description') }}</textarea>
        
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="form-group row mt-2 justify-content-center">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary register-btn">
                                            {{ __('Submit Vaccancy Post') }}
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

  
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>    
        $('.summernote').summernote({
            height: 200,
        });
    </script>

@endsection

