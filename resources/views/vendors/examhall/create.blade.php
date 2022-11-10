@extends('vendors.layouts.app')
@section('admin-title')
    Create Exam Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Exam Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/vendor/exam-hall/bookings/') }}">Exam Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Booking</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Exam Booking</div>
                    <div class="card-body">
                        <form method="POST" action="/vendor/exam-hall/bookings/next" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="exam_name" class="col-md-4 col-form-label">{{ __('Exam Category Name') }}</label>
                                <div class="col-md-8">
                                        <select name="exam_name" id="exam_name" class="form-control @error('exam_name') is-invalid @enderror" value="{{ old('exam_name') }}" autofocus required>
                                           <option value="">Select an Exam</option>
                                            @foreach($exams as $exam)
                                                <option value="{{$exam->id}}"> {{$exam->title}} </option>
                                            @endforeach
                                    </select>
                                    @error('exam_name')
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
