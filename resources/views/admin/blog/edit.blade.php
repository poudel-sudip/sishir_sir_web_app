@extends('admin.layouts.app')
@section('admin-title')
    Edit News
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ $blog->title }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/newsroom') }}">Newsroom</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit News </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit News</div>
                    <div class="card-body">
                        <form method="POST" action="{{ ('/admin/newsroom/'.$blog->id) }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label">{{ __(' Category') }}</label>

                                <div class="col-md-8">
                                    <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}">
                                        <option value="">Select Newsroom Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
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
                                <label for="title" class="col-md-4 col-form-label">{{ __('Newsroom Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $blog->title }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Description ') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required >{!! old('description') ?? $blog->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Thumbnail Image') }}</label>
                                <div class="col-md-8">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" >
                                    <input type="hidden" name="old_image" value="{{$blog->image}}">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="show_image" class="col-md-4 col-form-label">{{ __('Show Thumbnail') }}</label>

                                <div class="col-md-8 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="show_image_1" type="radio" class="form-check-input" name="show_image" value="1" {{ $blog->show_image == '1' ? 'checked' : '' }} >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="show_image_2" type="radio" class="form-check-input" name="show_image" value="0" {{ $blog->show_image == '0' ? 'checked' : '' }} >No</label>
                                        </div>
                                    </div>
                                    @error('show_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __(' Author') }}</label>

                                <div class="col-md-8">
                                    <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? $blog->author }}" autocomplete="author">

                                    @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author_image" class="col-md-4 col-form-label">{{ __('Author Image') }}</label>
                                <div class="col-md-8">
                                    <input id="author_image" type="file" class="form-control @error('author_image') is-invalid @enderror" name="author_image" value="{{ old('author_image') }}" >
                                    <input type="hidden" name="old_author_image" value="{{$blog->authorimage}}">
                                    @error('author_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="search_tags" class="col-md-4 col-form-label">{{ __('Search Tags') }}</label>

                                <div class="col-md-8">
                                    <input id="search_tags" type="text" class="form-control @error('search_tags') is-invalid @enderror" name="search_tags" value="{{ old('search_tags') ?? $blog->search_tags }}" autocomplete="search_tags">

                                    @error('search_tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __(' Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $blog->status }}" required>
                                        <option value="{{$blog->status}}">{{$blog->status}}</option>
                                        <option></option>
                                        <option value="Unpublished">Unpublished</option>
                                        <option value="Published">Published</option>
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
