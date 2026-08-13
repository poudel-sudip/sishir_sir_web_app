@extends('admin.layouts.app')
@section('admin-title')
    Add Exam CQC Content
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Exam CQC</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exam-category') }}">Exam Categories</a></li>
                <li class="breadcrumb-item"><a href="/admin/exam-category/{{$exam->category->id ?? ''}}/exams">Exams</a></li>
                <li class="breadcrumb-item"><a href="/admin/exams/{{$exam->id}}/cqcs">CQCs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Exam CQC Content</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/exams/{{$exam->id}}/cqcs" enctype="multipart/form-data">
                            @csrf
             
                            <div class="form-group row">
                                <label for="title" class="col-md-12 col-form-labe">{{ __('Title') }}</label>

                                <div class="col-md-12">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"  name="title" value="{{ old('title') }}" required>

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
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description"  autocomplete="description">{{old('description')}}</textarea>

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
@endsection
