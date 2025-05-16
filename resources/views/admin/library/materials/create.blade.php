@extends('admin.layouts.app')
@section('admin-title')
    Create Library Material
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Library Material</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/library') }}">Library</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/library/'.$category->id.'/directories') }}">{{ucwords($category->name)}}</a></li>
                {{-- <li class="breadcrumb-item"><a href="{{ url('/admin/library/'.$category->id.'/materials') }}">Materials</a></li> --}}
                <li class="breadcrumb-item active" aria-current="page">Add </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">                
                <div class="card">                 
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Add Library Material | {{$category->name}}</span>
                        <a href="/admin/library/{{$category->id}}/materials/import" class="btn btn-sm btn-info">Import From Library</a>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="/admin/library/{{$category->id}}/materials" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label">{{ __('Material Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="order" class="col-sm-4 col-form-label">{{ __('Material Order') }}</label>
                                <div class="col-md-8">
                                    <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') ?? 1  }}" required autocomplete="order" >
                                    @error('order')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label">{{ __('Material Type') }}</label>
                                <div class="col-md-8">
                                    <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required>
                                        {{-- <option value="heading">Heading</option> --}}
                                        <option value="file">File</option>
                                        {{-- <option value="text">Text</option> --}}
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="file" class="col-sm-4 col-form-label">{{ __('Material File') }}</label>
                                <div class="col-md-8">
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') ?? 1  }}" autocomplete="file" >
                                    @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">{{ __('Material Description') }}</label>
                                <div class="col-md-8">
                                    <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="can_download" class="col-md-4 col-form-label">{{ __('Can Download') }}</label>

                                <div class="col-md-8 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios1" type="radio" class="form-check-input" name="can_download" value="1" >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios2" type="radio" class="form-check-input" name="can_download" value="0" checked >No</label>
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
                                <label for="thumbnail" class="col-sm-4 col-form-label">Thumbnail <small>(875*667 : 300kb)</small></label>
                                <div class="col-md-8">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') ?? 1  }}" autocomplete="thumbnail" >
                                    @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>                       

                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Authors') }}</label>

                                <div class="col-md-8">
                                    <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? auth()->user()->name }}" autocomplete="author">

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
                                    <input id="published_year" type="text" class="form-control @error('published_year') is-invalid @enderror" name="published_year" value="{{ old('published_year')  }}" autocomplete="published_year">

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
                                    <input id="pages" type="text" class="form-control @error('pages') is-invalid @enderror" name="pages" value="{{ old('pages')  }}" autocomplete="pages">

                                    @error('pages')
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
                                <label for="description" class="col-md-4 col-form-label">{{ __('Short Description') }}</label>

                                <div class="col-md-8">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description')  }}" autocomplete="description">

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
                                    <input id="search_tags" type="text" class="form-control @error('search_tags') is-invalid @enderror" name="search_tags" value="{{ old('search_tags') }}" autocomplete="search_tags">

                                    @error('search_tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="status" class="col-sm-4 col-form-label">{{ __('Material Status') }}</label>
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
