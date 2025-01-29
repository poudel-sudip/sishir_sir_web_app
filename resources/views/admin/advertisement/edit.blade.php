@extends('admin.layouts.app')
@section('admin-title')
    Edit AD
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Advertisement</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/advertisement') }}">Advertisement</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Advertisement</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/advertisement/{{$ad->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group row">
                                <label for="info" class="col-md-4 col-form-label">{{ __('Banner Caption') }}</label>

                                <div class="col-md-8">
                                    <input id="info" name="info" type="text" class="form-control @error('info') is-invalid @enderror" value="{{ old('info') ?? $ad->info }}" autocomplete="info" readonly>

                                    @error('info')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position" class="col-md-4 col-form-label">{{ __('Banner Position') }}</label>

                                <div class="col-md-8">
                                    <input id="position" name="position" type="text" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') ?? $ad->position }}" autocomplete="position" readonly>

                                    @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="banner" class="col-md-4 col-form-label">{{ __('Banner Image') }}</label>
                                
                                <div class="col-md-8">
                                    <img src="/storage/{{$ad->banner}}" height="50">
                                    <input id="banner" type="file" class="form-control @error('banner') is-invalid @enderror" name="banner" value="{{ old('banner') }}" >
                                    <input type="hidden" name="old_banner" value="{{$ad->banner}}">
                                    
                                    @error('banner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                            </div>

                            {{-- <div class="form-group row">
                                <label for="position" class="col-md-4 col-form-label">{{ __('Banner Position') }}</label>

                                <div class="col-md-8">
                                    <select id="position" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required>
                                        <option value="{{$ad->position}}">{{$ad->position}}</option>
                                        <option value="">-----------------------</option>
                                        <option value="after_landing_section">after_landing_section</option>
                                        <option value="after_mock_test">after_mock_test</option>
                                        <option value="after_library">after_library</option>
                                        <option value="after_blogs">after_blogs</option>
                                        <option value="after_books">after_books</option>
                                        <option value="after_videos">after_videos</option>
                                    </select>
                                    @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Banner Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                        <option value="{{$ad->status}}">{{$ad->status}}</option>
                                        <option value="">----------------------</option>
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
