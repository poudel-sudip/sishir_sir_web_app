@extends('student.layouts.app')
@section('student-title')
    Enroll Exams
@endsection
@section('student-title-icon')
    <i class="fas fa-calendar-check"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Book an Exam') }}</div>

                    <div class="card-body enroll_form">

                        <form method="POST" action="/student/exam-hall" enctype="multipart/form-data" id="verifyCourseForm">
                            @if (session('alreadybooked'))
                                <div class="alert alert-danger">
                                    {{ session('alreadybooked') }}
                                </div>
                            @endif
                           
                            @csrf
                            <div class="form-group row">
                                <label for="exam_category" class="col-md-4 col-form-label text-md-right">{{ __('Exam Category') }}</label>

                                <div class="col-md-8">
                                    <select name="exam_category" id="exam_category" class="enroll-form-control @error('exam_category') is-invalid @enderror" value="{{ old('exam_category') }}" autofocus required>
                                        <option value="">Select a Exam</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}"> {{$cat->title}} of {{$cat->category_exams->count()}} sets @ Rs. {{$cat->price - $cat->discount}} </option>
                                        @endforeach
                                    </select>
                                    @error('exam_category')
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
