@extends('admin.layouts.app')
@section('admin-title')
    Edit Video | {{$video->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Video | {{$video->title}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/chapters">Chapters</a></li>
                <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos">Videos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Video </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header"> Edit Video | {{$video->title}} </div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos/{{$video->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="title" class="col-sm-3 col-form-label">{{ __('Video Title') }}</label>
                            <div class="col-md-9">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $video->title }}" required autocomplete="name" autofocus>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-sm-3 col-form-label">{{ __('URL Link') }}</label>
                            <div class="col-md-9">
                                <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') ?? $video->link }}" required autocomplete="link" >
                                @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-12 col-form-label">{{ __('Video Content') }}</label>

                            <div class="col-md-12">
                                <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" >{!! old('description') ?? $video->content !!}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="isPublic" class="col-md-4 col-form-label">{{ __('Is Public') }}</label>

                            <div class="col-md-8 row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input id="membershipRadios1" type="radio" class="form-check-input" name="isPublic" value="Yes" @if($video->isPublic=="Yes") checked @endif >Yes</label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input id="membershipRadios2" type="radio" class="form-check-input" name="isPublic" value="No" @if($video->isPublic=="No") checked @endif>No</label>
                                    </div>
                                </div>
                                @error('isPublic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">{{ __(' Status') }}</label>
                            <div class="col-md-9">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $video->status }}" required>
                                    <option value="{{$video->status}}">{{$video->status}}</option>
                                    <option value="">------------</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Active">Active</option>
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
