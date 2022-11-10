@extends('vendors.layouts.app')
@section('admin-title')
    Create Course Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Course Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/vendor/bookings') }}">Course Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Booking</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Course Booking</div>
                    <div class="card-body">
                        <form method="POST" action="/vendor/bookings/next" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>
                                <div class="col-md-8">
                                        <select name="course_name" id="course_name" class="form-control @error('course_name') is-invalid @enderror" value="{{ old('course_name') }}" autofocus required>
                                           <option value=""></option>
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
                                <label for="userCount" class="col-md-4 col-form-label">{{ __('No Of Users') }}</label>

                                <div class="col-md-8">
                                    <input id="userCount" type="number" class="form-control @error('userCount') is-invalid @enderror" name="userCount" value="{{ old('userCount') ?? 1 }}" required>

                                    @error('userCount')
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

    <script>



    </script>

@endsection
