@extends('admin.layouts.app')
@section('admin-title')
    Create Schedules
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Schedule </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
                <li class="breadcrumb-item"><a href="/admin/batches/{{$batch->id}}/schedules">Schedules</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">{{$batch->course->name.' : '.$batch->name}}</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/batches/{{$batch->id}}/schedules" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="course" class="col-md-4 col-form-label ">{{ __('Batch') }}</label>

                                <div class="col-md-8">
                                    <input id="course" type="text" class="form-control" name="course" value="{{ $batch->course->name.' / '.$batch->name }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tutor" class="col-md-4 col-form-label">{{ __('Tutor') }}</label>

                                <div class="col-md-8">
                                    <select name="tutor" id="tutor" class="form-control @error('tutor') is-invalid @enderror" required>
                                        <option value="--------">-----------</option>
                                        @foreach($tutors as $tutor)
                                        <option value="{{$tutor->name}}">{{$tutor->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('tutor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="topic" class="col-md-4 col-form-label">{{ __('Topic') }}</label>

                                <div class="col-md-8">
                                    <input id="topic" type="text" class="form-control @error('topic') is-invalid @enderror" name="topic" value="{{ old('topic') }}" required>

                                    @error('topic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label">{{ __('Date') }}</label>

                                <div class="col-md-8">
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time" class="col-md-4 col-form-label">{{ __('Time Slot') }}</label>

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
