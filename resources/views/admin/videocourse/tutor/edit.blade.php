@extends('admin.layouts.app')
@section('admin-title')
    Edit Tutor | {{$tutor->tutor->name ?? ''}} | {{$course->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Tutor | {{$tutor->tutor->name ?? ''}} | {{$course->name}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/tutors">Tutors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Tutor | {{$tutor->tutor->name ?? ''}} | {{$course->name}}</div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/video-course/{{$course->id}}/tutors/{{$tutor->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">{{ __('Tutor Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ??$tutor->tutor->name }}" required readonly>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="percent" class="col-sm-4 col-form-label">{{ __('Tutor Percentage (%)') }}</label>
                            <div class="col-md-8">
                                <input id="percent" type="text" class="form-control @error('percent') is-invalid @enderror" name="percent" value="{{ old('percent') ?? $tutor->percent ?? 0 }}" required >
                                @error('percent')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="paidAmount" class="col-sm-4 col-form-label">{{ __('Total Paid Amount (Rs.)') }}</label>
                            <div class="col-md-8">
                                <input id="paidAmount" type="text" class="form-control @error('paidAmount') is-invalid @enderror" name="paidAmount" value="{{ old('paidAmount') ?? $tutor->paidAmount ?? 0 }}" required >
                                <label class="">Out of Rs. {{  floor(($course->bookings()->where('status','=','Verified')->sum('paymentAmount')) * ($tutor->percent / 100))  }} </label>
                                @error('paidAmount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
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
