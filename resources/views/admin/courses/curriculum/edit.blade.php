@extends('admin.layouts.app')
@section('admin-title')
    Edit Course Batch Curriculum
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Course Batch Curriculum </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/curriculum') }}">Curriculum</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Course Batch Curriculum</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/curriculum/{{$curriculum->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="course" class="col-md-3 col-form-label">{{ __('Course') }}</label>

                                <div class="col-md-9">
                                    <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') ?? $course->name }}" required autocomplete="course" readonly>

                                    @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="batch" class="col-md-3 col-form-label">{{ __('Batch') }}</label>

                                <div class="col-md-9">
                                    <input id="batch" type="text" class="form-control @error('batch') is-invalid @enderror" name="batch" value="{{ old('batch') ?? $batch->name }}" required autocomplete="batch" readonly>

                                    @error('batch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="curriculum_title" class="col-md-3 col-form-label">{{ __('Curriculum Title') }}</label>

                                <div class="col-md-9">
                                    <input id="curriculum_title" type="text" class="form-control @error('curriculum_title') is-invalid @enderror" name="curriculum_title" value="{{ old('curriculum_title') ?? $curriculum->title }}" required autocomplete="curriculum_title" autofocus>

                                    @error('curriculum_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="curriculum_file" class="col-md-3 col-form-label">{{ __('Curriculum File') }}</label>
                                <div class="col-md-9">
                                    <input id="curriculum_file" type="file" class="form-control @error('curriculum_file') is-invalid @enderror" name="curriculum_file" value="{{ old('curriculum_file') ?? $curriculum->pdf_file }}"  accept=".pdf">
                                    <input type="hidden" name="old_curriculum_file" value="{{$curriculum->pdf_file}}">
                                    
                                    @error('curriculum_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="is_heading" class="col-md-3 col-form-label">{{ __('Is Main Heading') }}</label>

                                <div class="col-md-9 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_heading" id="is_heading_1" value="1" @if($curriculum->is_heading) checked @endif /> Yes </label>
                                        </div>
                                      </div>
                                      <div class="col-sm-5">
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_heading" id="is_heading_2" value="0" @if(!$curriculum->is_heading) checked @endif /> No </label>
                                        </div>
                                      </div>
                                    @error('is_heading')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Description') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" autocomplete="description" >{!! old('description') ?? $curriculum->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                                                     
                        
                            <div class="form-group row">
                                <label for="status" class="col-md-3 col-form-label">{{ __('Curriculum Status') }}</label>

                                <div class="col-md-9">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                        <option value="0" @if(!$curriculum->status) selected @endif >Inactive</option>
                                        <option value="1" @if($curriculum->status) selected @endif>Active</option>
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
