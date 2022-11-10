@extends('vendors.layouts.app')
@section('admin-title')
    Upload Form Applicants
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Upload Applicants</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/vendor/vendor-dynamic-forms') }}">Forms</a></li>
                <li class="breadcrumb-item"><a href="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants">Applicants</a></li>
                <li class="breadcrumb-item active" aria-current="page">Upload</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Upload Applicants | {{ucwords($vform->title)}} </div>
                    <div class="card-body">
                        <form method="POST" action="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants/import" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="file" class="col-md-4 col-form-label ">{{ __('Choose File') }}</label>

                                <div class="col-md-8">
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}" required autofocus>

                                    @error('file')
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
