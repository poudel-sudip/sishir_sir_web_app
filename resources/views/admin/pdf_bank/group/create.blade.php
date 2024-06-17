@extends('admin.layouts.app')
@section('admin-title')
    Create PDF Bank
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create PDF Bank</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-groups') }}">PDF Banks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add PDF Bank </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add PDF Bank</div>
                    <div class="card-body">
                        <form method="POST" action="{{ ('/admin/pdf-bank/pdf-groups') }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label">{{ __('Category') }}</label>

                                <div class="col-md-8">
                                    <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required>
                                        <option value="">Choose one Option...</option>
                                        @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{ucwords($cat->name)}}</option>
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
                                <label for="name" class="col-md-4 col-form-label">{{ __('PDF Bank Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Author') }}</label>

                                <div class="col-md-8">
                                    <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}" >

                                    @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label">{{ __('Price') }}</label>

                                <div class="col-md-8">
                                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" >

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label">{{ __('Discount') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') }}" >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Description') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" >{!! old('description') !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="thumbnail" class="col-md-4 col-form-label">{{ __('Thumbnail Image') }}</label>
                                <div class="col-md-8">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}" required >

                                    @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Status') }}</label>

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
