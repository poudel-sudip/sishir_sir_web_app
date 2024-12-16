@extends('moderator.layouts.app')
@section('admin-title')
    Edit Open Exam
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Open Exam: {{$exam->name}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/moderator/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/moderator/open-exams') }}">Open Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Exam </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Open Exam: {{$exam->name}}</div>
                    <div class="card-body">
                        <form method="POST" action="/moderator/open-exams/{{$exam->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="category" class="col-md-3 col-form-label">{{ __('Exam Category') }}</label>

                                <div class="col-md-9">
                                    <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') ?? ucwords($exam->exam->category->title ?? '') }}" required autocomplete="category" readonly>

                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exam" class="col-md-3 col-form-label">{{ __('Exam Name') }}</label>

                                <div class="col-md-9">
                                    <input id="exam" type="text" class="form-control @error('exam') is-invalid @enderror" name="exam" value="{{ old('exam') ?? $exam->name }}" required autocomplete="name" readonly>

                                    @error('exam')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="show_answer" class="col-md-3 col-form-label">{{ __('Show Answer') }}</label>

                                <div class="col-md-9 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="show_answer_1" type="radio" class="form-check-input" name="show_answer" value="1" @if($exam->show_answer) checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="show_answer_2" type="radio" class="form-check-input" name="show_answer" value="0" @if(!$exam->show_answer) checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('show_answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="thumbnail" class="col-md-3 col-form-label">{{ __('Thumbnail Image') }}</label>
                                <div class="col-md-2 pt-2">
                                    <img src="/storage/{{$exam->image}}" height="40">
                                </div>
                                <div class="col-md-7">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}" >
                                    <input type="hidden" name="old_thumbnail" value="{{$exam->image}}">
                                    @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-3 col-form-label">{{ __('Result Status') }}</label>

                                <div class="col-md-9">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="{{$exam->result_status}}">{{$exam->result_status}}</option>
                                        <option value="">---------</option>
                                        <option value="Unpublished">Unpublished</option>
                                        <option value="Published">Published</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-3">
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
