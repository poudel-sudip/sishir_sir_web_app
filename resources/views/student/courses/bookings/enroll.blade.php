@extends('student.layouts.app')
@section('student-title')
    Enroll Course Batch
@endsection
@section('student-title-icon')
    <i class="far fa-calendar-check"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Enroll a Course Batch') }}</div>

                    <div class="card-body enroll_form">

                        <form method="POST" action="/student/course-bookings" enctype="multipart/form-data" id="verifyCourseForm">
                            @if (session('alreadybooked'))
                                <div class="alert alert-danger">
                                    {{ session('alreadybooked') }}
                                </div>
                            @endif
                           
                            @csrf
                            <div class="form-group row">
                                <label for="batch_id" class="col-md-4 col-form-label text-md-right">{{ __('Course Batch') }}</label>

                                <div class="col-md-8">
                                    <select name="batch_id" id="batch_id" class="enroll-form-control @error('batch_id') is-invalid @enderror" value="{{ old('batch_id') }}" autofocus required>
                                        <option value="">Select a Course Batch</option>
                                        @foreach($batches as $batch)
                                            <option value="{{$batch->id}}"> {{$batch->name}} @ Rs. {{$batch->fee - $batch->discount}} </option>
                                        @endforeach
                                    </select>
                                    @error('batch_id')
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
