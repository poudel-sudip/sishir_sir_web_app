@extends('admin.layouts.app')
@section('admin-title')
    Create Zoom Meeting
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Zoom Meeting</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/zoom/meetings') }}">Meetings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Meeting</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add New Zoom Meeting</div>

                    <div class="card-body">
                        <form method="POST" action="/admin/zoom/meetings" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>
                                <div class="col-md-8">
                                        <select name="course_name" id="course_name" class="form-control @error('course_name') is-invalid @enderror" value="{{ old('course_name') }}" autofocus required>
                                           <option value="">Select Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}" slug="{{$course->slug}}"> {{$course->name}} </option>
                                            @endforeach
                                    </select>
                                    @error('course_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="batch_name" class="col-md-4 col-form-label">{{ __('Batch Name') }}</label>

                                <div class="col-md-8">
                                        <select name="batch_name" id="batch_name" class="form-control @error('batch_name') is-invalid @enderror" value="{{ old('batch_name') }}"  required>
                                    </select>
                                    @error('batch_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="meetingtype" class="col-md-4 col-form-label">{{ __('Meeting Type') }}</label>

                                <div class="col-md-8">
                                    <select id="meetingtype" class="form-control @error('meetingtype') is-invalid @enderror" name="meetingtype" value="{{ old('meetingtype') }}" required>
                                        <option value="3">RECURRING</option>
                                        <option value="8">FIXED RECURRING</option>
                                        <option value="2">SCHEDULED</option>
                                        <option value="1">INSTANT</option>
                                    </select>
                                    @error('meetingtype')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="agenda" class="col-md-4 col-form-label">{{ __('Meeting Agenda') }}</label>

                                <div class="col-md-8">
                                    <input id="agenda" type="text" class="form-control @error('agenda') is-invalid @enderror" name="agenda">

                                    @error('agenda')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="time" class="col-md-4 col-form-label">{{ __('Meeting Time') }} </label>

                                <div class="col-md-8">
                                    <input id="time" type="text" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}" required>

                                    @error('time')
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
