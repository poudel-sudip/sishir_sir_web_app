@extends('admin.layouts.app')
@section('admin-title')
    Edit Chapter | {{$chapter->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Chapter | {{$chapter->name}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/chapters">Chapters</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Chapter </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Chapter | {{$chapter->name}} </div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ __('Chapter Name') }}</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $chapter->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="serial" class="col-sm-3 col-form-label">{{ __('Chapter SN') }}</label>
                            <div class="col-md-9">
                                <input id="serial" type="number" class="form-control @error('serial') is-invalid @enderror" name="serial" value="{{ old('serial') ?? $chapter->sn }}" required autocomplete="order" >
                                @error('serial')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">{{ __('Chapter Status') }}</label>
                            <div class="col-md-9">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $chapter->status }}" required>
                                    <option value="{{$chapter->status}}">{{$chapter->status}}</option>
                                    <option value="">-------------</option>
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
