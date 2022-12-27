@extends('admin.layouts.app')
@section('admin-title')
    Edit Book
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Book</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/books') }}">My Books</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Book </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Book</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/books/{{$book->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')                          
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">{{ __('Book Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $book->title }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="order" class="col-md-4 col-form-label">{{ __('Book Order') }}</label>

                                <div class="col-md-8">
                                    <input id="order" name="order" type="number" class="form-control @error('order') is-invalid @enderror"  value="{{ old('order') ?? $book->order }}" required>

                                    @error('order')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Book Author') }}</label>

                                <div class="col-md-8">
                                    <input id="author" name="author" type="text" class="form-control @error('author') is-invalid @enderror" value="{{ old('author') ?? $book->author}}" required>

                                    @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label">{{ __('Book Price') }}</label>

                                <div class="col-md-8">
                                    <input id="price" name="price" type="number" class="form-control @error('price') is-invalid @enderror"  value="{{ old('price') ?? $book->price }}" required>

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label">{{ __('Book Discount') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" name="discount" type="number" class="form-control @error('discount') is-invalid @enderror"  value="{{ old('discount') ?? $book->discount }}" required >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Book Description') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" >{!! old('description') ?? $book->description  !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="thumbnail" class="col-md-4 col-form-label">{{ __('Book Image') }}</label>
                                <div class="col-md-8">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') ?? $book->thumbnail }}" >
                                    <input type="hidden" name="old_thumbnail" value="{{$book->thumbnail}}">
                                    @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Book Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                        <option value="{{$book->status}}">{{$book->status}}</option>
                                        <option value="">---------------</option>
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
