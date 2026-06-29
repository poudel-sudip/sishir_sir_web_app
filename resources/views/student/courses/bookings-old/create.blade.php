@extends('student.layouts.app')
@section('student-title')
    Enroll New Course Batch
@endsection
@section('student-title-icon')
    <i class="far fa-calendar-plus"></i>
@endsection

@section('content')
<div class="news-feeds student-content-wrapper">
    <div class="enroll-section">
        <div class="row">
            <div class="col-md-12">
                <div class="processing booking-processing">
                    <div class="first-step">
                        <div class="f-point point"></div>
                        <div class="line"></div>
                        <div class="f-point-l point"></div>
                        <p>Booking</p>
                    </div>
                    <div class="second-step">
                        <div class="line"></div>
                        <div class="point"></div>
                        <p class="processing-verify">Verify</p>
                        <p class="processing-classroom">Classroom</p>
                    </div>
                   
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Enroll A Course Batch') }}</div>

                    <div class="card-body enroll_form">

                        <form method="POST" action="/student/course-bookings" enctype="multipart/form-data">
                            @if (session('alreadybooked'))
                                <div class="alert alert-danger">
                                    {{ session('alreadybooked') }}
                                </div>
                            @endif
                           
                            @csrf
                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label text-md-right">{{ __('Course Name') }}</label>

                                <div class="col-md-8">
                                    <select name="course_name" id="course_name" class="enroll-form-control @error('course_name') is-invalid @enderror" value="{{ old('course_name') }}" autofocus required>
                                        <option value="">Select a Course</option>
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
                                <label for="batch_name" class="col-md-4 col-form-label text-md-right">{{ __('Batch Name') }}</label>

                                <div class="col-md-8">
                                    <select name="batch_name" id="batch_name" class="enroll-form-control @error('batch_name') is-invalid @enderror"  required>
                                    </select>
                                    @error('batch_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Booking Remarks') }} </label>

                                <div class="col-md-8">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" >

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="news-feeds-contact">
        @include('student.studentContact')
    </div>
</div>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#course_name', function() {
                var course_id = $(this).find(":selected").attr('value');
                // console.log(course_id);
                get_batches(course_id);                
            });

            function get_batches(id)
            {
                $('#batch_name').html("");
                var op='';
                var request = new XMLHttpRequest()
                request.open('GET', '/courses/'+id+'/batchnames', true)
                request.onload = function () {
                    // Begin accessing JSON data here
                    var data = JSON.parse(this.response);
                    if (request.status >= 200 && request.status < 400) {
                        var batches=data.batches;
                        batches.forEach((batch) => {
                            op += '<option value="' + batch.id + '">' + batch.name + '</option>';
                        });
                        // console.log(op);
                        $('#batch_name').append(op);
                    } else {
                        // console.log('error');
                        $('#batch_name').html("");
                    }
                }
                request.send();
            }
        });
    </script>

@endsection
