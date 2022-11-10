@extends('admin.layouts.app')
@section('admin-title')
    Tutors Courses Show
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$tutor->name}} : {{$course->course}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
              <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses">Courses</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$course->course}} </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}" enctype="multipart/form-data" class="forms-sample">
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
                                    <input id="fee" type="text" class="form-control @error('fee') is-invalid @enderror" name="fee" value="{{ old('fee') ?? $course->fee }}" required autocomplete="fee">

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
                                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? $course->discount }}" required autocomplete="discount">

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
                                    <input id="timeSlot" type="text" class="form-control @error('timeSlot') is-invalid @enderror" name="timeSlot" value="{{ old('timeSlot') ?? $course->timeSlot }}"  autocomplete="timeSlot">

                                    @error('timeSlot')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="classroomLink" class="col-md-3 col-form-label">{{ __('Classroom Link') }}</label>

                                <div class="col-md-9">
                                    <input id="classroomLink" type="text" class="form-control @error('classroomLink') is-invalid @enderror" name="classroomLink" value="{{ old('classroomLink') ?? $course->classroomLink }}"  autocomplete="classroomLink">

                                    @error('classroomLink')
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
                                    <input id="payAmount" type="text" class="form-control @error('payAmount') is-invalid @enderror" name="payAmount" value="{{ old('payAmount') ?? $course->payAmount }}" required autocomplete="payAmount" >

                                    @error('payAmount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workedDays" class="col-md-3 col-form-label">{{ __('Worked Days') }}</label>

                                <div class="col-md-9">
                                    <input id="workedDays" type="text" class="form-control @error('workedDays') is-invalid @enderror" name="workedDays" value="{{ old('workedDays') ?? $course->worked_days }}" required autocomplete="workedDays" >

                                    @error('workedDays')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-3 col-form-label">{{ __('Status') }}</label>

                                <div class="col-md-9">
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') }}" required>
                                        <option value="{{$course->status}}">{{$course->status}}</option>    
                                        <option value="">------------</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Active">Active</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                    @error('status')
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
