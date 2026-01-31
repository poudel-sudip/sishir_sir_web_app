@extends('admin.layouts.app')
@section('admin-title')
    Edit Text Puzzle Question
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Text Puzzle Question</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/play-puzzle/text') }}">Text Puzzles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit  </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Text Puzzle Question</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/play-puzzle/text/{{$question->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row align-items-center">
                                <label for="question" class="col-md-4 col-form-label "><strong>{{ __('Question') }}</strong></label>

                                <div class="col-md-8">
                                    <input id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') ?? $question->question }}" required autocomplete="question" autofocus>

                                    @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="answer" class="col-md-4 col-form-label"><strong>{{ __('Answer') }}</strong></label>

                                <div class="col-md-8">
                                    <input id="answer" type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" value="{{ old('answer') ?? $question->answer }}"  required>

                                    @error('answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                               
                            <div class="form-group row align-items-center">
                                <label for="rationale" class="col-md-4 col-form-label"><strong>{{ __('Rationale / Justification') }}</strong></label>

                                <div class="col-md-8">
                                    <textarea id="rationale" class="form-control summernote @error('rationale') is-invalid @enderror" name="rationale" >{{ old('rationale') ?? $question->rationale }}</textarea>

                                    @error('rationale')
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
