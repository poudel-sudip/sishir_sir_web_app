@extends('admin.layouts.app')
@section('admin-title')
    Edit Book For QR
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Book For QR</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/qr-books') }}">My QR Books</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Book </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Book Generated For QR</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/qr-books/{{$book->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')   
                            
                            <div class="form-group row">
                                <label for="book_id" class="col-md-4 col-form-label">{{ __('Book ID') }}</label>

                                <div class="col-md-8">
                                    <input id="book_id" name="book_id" type="text" class="form-control @error('book_id') is-invalid @enderror" value="{{ old('book_id') ?? $book->book->id ?? '' }}" readonly autocomplete="book_id" >

                                    @error('book_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="publisher" class="col-md-4 col-form-label">{{ __('Book Publisher') }}</label>

                                <div class="col-md-8">
                                    <input id="publisher" name="publisher" type="text" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher') ?? $book->book->category->publisher->name ?? '' }}" autocomplete="publisher" readonly>

                                    @error('publisher')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label">{{ __('Book Category') }}</label>

                                <div class="col-md-8">
                                    <input id="category" name="category" type="text" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') ?? $book->book->category->name ?? '' }}" readonly autocomplete="category" >

                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">{{ __('Book Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $book->book->title ?? '' }}" readonly autocomplete="title" >

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                           
                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Book Author') }}</label>

                                <div class="col-md-8">
                                    <input id="author" name="author" type="text" class="form-control @error('author') is-invalid @enderror" value="{{ old('author') ?? $book->book->author ?? ''}}" readonly>

                                    @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="edition" class="col-md-4 col-form-label">{{ __('Book Edition') }}</label>

                                <div class="col-md-8">
                                    <input id="edition" name="edition" type="text" class="form-control @error('edition') is-invalid @enderror" value="{{ old('edition') ?? $book->book->edition ?? '' }}" readonly >

                                    @error('edition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="published_year" class="col-md-4 col-form-label">{{ __('Published Year') }}</label>

                                <div class="col-md-8">
                                    <input id="published_year" name="published_year" type="text" class="form-control @error('published_year') is-invalid @enderror" value="{{ old('published_year') ?? $book->book->published_year ?? '' }}" readonly>

                                    @error('published_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label">{{ __('Published Book Quantity') }}</label>

                                <div class="col-md-8">
                                    <input id="quantity" name="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror"  value="{{ old('quantity') ?? $book->quantity }}" required >

                                    @error('quantity')
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
