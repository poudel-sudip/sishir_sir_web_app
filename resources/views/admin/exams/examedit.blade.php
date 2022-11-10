@extends('admin.layouts.app')
@section('admin-title')
    Edit Exam
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Exam: {{$exam->name}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exam-category') }}">Exam Categories</a></li>
                <li class="breadcrumb-item"><a href="/admin/exam-category/{{$exam->category->id ?? ''}}/exams">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Exam </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Exam: {{$exam->name}}</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/exams/{{$exam->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="category" class="col-md-5 col-form-label">{{ __('Exam Category') }}</label>

                                <div class="col-md-7">
                                    <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                                        <option value="{{$exam->category->id ?? ''}}">{{ucwords($exam->category->title ?? '')}}</option>
                                        <option value="">---------</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{ucwords($cat->title)}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-5 col-form-label">{{ __('Exam Name') }}</label>

                                <div class="col-md-7">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $exam->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-5 col-form-label">{{ __('Description') }}</label>

                                <div class="col-md-7">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') ?? $exam->description }}" autocomplete="description" >

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-5 col-form-label">{{ __('Exam Date') }}</label>

                                <div class="col-md-7">
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') ?? $exam->exam_date }}">

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time" class="col-md-5 col-form-label">{{ __('Exam Time') }} </label>

                                <div class="col-md-7">
                                    <input id="time" type="text" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') ?? $exam->exam_time }}" placeholder="00:00 (HH:MM)"  pattern="[0-9]{2}:[0-9]{2}">

                                    @error('time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="marks" class="col-md-5 col-form-label">{{ __('Marks Per Question') }} </label>

                                <div class="col-md-7">
                                    <input id="marks" type="text" class="form-control @error('marks') is-invalid @enderror" name="marks" value="{{ old('marks') ?? $exam->marks_per_question }}" placeholder="1">

                                    @error('marks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="negativeMarks" class="col-md-5 col-form-label">{{ __('Negative Marks Per Question') }} </label>

                                <div class="col-md-7">
                                    <input id="negativeMarks" type="text" class="form-control @error('negativeMarks') is-invalid @enderror" name="negativeMarks" value="{{ old('negativeMarks') ?? $exam->negative_marks }}" placeholder="0.00">

                                    @error('negativeMarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="status" class="col-md-5 col-form-label">{{ __('Exam Status') }}</label>

                                <div class="col-md-7">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="{{$exam->status}}">{{$exam->status}}</option>
                                        <option value="">---------</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Active">Active</option>
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
