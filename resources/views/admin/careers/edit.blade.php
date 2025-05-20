@extends('admin.layouts.app')
@section('admin-title')
    Edit Career Vaccancy Post
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Vaccancy Post</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/careers') }}">Vaccancies</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Vaccancy Post</div>
                    <div class="card-body">
                        <form method="POST" action="{{ ('/admin/careers/'.$vaccancy->id) }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label">{{ __(' Category') }}</label>

                                <div class="col-md-8">
                                    <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" >
                                        <option value=""></option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($category->id == $vaccancy->category_id) selected @endif>{{ucwords($category->name)}}</option>
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
                                <label for="title" class="col-md-4 col-form-label">{{ __('Vaccancy Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $vaccancy->title }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Vaccancy Author') }}</label>

                                <div class="col-md-8">
                                    <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? $vaccancy->author }}" required autocomplete="author" autofocus>

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
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required >{!! old('description') ?? $vaccancy->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="search_tags" class="col-md-4 col-form-label">{{ __('Search Tags') }}</label>

                                <div class="col-md-8">
                                    <input id="search_tags" type="text" class="form-control @error('search_tags') is-invalid @enderror" name="search_tags" value="{{ old('search_tags') ?? $vaccancy->search_tags }}" autocomplete="search_tags">

                                    @error('search_tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="pdf_file" class="col-md-4 col-form-label">{{ __('PDF File') }}</label>
                                <div class="col-6 col-md-1">
                                    @if(trim($vaccancy->pdf_file))
                                    <a href="/storage/{{$vaccancy->pdf_file}}" target="_blank" class="h1 text-danger"> <i class="fa fa-file-pdf-o"></i> </a>
                                    @endif
                                </div>
                                <div class="col-6 col-md-2 d-flex align-items-center"> 
                                    @if(trim($vaccancy->pdf_file))                                   
                                    <label class="" for="clear_pdf_file">Remove PDF</label>
                                    <input class="align-self-stretch" type="checkbox" name="clear_pdf_file" id="clear_pdf_file">
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file') }}" accept=".pdf" >
                                    <input type="hidden" name="old_pdf_file" value="{{$vaccancy->pdf_file}}">
                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="img_file" class="col-md-4 col-form-label">{{ __('Image File') }}</label>
                                <div class="col-6 col-md-1">
                                    @if(trim($vaccancy->img_file))
                                    <a href="/storage/{{$vaccancy->img_file}}" target="_blank" class="h1 text-danger"> <img src="/storage/{{$vaccancy->img_file}}" alt="" class="img img-fluid"> </a>
                                    @endif
                                </div>
                                <div class="col-6 col-md-2 d-flex align-items-center"> 
                                    @if(trim($vaccancy->img_file))                                   
                                    <label class="" for="clear_img_file">Remove Image</label>
                                    <input class="align-self-stretch" type="checkbox" name="clear_img_file" id="clear_img_file">
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <input id="img_file" type="file" class="form-control @error('img_file') is-invalid @enderror" name="img_file" value="{{ old('img_file') }}" accept="image/*" >
                                    <input type="hidden" name="old_img_file" value="{{$vaccancy->img_file}}">
                                    @error('img_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="thumbnail" class="col-md-4 col-form-label">{{ __('Thumbnail') }}</label>
                                <div class="col-md-2 pt-2">
                                    <img src="/storage/{{$vaccancy->thumbnail}}" height="40">
                                </div>
                                <div class="col-md-6">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}" accept="image/jpeg, image/png">
                                    <input type="hidden" name="old_thumbnail" value="{{$vaccancy->thumbnail}}">
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
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $vaccancy->status }}" required>
                                        <option value="{{$vaccancy->status}}">{{$vaccancy->status}}</option>
                                        <option value="">-------------</option>
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
