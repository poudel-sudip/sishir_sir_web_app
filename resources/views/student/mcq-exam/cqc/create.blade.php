@extends('student.layouts.app')
@section('student-title')
    MCQ Exam CQCs
@endsection

@section('student-title-icon')
    <i class="fas fa-stopwatch "></i>
@endsection

@section('content')

    <section class="about-page">
        <div class="container-fluid pt-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card mb-5 shadow border border-primary border-2" style="border-radius: 8px;">
                        <div class="card-body">
                            <div class="text-center mb-2 h3">{{$exam->name}}</div>
                                                        
                            <form method="POST" action="/student/mcq-exams/{{$exam->id}}/cqcs" enctype="multipart/form-data">
                                @csrf
                
                                <div class="form-group row">
                                    <label for="title" class="col-md-12 col-form-labe">{{ __('Title') }}</label>

                                    <div class="col-md-12">
                                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"  name="title" value="{{ old('title') ?? $cqc->title ?? '' }}" required>

                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="description" class="col-md-12 col-form-label">{{ __('Content') }}</label>

                                    <div class="col-md-12">
                                        <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description"  autocomplete="description">{{old('description') ?? $cqc->description ?? ''}}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            
                                <div class="form-group row mt-3">
                                    <div class="col-md-6 offset-md-5">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
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

