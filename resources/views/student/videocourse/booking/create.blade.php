@extends('student.layouts.app')
@section('student-title')
    Enroll Video Course
@endsection
@section('student-title-icon')
    <i class="fas fa-calendar-check"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Book Video Course') }}</div>

                    <div class="card-body enroll_form">

                        <form method="POST" action="/student/video-course" enctype="multipart/form-data" id="verifyCourseForm">
                            @if (session('alreadybooked'))
                                <div class="alert alert-danger">
                                    {{ session('alreadybooked') }}
                                </div>
                            @endif
                           
                            @csrf
                            <div class="form-group row">
                                <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Video Course') }}</label>

                                <div class="col-md-8">
                                    <select name="course" id="course" class="enroll-form-control @error('course') is-invalid @enderror" value="{{ old('course') }}" autofocus required>
                                        <option value="">Select a Video Course...</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}"> {{$course->name}} @ Rs. {{$course->fee - $course->discount}} </option>
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
                                <label for="remarks" class="col-md-4 col-form-label text-md-right">{{ __('Remarks') }}</label>

                                <div class="col-md-8">
                                    <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" >

                                    @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection
