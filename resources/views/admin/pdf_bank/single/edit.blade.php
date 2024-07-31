@extends('admin.layouts.app')
@section('admin-title')
    Edit PDF Bank
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit PDF Bank</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-singles') }}">PDF Banks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit PDF Bank </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit PDF Bank</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/pdf-bank/pdf-singles/{{$single->id}}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label">{{ __('Category') }}</label>

                                <div class="col-md-8">
                                    <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required>
                                        <option value="{{$single->category->id ?? ''}}">{{$single->category->name ?? ''}}</option>
                                        <option value="">--------------</option>
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
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $single->title }}" required autocomplete="name" autofocus>

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
                                    <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') ?? $single->author }}" >

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
                                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') ?? $single->price }}" >

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label">{{ __(' Discount') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? $single->discount }}" >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pages" class="col-md-4 col-form-label">{{ __('No. of Pages') }}</label>

                                <div class="col-md-8">
                                    <input id="pages" type="text" class="form-control @error('pages') is-invalid @enderror" name="pages" value="{{ old('pages') ?? $single->pages }}" >

                                    @error('pages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="paper" class="col-md-4 col-form-label">{{ __('Paper') }}</label>

                                <div class="col-md-8">
                                    <input id="paper" type="text" class="form-control @error('paper') is-invalid @enderror" name="paper" value="{{ old('paper') ?? $single->paper }}" >

                                    @error('paper')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pdf_file" class="col-md-4 col-form-label">{{ __('PDF File') }}</label>
                                <div class="col-md-8">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file') ?? $single->pdf_file }}"  >
                                    <input type="hidden" name="old_pdf_file" value="{{$single->pdf_file}}">
                                    <div>
                                        <a href="/storage/{{$single->pdf_file}}" target="_blank"> <i class="fa fa-file-pdf-o text-danger"></i> </a>
                                    </div>
                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="video_file" class="col-md-4 col-form-label">{{ __('Youtube Video Link') }}</label>

                                <div class="col-md-8">
                                    <input id="video_file" type="text" class="form-control @error('video_file') is-invalid @enderror" name="video_file" value="{{ old('video_file') ?? $single->video_file }}" >

                                    @error('video_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Description') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" >{!! old('description') ?? $single->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="can_download" class="col-md-4 col-form-label">{{ __('Can Download') }}</label>
    
                                <div class="col-md-8 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="can_download_1" type="radio" class="form-check-input" name="can_download" value="1"  @if($single->download) checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="can_download_2" type="radio" class="form-check-input" name="can_download" value="0"  @if(!$single->download) checked @endif  >No</label>
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
                                <label for="thumbnail" class="col-md-4 col-form-label">{{ __('Thumbnail Image') }}</label>
                                <div class="col-md-8">
                                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') ?? $single->thumbnail }}"  >
                                    <input type="hidden" name="oldThumbnail" value="{{$single->thumbnail}}">
                                    <img src="/storage/{{$single->thumbnail}}" alt="" height="100px">
                                    @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isPinned" class="col-md-4 col-form-label">{{ __('Is Pinned') }}</label>

                                <div class="col-md-8 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios1" type="radio" class="form-check-input" name="isPinned" value="Yes" @if($single->isPinned=="Yes") checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios2" type="radio" class="form-check-input" name="isPinned" value="No" @if($single->isPinned=="No") checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('isPinned')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                              </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __(' Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $single->status }}" required>
                                        <option value="{{$single->status}}">{{$single->status}}</option>
                                        <option value="">-----------</option>
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
