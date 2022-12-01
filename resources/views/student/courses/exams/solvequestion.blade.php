@extends('student.layouts.app')
@section('student-title')
    Solve Exam Question
@endsection
@section('student-title-icon')
    <i class="fas fa-pen-nib"></i>
@endsection

@section('content')

    <div class="student-content-wrapper student-enroll-section">
        <form class="form-sample" method="POST" action="/student/{{$batch->id}}/written-exams/{{$exam->id}}" enctype="multipart/form-data">
            @csrf

            <h6 class="mb-4">{{$batch->name}}</h6>

            <div class="form-group row">
                <label for="myAnswer" class="col-12 col-form-label h5"> {{$exam->question}} </label>

                <div class="col-12">
                    <textarea id="myAnswer" class="form-control summernote @error('answer') is-invalid @enderror" name="answer" required autocomplete="answer" ></textarea>
                    @error('answer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="col-md-6 offset-md-5">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    
    
@endsection
