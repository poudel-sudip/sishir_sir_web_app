@extends('admin.layouts.app')
@section('admin-title')
    Add Question
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add New Question</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exams') }}">Exams</a></li>
                <li class="breadcrumb-item"><a href="/admin/exams/{{$exam->id}}/questions">Questions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Question </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Question</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/exams/{{$exam->id}}/questions" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            
                            <div class="form-group row align-items-center">
                                <label for="question" class="col-md-4 col-form-label "> <strong>{{ __('Question') }}</strong> </label>

                                <div class="col-md-8">
                                    <!-- <input id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required autocomplete="question" autofocus> -->
                                    <textarea id="question" class="form-control summernote @error('question') is-invalid @enderror" name="question" required >{{ old('question') }}</textarea>

                                    @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="optionA" class="col-md-4 col-form-label"><strong>{{ __('Option A') }}</strong></label>

                                <div class="col-md-8">
                                    {{-- <input id="optionA" type="text" class="form-control @error('optionA') is-invalid @enderror" name="optionA" value="{{ old('optionA') }}"  > --}}
                                    <textarea id="optionA" class="form-control summernote @error('optionA') is-invalid @enderror" name="optionA" required >{{ old('optionA') }}</textarea>

                                    @error('optionA')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="optionB" class="col-md-4 col-form-label "><strong>{{ __('Option B') }}</strong></label>

                                <div class="col-md-8">
                                    {{-- <input id="optionB" type="text" class="form-control @error('optionB') is-invalid @enderror" name="optionB" value="{{ old('optionB') }}"  > --}}
                                    <textarea id="optionB" class="form-control summernote @error('optionB') is-invalid @enderror" name="optionB" required >{{ old('optionB') }}</textarea>

                                    @error('optionB')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="optionC" class="col-md-4 col-form-label "><strong>{{ __('Option C') }}</strong></label>

                                <div class="col-md-8">
                                    {{-- <input id="optionC" type="text" class="form-control @error('optionC') is-invalid @enderror" name="optionC" value="{{ old('optionC') }}"  > --}}
                                    <textarea id="optionC" class="form-control summernote @error('optionC') is-invalid @enderror" name="optionC" required >{{ old('optionC') }}</textarea>

                                    @error('optionC')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="optionD" class="col-md-4 col-form-label"><strong>{{ __('Option D') }}</strong></label>

                                <div class="col-md-8">
                                    {{-- <input id="optionD" type="text" class="form-control @error('optionD') is-invalid @enderror" name="optionD" value="{{ old('optionD') }}"  > --}}
                                    <textarea id="optionD" class="form-control summernote @error('optionD') is-invalid @enderror" name="optionD" required >{{ old('optionD') }}</textarea>

                                    @error('optionD')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="optionCorrect" class="col-md-4 col-form-label"><strong>{{ __('Correct Answer') }}</strong></label>

                                <div class="col-md-8">
                                    <input id="optionCorrect" type="text" class="form-control @error('optionCorrect') is-invalid @enderror" name="optionCorrect" value="{{ old('optionCorrect') }}"  >

                                    @error('optionCorrect')
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
        </div>
    </div>
@endsection
