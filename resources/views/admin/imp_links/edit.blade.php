@extends('admin.layouts.app')
@section('admin-title')
    Edit Links
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Links</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/imp-links') }}">Links</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Important Links</div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ ('/admin/imp-links/'.$link->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="link_title" class="col-sm-3 col-form-label">{{ __('Link Title') }}</label>
                            <div class="col-md-9">
                                <input id="link_title" type="text" class="form-control @error('link_title') is-invalid @enderror" name="link_title" value="{{ old('link_title') ?? $link->link_title }}" required autocomplete="link_title" autofocus>
                                @error('link_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link_url" class="col-sm-3 col-form-label">{{ __('Link URL') }}</label>
                            <div class="col-md-9">
                                <input id="link_url" type="text" class="form-control @error('link_url') is-invalid @enderror" name="link_url" value="{{ old('link_url') ?? $link->link_url }}" required autocomplete="link_url" >
                                @error('link_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link_category" class="col-sm-3 col-form-label">{{ __('Link Category') }}</label>
                            <div class="col-md-9">
                                <input id="link_category" type="text" class="form-control @error('link_category') is-invalid @enderror" name="link_category" value="{{ old('link_category') ?? $link->link_category }}" autocomplete="link_category" >
                                @error('link_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link_order" class="col-sm-3 col-form-label">{{ __('Link Order') }}</label>
                            <div class="col-md-9">
                                <input id="link_order" type="number" class="form-control @error('link_order') is-invalid @enderror" name="link_order" value="{{ old('link_order') ?? $link->link_order }}" autocomplete="link_order" >
                                @error('link_order')
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
