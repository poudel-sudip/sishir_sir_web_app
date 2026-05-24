@extends('admin.layouts.app')
@section('admin-title')
  Edit Batch
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Edit Course  Batch</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-header">Edit Course Batch</div>

          <div class="card-body">
            <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}" enctype="multipart/form-data">
              @csrf
              @method('PATCH')

              <div class="row">

                <div class="col-md-12">
                  <div class="form-group row">
                    <label for="course" class="col-sm-2 col-form-label">Course Name</label>
                    <div class="col-sm-10">
                      <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') ?? $course->name }}" required readonly autocomplete="course">

                      @error('course')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Batch Name</label>
                    <div class="col-sm-8">
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $batch->name }}" required autocomplete="name" autofocus>

                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="classroomLink" class="col-sm-4 col-form-label"> Join Link</label>
                    <div class="col-sm-8">
                      <input id="classroomLink" type="text" class="form-control @error('classroomLink') is-invalid @enderror" name="classroomLink" value="{{ old('classroomLink') ?? $batch->classroomLink }}">

                      @error('classroomLink')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>
                

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="fee" class="col-sm-4 col-form-label"> Fee<span>(Rs.)</span></label>
                    <div class="col-sm-8">
                      <input id="fee" type="number" class="form-control @error('fee') is-invalid @enderror" name="fee" value="{{ old('fee') ?? $batch->fee }}" required>

                      @error('fee')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="discount" class="col-sm-4 col-form-label"> Discount <span>(Rs.)</span></label>
                    <div class="col-sm-8">
                      <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? $batch->discount ?? 0 }}" >

                      @error('discount')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="duration" class="col-sm-4 col-form-label">Duration</label>
                    <div class="col-sm-8">
                      <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $batch->duration }}" required>

                      @error('duration')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="durationType" class="col-sm-4 col-form-label">Duration Type</label>
                    <div class="col-sm-8">
                        <select id="durationType" class="form-control @error('durationType') is-invalid @enderror" name="durationType" value="{{ old('durationType') ?? $batch->durationType }}" required>
                          <option value="Hours" @if($batch->durationType == 'Hours') selected @endif>Hours</option>
                          <option value="Days" @if($batch->durationType == 'Days') selected @endif>Days</option>
                          <option value="Months" @if($batch->durationType == 'Months') selected @endif>Months</option>
                        </select>

                        @error('durationType')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="startDate" class="col-sm-4 col-form-label">Start Date</label>
                    <div class="col-sm-8">
                      <input id="startDate" type="date" class="form-control @error('startDate') is-invalid @enderror" name="startDate" value="{{ old('startDate')?? date('Y-m-d',strtotime($batch->startDate)) }}" required>

                      @error('startDate')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="endDate" class="col-sm-4 col-form-label">End Date</label>
                    <div class="col-sm-8">
                      <input id="endDate" type="date" class="form-control @error('endDate') is-invalid @enderror" name="endDate" value="{{ old('endDate') ?? date('Y-m-d',strtotime($batch->endDate)) }}" required>

                      @error('endDate')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                
                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="timeSlot" class="col-sm-4 col-form-label">Time Slot</label>
                    <div class="col-sm-8">
                      <input id="timeSlot" type="text" class="form-control @error('timeSlot') is-invalid @enderror" name="timeSlot" value="{{ old('timeSlot') ?? $batch->timeSlot }}">

                      @error('timeSlot')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="image" class="col-sm-4 col-form-label">Thumbnail Image</label>
                    <div class="col-sm-8">
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" accept="image/*">
                        <input type="hidden" name="old_image" value="{{ $batch->image }}">
                        @error('image')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="status" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8">
                      <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $batch->status }}" required>
                        <option value="Inactive" @if($batch->status == 'Inactive') selected @endif>Inactive</option>
                        <option value="Active" @if($batch->status == 'Active') selected @endif>Active</option>
                        <option value="Running" @if($batch->status == 'Running') selected @endif>Running</option>
                        <option value="Closed" @if($batch->status == 'Closed') selected @endif>Closed</option>
                        {{-- <option value="No Class" @if($batch->status == 'No Class') selected @endif >No Class</option> --}}
                      </select>

                      @error('status')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                      <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" >{!! old('description') ?? $batch->description !!}</textarea>

                      @error('description')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>


              </div>

              <div class="form-group row mt-2">
                <div class="col-md-6 offset-md-2">
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
