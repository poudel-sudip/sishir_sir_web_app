@extends('admin.layouts.app')
@section('admin-title')
    Create Health Day
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Health Day</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/health-days') }}">Health Days</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Health Day</li>
                </ol>
            </nav>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">                
                <div class="card">                    
                    <div class="card-header">Add Health Day</div>
                    <div class="card-body">                        
                        <form method="POST" action="{{ ('/admin/health-days') }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf

                            <div class="form-group row">
                                <label for="category_id" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Category') }}</label>

                                <div class="col-md-12">
                                    <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" name="category_id" value="{{ old('category_id') }}" >
                                        <option value="">Select Health Day Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Date') }}</label>

                                <div class="col-md-12">
                                    <input id="date" type="text" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Health Day Title') }}</label>

                                <div class="col-md-12">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author_name" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Health Day Author') }}</label>

                                <div class="col-md-12">
                                    <input id="author_name" type="text" class="form-control @error('author_name') is-invalid @enderror" name="author_name" value="{{ old('author_name') }}"  autocomplete="author_name" >

                                    @error('author_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author_image" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('Author Image') }}</label>
                                <div class="col-md-12">
                                    <input id="author_image" type="file" class="form-control @error('author_image') is-invalid @enderror" name="author_image" value="{{ old('author_image')  }}" autocomplete="author_image" accept="image/*" >
                                    @error('author_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pdf_file" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('PDF File') }}</label>
                                <div class="col-md-12">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file')  }}" autocomplete="pdf_file" accept=".pdf">
                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Description ') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required >{!! old('description') !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="thumbnail_image" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('Thumbnail Image') }}</label>
                                <div class="col-md-12">
                                    <input id="thumbnail_image" type="file" class="form-control @error('thumbnail_image') is-invalid @enderror" name="thumbnail_image" value="{{ old('thumbnail_image')  }}" autocomplete="thumbnail_image" accept="image/*" >
                                    @error('thumbnail_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="status" class="col-md-12 pb-0 mb-0 col-form-label">{{ __(' Status') }}</label>

                                <div class="col-md-12">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
