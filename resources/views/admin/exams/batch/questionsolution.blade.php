@extends('admin.layouts.app')
@section('admin-title')
    Solve Exam Question
@endsection

@section('content')

    <div class="container student-enroll-section content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="h4 text-center">{{$batch->course->name.' : '.$batch->name}}</div>
                <div class="h6 text-right">By: {{$solution->user->name}}</div>
                <div class="h6 text-right">Remarks: {{$solution->remarks}}</div>
            </div>
        </div>
       <div class="row">
           <div class="col-md-12">
            <div class="h5">{{$exam->question}}</div>
            <b>Answer:</b><br>
            <div class="">
                {!! $solution->answer !!}
            </div>
            <hr>
            <form action="/admin/batches/{{$batch->id}}/written-exams/{{$exam->id}}/solutions/{{$solution->id}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="remarks" class="col-md-4 col-form-label">{{ __('Add Remarks') }}</label>
    
                    <div class="col-md-8">
                        <input type="remarks" class="form-control @error('remarks') is-invalid @enderror" name="remarks" required>
                        @error('remarks')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
    
    
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>
           </div>
       </div>
        

    </div>

@endsection
