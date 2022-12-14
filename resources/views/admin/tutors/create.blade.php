@extends('admin.layouts.app')
@section('admin-title')
    Create Tutors
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Tutors</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Tutor</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add New Tutor</div>

                    <div class="card-body">
                        <form method="POST" action="/admin/tutors" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="courses" class="col-md-4 col-form-label">{{ __('Courses/Batches') }}</label>

                                <div class="col-md-8">
                                    <select id="courses" class="form-control @error('courses') is-invalid @enderror" name="courses[]" multiple size="5" required>
                                        @foreach($batches as $batch)
                                            <option value="{{$batch->id}}">{{$batch->course->name.' - '.$batch->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('courses')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">{{ __('Tutor Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="qualification" class="col-md-4 col-form-label">{{ __('Qualification') }}</label>

                                <div class="col-md-8">
                                    <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification') }}" autocomplete="qualification" >

                                    @error('qualification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="experience" class="col-md-4 col-form-label">{{ __('Experience') }}</label>

                                <div class="col-md-8">
                                    <input id="experience" type="text" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ old('experience') }}" autocomplete="experience" >

                                    @error('experience')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-md-4 col-form-label">{{ __('Contact No') }}</label>

                                <div class="col-md-8">
                                    <input id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" autocomplete="contact" >

                                    @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="new password" >

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">{{ __(' Description') }}</label>

                                <div class="col-md-8">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  autocomplete="description" >

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}</label>

                                <div class="col-md-8">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" >

                                    @error('image')
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
