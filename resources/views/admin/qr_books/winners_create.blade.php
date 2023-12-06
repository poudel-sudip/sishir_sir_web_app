@extends('admin.layouts.app')
@section('admin-title')
    Create QR Book Winner
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add QR Book Winner</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/qr-books') }}">QR Books</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/qr-books/'.$book->id.'/winners') }}">Winners</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add QR Book Winner </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/qr-books/{{$book->id}}/winners" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                                     
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
                                <label for="book_title" class="col-md-4 col-form-label">{{ __('Book Title') }}</label>

                                <div class="col-md-8">
                                    <input id="book_title" name="book_title" type="text" class="form-control @error('book_title') is-invalid @enderror" value="{{ old('book_title') ?? $book->book->title ?? '' }}" readonly autocomplete="book_title" >

                                    @error('book_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="book_link" class="col-md-4 col-form-label">{{ __('Book Winner Link') }}</label>

                                <div class="col-md-8">
                                    <input id="book_link" name="book_link" type="text" class="form-control @error('book_link') is-invalid @enderror"  value="{{ old('book_link') }}" required autofocus>

                                    @error('book_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>                           

                            <div class="form-group row">
                                <label for="winner_type" class="col-md-4 col-form-label">{{ __('Book Winner Type') }}</label>

                                <div class="col-md-8">
                                    <select name="winner_type" id="winner_type" class="form-control @error('winner_type') is-invalid @enderror"  value="{{ old('winner_type') }}" required>
                                        <option value="Book-Winner">Book-Winner</option>
                                        <option value="Full-Course-Winner">Full-Course-Winner</option>
                                        <option value="Half-Course-Winner">Half-Course-Winner</option>
                                    </select>
                                    @error('winner_type')
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
