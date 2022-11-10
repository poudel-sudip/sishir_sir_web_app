@extends('admin.layouts.app')
@section('admin-title')
    Create Batch
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Batch</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Batch </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Batch</div>
                    <div class="card-body">
                      <form class="form-sample" method="POST" action="/admin/batches" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label for="course" class="col-sm-4 col-form-label">Course Name</label>
                              <div class="col-sm-8">
                                <select id="course" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') }}">
                                    <option value=""></option>

                                    @foreach($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach
                                </select>
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
                              <label for="name" class="col-sm-4 col-form-label">Batch name</label>
                              <div class="col-sm-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="classroomLink" class="col-sm-4 col-form-label">Batch Join Link</label>
                                    <div class="col-sm-8">
                                        <input id="classroomLink" type="text" class="form-control @error('classroomLink') is-invalid @enderror" name="classroomLink" value="{{ old('classroomLink') }}" >

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
                              <label for="timeSlot" class="col-sm-4 col-form-label">Time Slot</label>
                              <div class="col-sm-8">
                                  <input id="timeSlot" type="text" class="form-control @error('timeSlot') is-invalid @enderror" name="timeSlot" value="{{ old('timeSlot') }}" >

                                  @error('timeSlot')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                              <label for="fee" class="col-sm-4 col-form-label">Course Fee <span>(Rs.)</span></label>
                              <div class="col-sm-8">
                                <input id="fee" type="number" class="form-control @error('fee') is-invalid @enderror" name="fee" value="{{ old('fee') ?? 0 }}" required>

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
                              <label for="discount" class="col-sm-4 col-form-label">Course Discount</label>
                              <div class="col-sm-8">
                                <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? 0 }}" >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                              <label for="duration" class="col-sm-4 col-form-label">Duration</label>
                              <div class="col-sm-8">
                                <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') }}" required>

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
                                <select id="durationType" class="form-control @error('durationType') is-invalid @enderror" name="durationType" value="{{ old('durationType') }}" required>
                                    <option value="Hours">Hours</option>
                                    <option value="Days">Days</option>
                                    <option value="Months">Months</option>
                                </select>
                                @error('durationType')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                              <label for="startDate" class="col-sm-4 col-form-label">Start Date</label>
                              <div class="col-sm-8">
                                <input id="startDate" type="date" class="form-control @error('startDate') is-invalid @enderror" name="startDate" value="{{ old('startDate') }}" required>

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
                                    <input id="endDate" type="date" class="form-control @error('endDate') is-invalid @enderror" name="endDate" value="{{ old('endDate') }}" required>

                                    @error('endDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                              </div>
                            </div>
                          </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                              <label for="status" class="col-sm-4 col-form-label">Status</label>
                              <div class="col-sm-8">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Active">Active</option>
                                    <option value="Running">Running</option>
                                    <option value="Closed">Closed</option>
                                    <option value="No Class">No Class</option>
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
                              <label class="col-sm-2 col-form-label">Description</label>
                              <div class="col-sm-10">
                                <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" ></textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="col-md-6 offset-md-5">
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
