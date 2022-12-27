@extends('admin.layouts.app')
@section('admin-title')
    Create AD
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Advertisement</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/advertisement') }}">Advertisement</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Advertisement</div>
                    <div class="card-body">
                        <form method="POST" action="{{ ('/admin/advertisement') }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                                                        
                            <div class="form-group row">
                                <label for="link" class="col-md-4 col-form-label">{{ __('Banner Link') }}</label>

                                <div class="col-md-8">
                                    <input id="link" name="link" type="text" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" autocomplete="link" autofocus>

                                    @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="banner" class="col-md-4 col-form-label">{{ __('Banner Image') }}</label>
                                <div class="col-md-8">
                                    <input id="banner" type="file" class="form-control @error('banner') is-invalid @enderror" name="banner" value="{{ old('banner') }}" required >

                                    @error('banner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Banner Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Active">Active</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

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
