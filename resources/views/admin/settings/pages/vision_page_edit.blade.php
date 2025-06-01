@extends('admin.layouts.app')
@section('admin-title')
    Edit Vision Page
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Vision Page</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/web-pages/vision') }}">Vision Page</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Vision Page</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/web-pages/vision" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')   
                            
                            <div class="form-group row">
                                <label for="page_content" class="col-md-12 col-form-label">{{ __('Vision Page Content') }}</label>

                                <div class="col-md-12">
                                    <textarea id="page_content" name="page_content" class="summernote form-control @error('page_content') is-invalid @enderror"  required>{{ old('page_content') ?? $page->description ?? '' }}</textarea>

                                    @error('page_content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            

                            <div class="form-group text-center mt-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
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
