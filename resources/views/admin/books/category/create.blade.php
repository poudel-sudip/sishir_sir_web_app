@extends('admin.layouts.app')
@section('admin-title')
    Create Book Category
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Book Category | {{$publisher->name}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/books/publishers') }}">Publishers</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/books/publishers/'.$publisher->id.'/categories') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Book Category | {{$publisher->name}} </div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/books/publishers/{{$publisher->id}}/categories" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="publisher_name" class="col-sm-3 col-form-label">{{ __('Publisher Name') }}</label>
                            <div class="col-md-9">
                                <input id="publisher_name" type="text" class="form-control @error('publisher_name') is-invalid @enderror" name="publisher_name" value="{{ old('publisher_name') ?? $publisher->name }}" required autocomplete="publisher_name" readonly>
                                @error('publisher_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-3 col-form-label">{{ __('Category Name') }}</label>
                            <div class="col-md-9">
                                <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" required autocomplete="category_name" autofocus>
                                @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="order" class="col-sm-3 col-form-label">{{ __('Category Order') }}</label>
                            <div class="col-md-9">
                                <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') }}" required autocomplete="order" >
                                @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-3 col-form-label">{{ __('Category Image') }}</label>
                            <div class="col-md-9">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required >

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="description" class="col-md-12 col-form-label">{{ __('Category Description') }}</label>

                            <div class="col-md-12">
                                <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description"  autocomplete="description" >{!! old('description') !!}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">{{ __('Category Status') }}</label>
                            <div class="col-md-9">
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
