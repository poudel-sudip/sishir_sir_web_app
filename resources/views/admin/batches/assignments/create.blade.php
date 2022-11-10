@extends('admin.layouts.app')
@section('admin-title')
    Create Assignment Question
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Question </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
                <li class="breadcrumb-item"><a href="/admin/batches/{{$batch->id}}/assignments">Assignments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">{{$batch->course->name.' : '.$batch->name}}</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/batches/{{$batch->id}}/assignments" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label ">{{ __('Batch') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ $batch->course->name.'  '.$batch->name }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="question" class="col-md-4 col-form-label">{{ __('Exam Question') }}</label>

                                <div class="col-md-8">
                                    <input id="question" type="text" class="form-control" name="question" value="{{ old('question') }}" required>

                                    @error('question')
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
