@extends('tutors.layouts.app')
@section('tutor-title')
    Edit Course: {{$course->course}}
@endsection
@section('tutor-title-icon')
    <i class="fas fa-edit"></i>
@endsection

@section('content')
    <div class="tutor-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Course</div>
                    <div class="card-body student_exam_card">
                        <form method="POST" action="/tutor/special-courses/{{$course->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="course" class="col-md-3 col-form-label">{{ __('Course Name') }}</label>

                                <div class="col-md-9">
                                    <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') ?? $course->course }}" required autocomplete="course" autofocus>

                                    @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fee" class="col-md-3 col-form-label">{{ __('Course Fee (Rs)') }}</label>

                                <div class="col-md-9">
                                    <input id="fee" type="text" class="form-control @error('fee') is-invalid @enderror" name="fee" value="{{ old('fee') ?? $course->fee }}" required autocomplete="fee" readonly>

                                    @error('fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-3 col-form-label">{{ __('Discount (Rs)') }}</label>

                                <div class="col-md-9">
                                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? $course->discount }}" required autocomplete="discount" readonly>

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="startDate" class="col-md-3 col-form-label">{{ __('Start Date') }}</label>

                                <div class="col-md-9">
                                    <input id="startDate" type="date" class="form-control @error('startDate') is-invalid @enderror" name="startDate" value="{{ old('startDate') ?? date('Y-m-d',strtotime($course->startDate)) }}" required autocomplete="startDate">

                                    @error('startDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="duration" class="col-md-3 col-form-label">{{ __('Duration') }}</label>

                                <div class="col-md-9">
                                    <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $course->duration }}" required autocomplete="duration">

                                    @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="timeSlot" class="col-md-3 col-form-label">{{ __('Time Slot') }}</label>

                                <div class="col-md-9">
                                    <input id="timeSlot" type="text" class="form-control @error('timeSlot') is-invalid @enderror" name="timeSlot" value="{{ old('timeSlot') ?? $course->timeSlot }}" required autocomplete="timeSlot">

                                    @error('timeSlot')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label for="description" class="col-md-3 col-form-label">{{ __('Description ') }}</label>

                                <div class="col-md-9">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required >{!! old('description') ?? $course->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="payMode" class="col-md-3 col-form-label">{{ __('Payment Mode') }}</label>

                                <div class="col-md-9">
                                    <select name="payMode" id="payMode" class="form-control @error('payMode') is-invalid @enderror" value="{{ old('payMode') }}" required>
                                        <option value="{{$course->payMode}}">{{$course->payMode}}</option>    
                                        <!-- <option value="">------------</option>
                                        <option value="Percentage">Percentage</option>
                                        <option value="Package">Package</option>
                                        <option value="Daywise">Daywise</option> -->
                                    </select>
                                    @error('payMode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="payAmount" class="col-md-3 col-form-label">{{ __('Payment Amount') }}</label>

                                <div class="col-md-9">
                                    <input id="payAmount" type="text" class="form-control @error('payAmount') is-invalid @enderror" name="payAmount" value="{{ old('payAmount') ?? $course->payAmount }}" required autocomplete="payAmount" readonly>

                                    @error('payAmount')
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
