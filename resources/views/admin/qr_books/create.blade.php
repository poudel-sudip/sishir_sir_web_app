@extends('admin.layouts.app')
@section('admin-title')
    Create Book For QR Generation
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Book For QR Generation</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/qr-books') }}">QR Books</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Book For QR Generation</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/qr-books" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                                     
                            <div class="form-group row">
                                <label for="book_id" class="col-md-4 col-form-label">{{ __('Book ID') }}</label>

                                <div class="col-md-8">
                                    <input id="book_id" name="book_id" type="text" class="form-control @error('book_id') is-invalid @enderror" value="{{ old('book_id') }}" required autocomplete="book_id" autofocus>

                                    @error('book_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label">{{ __('Book Published Quantity') }}</label>

                                <div class="col-md-8">
                                    <input id="quantity" name="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror"  value="{{ old('quantity') ?? 0}}" required >

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
