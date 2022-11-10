@extends('admin.layouts.app')
@section('admin-title')
    Add Tutor | {{$course->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Add Tutor | {{$course->name}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/tutors">Tutors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header"> Add Tutor | {{$course->name}}  </div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/video-course/{{$course->id}}/tutors" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="course" class="col-sm-3 col-form-label">{{ __('Video Course') }}</label>
                            <div class="col-md-9">
                                <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') ?? $course->name }}" required readonly>
                                @error('course')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tutor" class="col-sm-3 col-form-label">{{ __(' Tutor') }}</label>
                            <div class="col-md-9">
                                <select id="tutor" class="form-control @error('tutor') is-invalid @enderror" name="tutor" value="{{ old('tutor') }}" required>
                                    <option value="">Choose a Tutor...</option>
                                    @foreach($tutors as $tutor)
                                    <option value="{{$tutor->id}}">{{$tutor->name}}</option>
                                    @endforeach
                                </select>
                                @error('tutor')
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
