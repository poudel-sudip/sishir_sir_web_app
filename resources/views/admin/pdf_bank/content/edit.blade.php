@extends('admin.layouts.app')
@section('admin-title')
    Edit PDF File Content 
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Edit PDF File Content  </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-groups') }}">PDF Banks</a></li>
                <li class="breadcrumb-item"><a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files">Contents</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit PDF Content Details </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/{{$content->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')
                            {{-- <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">{{ __('File Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $content->name }}" required autocomplete="name" placeholder="Chapter-1" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">{{ __('PDF File Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $content->title }}" >

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pdf_file" class="col-md-4 col-form-label">{{ __('PDF File') }}</label>
                                <div class="col-md-8">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file') ?? $content->pdf_file }}" >
                                    <input type="hidden" name="old_file" value="{{$content->pdf_file}}">
                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="can_download" class="col-md-4 col-form-label">{{ __('Can Download') }}</label>
    
                                <div class="col-md-8 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios1" type="radio" class="form-check-input" name="can_download" value="1" @if($content->download) checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios2" type="radio" class="form-check-input" name="can_download" value="0" @if(!$content->download) checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('can_download')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Authors') }}</label>
    
                                <div class="col-md-8">
                                    <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? $content->author ?? auth()->user()->name }}" autocomplete="author">
    
                                    @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="published_year" class="col-md-4 col-form-label">{{ __('Published Year') }}</label>
    
                                <div class="col-md-8">
                                    <input id="published_year" type="text" class="form-control @error('published_year') is-invalid @enderror" name="published_year" value="{{ old('published_year') ?? $content->published_year  }}" autocomplete="published_year">
    
                                    @error('published_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="pages" class="col-md-4 col-form-label">{{ __('No of Pages') }}</label>
    
                                <div class="col-md-8">
                                    <input id="pages" type="text" class="form-control @error('pages') is-invalid @enderror" name="pages" value="{{ old('pages') ?? $content->pages  }}" autocomplete="pages">
    
                                    @error('pages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="video_file" class="col-md-4 col-form-label">{{ __('Youtube Video Link') }}</label>

                                <div class="col-md-8">
                                    <input id="video_file" type="text" class="form-control @error('video_file') is-invalid @enderror" name="video_file" value="{{ old('video_file') ?? $content->video_file }}" >

                                    @error('video_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $content->status }}" required>
                                        <option value="{{$content->status}}">{{$content->status}}</option>
                                        <option value="">----------</option>
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
