@extends('admin.layouts.app')
@section('admin-title')
    Create Career Vaccancy
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Career Vaccancy Post</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/careers') }}">Vaccancies</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Create Career Vaccancy Post</div>
                    <div class="card-body">
                        <form method="POST" action="{{ ('/admin/careers') }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf                            

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">{{ __('Vaccancy Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Author') }}</label>
    
                                <div class="col-md-8">
                                    <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? auth()->user()->name ?? '' }}" required autocomplete="author">
    
                                    @error('author')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Description ') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required >{!! old('description') !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="related_tags" class="col-md-4 col-form-label">{{ __('Related Tags') }}</label>
                                <div class="col-md-8">
                                    @foreach($tags as $tag)
                                        <div class="d-inline-block text-center border">
                                            <input 
                                                class=" @error('related_tags') is-invalid @enderror" 
                                                type="checkbox" 
                                                name="related_tags[]" 
                                                id="tag_{{ $tag->id }}" 
                                                value="{{ $tag->id }}"
                                                {{ (is_array(old('related_tags')) && in_array($tag->id, old('related_tags'))) ? 'checked' : '' }}
                                            >
                                            <label class="" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                        </div>
                                    @endforeach

                                    @error('related_tags')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="search_tags" class="col-md-4 col-form-label">{{ __('Search Tags') }}</label>

                                <div class="col-md-8">
                                    <input id="search_tags" type="text" class="form-control @error('search_tags') is-invalid @enderror" name="search_tags" value="{{ old('search_tags') }}" autocomplete="search_tags">

                                    @error('search_tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="pdf_file" class="col-md-4 col-form-label">{{ __('Vaccancy PDF File') }}</label>
    
                                <div class="col-md-8">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file') }}" accept=".pdf">
    
                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="img_file" class="col-md-4 col-form-label">{{ __('Vaccancy Image File') }}</label>
    
                                <div class="col-md-8">
                                    <input id="img_file" type="file" class="form-control @error('img_file') is-invalid @enderror" name="img_file" value="{{ old('img_file') }}" accept="image/*">
    
                                    @error('img_file')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="source" class="col-md-4 col-form-label">{{ __('Source') }}</label>

                                <div class="col-md-8">
                                    <input id="source" type="text" class="form-control @error('source') is-invalid @enderror" name="source" value="{{ old('source')  }}" autocomplete="source">

                                    @error('source')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="thumbnail" class="col-md-4 col-form-label">{{ __(' Thumbnail') }}</label>
    
                                <div class="col-md-8">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}" accept="image/png, image/jpeg" required>
    
                                    @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                                        
                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __(' Status') }}</label>

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
