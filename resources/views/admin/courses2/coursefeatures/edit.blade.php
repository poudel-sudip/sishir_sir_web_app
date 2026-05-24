@extends('admin.layouts.app')
@section('admin-title')
    Edit Feature
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Feature</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/courses/{{$feature->course_id}}/features">Features</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div> 
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit {{$feature->course->name}} Features </div>

                    <div class="card-body">
                        <form method="POST" action="/admin/courses/{{$feature->course_id}}/features/{{$feature->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="course_id" value="{{$feature->course_id}}">

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">{{ __('Feature Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $feature->title }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isunique" class="col-md-4 col-form-label">{{ __('Is Unique Feature') }}</label>

                                <div class="col-md-8">
                                    <div class="form-check">
                                        <label class="form-check-label" id="isunique">
                                          <input type="checkbox" class="form-check-input @error('isunique') is-invalid @enderror" name="isunique" value="1" id="isunique" @if($feature->isunique=='Yes') checked @endif /></label>
                                      </div>
                                    @error('isunique')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">{{ __('Feature Description') }}</label>

                                <div class="col-md-8">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" >{!! old('description') ?? $feature->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Feature Icon') }}</label>
                                <div class="col-md-2 pt-2">
                                    <img src="/storage/{{$feature->image}}" height="40">
                                </div>
                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" >
                                    <input type="hidden" name="oldImage" value="{{$feature->image}}">
                                    @error('image')
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
