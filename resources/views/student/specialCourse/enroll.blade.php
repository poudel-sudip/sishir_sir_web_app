@extends('student.layouts.app')
@section('student-title')
    Enroll Tutor Special Courses
@endsection
@section('student-title-icon')
    <i class="far fa-calendar-plus"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
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
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ __('Enroll Tutor Special Course') }}</div>

                    <div class="card-body enroll_form">

                        <form method="POST" action="/student/tutor-special/courses" enctype="multipart/form-data">
                            @if (session('alreadybooked'))
                                <div class="alert alert-danger">
                                    {{ session('alreadybooked') }}
                                </div>
                            @endif
                           
                            @csrf
                            <div class="form-group row">
                                <label for="tutor_name" class="col-md-4 col-form-label text-md-right">{{ __('Tutor Name') }}</label>

                                <div class="col-md-8">
                                    <select name="tutor_name" id="tutor_name" class="enroll-form-control @error('tutor_name') is-invalid @enderror" value="{{ old('tutor_name') }}" autofocus required>
                                        <option value="">Select a Tutor</option>
                                        @foreach($tutors as $tutor)
                                            <option value="{{$tutor->id}}" slug="{{$tutor->slug}}"> {{$tutor->name}} </option>
                                        @endforeach
                                    </select>
                                    @error('tutor_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label text-md-right">{{ __('Course Name') }}</label>

                                <div class="col-md-8">
                                    <select name="course_name" id="course_name" class="enroll-form-control @error('course_name') is-invalid @enderror"  required>
                                    </select>
                                    @error('course_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            {{-- <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Booking Description') }} </label>

                                <div class="col-md-8">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" >

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}


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

    <script>
        $(document).ready(function () {
            $(document).on('change', '#tutor_name', function() {
                var course_id = $(this).find(":selected").attr('slug');
                // console.log(course_id);
                get_batches(course_id);                
            });

            function get_batches(id)
            {
                $('#course_name').html("");
                var op='';
                var request = new XMLHttpRequest()
                request.open('GET', '/api/v1/tutor/'+id, true)
                request.onload = function () {
                    // Begin accessing JSON data here
                    var data = JSON.parse(this.response);
                    // console.log(data);
                    if (request.status >= 200 && request.status < 400) {
                        var batches=data.tutor.specialCourses;
                        // console.log(batches);
                        batches.forEach((batch) => {
                            op += '<option value="' + batch.id + '">' + batch.course + '</option>';
                        });
                        // console.log(op);
                        $('#course_name').append(op);
                    } else {
                        console.log('error');
                        $('#course_name').html("");
                    }
                }
                request.send();
            }
        });
    </script>

@endsection
