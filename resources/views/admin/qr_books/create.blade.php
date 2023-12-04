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
                                <label for="publisher" class="col-md-4 col-form-label">{{ __('Book Publisher') }}</label>

                                <div class="col-md-8">
                                    <input id="publisher" name="publisher" type="text" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher') }}" required autocomplete="publisher" autofocus>

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
                                    <input id="category" name="category" type="text" class="form-control @error('category') is-invalid @enderror" value="{{ old('category')  }}" required autocomplete="category" >

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
                                    <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required autocomplete="title" >

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>                            
                        
                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label">{{ __('Book Authors') }}</label>

                                <div class="col-md-8">
                                    <input id="author" name="author" type="text" class="form-control @error('author') is-invalid @enderror" value="{{ old('author') ?? auth()->user()->name }}" required>

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
                                    <input id="edition" name="edition" type="text" class="form-control @error('edition') is-invalid @enderror" value="{{ old('edition') }}" >

                                    @error('edition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isbn" class="col-md-4 col-form-label">{{ __('Book ISBN') }}</label>

                                <div class="col-md-8">
                                    <input id="isbn" name="isbn" type="text" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}" >

                                    @error('isbn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pages" class="col-md-4 col-form-label">{{ __('Book Pages') }}</label>

                                <div class="col-md-8">
                                    <input id="pages" name="pages" type="text" class="form-control @error('pages') is-invalid @enderror" value="{{ old('pages') }}" >

                                    @error('pages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="published_year" class="col-md-4 col-form-label">{{ __('Published Year') }}</label>

                                <div class="col-md-8">
                                    <input id="published_year" name="published_year" type="text" class="form-control @error('published_year') is-invalid @enderror" value="{{ old('published_year') }}" >

                                    @error('published_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="availability" class="col-md-4 col-form-label">{{ __('Book Availability') }}</label>

                                <div class="col-md-8">
                                    <select id="availability" class="form-control @error('availability') is-invalid @enderror" name="availability" value="{{ old('availability') }}" required>
                                        <option value="In Stock">In Stock</option>
                                        <option value="Out Of Stock">Out Of Stock</option>
                                    </select>
                                    @error('availability')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label">{{ __('Book Price') }}</label>

                                <div class="col-md-8">
                                    <input id="price" name="price" type="number" class="form-control @error('price') is-invalid @enderror"  value="{{ old('price') ?? 1 }}" required>

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label">{{ __('Book Discount (%)') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" name="discount" type="number" class="form-control @error('discount') is-invalid @enderror"  value="{{ old('discount') ?? 0}}" required >

                                    @error('discount')
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

                            {{-- <div class="form-group row">
                                <label for="purchase_link" class="col-md-4 col-form-label">{{ __('Book Purchase Link') }}</label>

                                <div class="col-md-8">
                                    <input id="purchase_link" name="purchase_link" type="text" class="form-control @error('purchase_link') is-invalid @enderror" value="{{ old('purchase_link') }}" >

                                    @error('purchase_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Book Description') }}</label>

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
                                <label for="thumbnail" class="col-md-4 col-form-label">{{ __('Book Image') }}</label>
                                <div class="col-md-8">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') }}" required >

                                    @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            {{-- <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Book Status') }}</label>

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
                            </div> --}}

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
