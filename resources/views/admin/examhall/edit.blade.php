@extends('admin.layouts.app')
@section('admin-title')
    Edit Exam Set : {{$category->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Exam Set : {{$category->title}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exam-hall') }}">Exam Sets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Sets </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Exam Sets : {{$category->title}} </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/exam-hall/{{$category->id }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="categoryID" class="col-md-5 col-form-label">{{ __('Exam Set ID') }}</label>

                                <div class="col-md-7">
                                    <input id="categoryID" type="text" class="form-control @error('categoryID') is-invalid @enderror" name="categoryID" value="{{ old('categoryID') ?? $category->id }}" required readonly>

                                    @error('categoryID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-5 col-form-label">{{ __('Exam Set Name') }}</label>

                                <div class="col-md-7">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $category->title }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-5 col-form-label">{{ __('Exam Set Price') }} </label>

                                <div class="col-md-7">
                                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') ?? $category->price }}" placeholder="100">

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="discount" class="col-md-5 col-form-label">{{ __('Exam Set Discount') }} </label>

                                <div class="col-md-7">
                                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? $category->discount ?? 0 }}" placeholder="0">

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isPinned" class="col-md-5 col-form-label">{{ __('Is Pinned') }}</label>

                                <div class="col-md-7 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios1" type="radio" class="form-check-input" name="isPinned" value="Yes" @if($category->isPinned=="Yes") checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios2" type="radio" class="form-check-input" name="isPinned" value="No" @if($category->isPinned=="No") checked @endif>No</label>
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
                                <label for="description" class="col-md-12 col-form-label">{{ __('Exam Set Description') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required autocomplete="description" >{!! old('description') ?? $category->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}</label>
                                <div class="col-md-2 pt-2">
                                    <img src="/storage/{{$category->image}}" height="40">
                                </div>
                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" >
                                    <input type="hidden" name="oldImage" value="{{$category->image}}">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-5 col-form-label">{{ __('Exam Set Status') }}</label>

                                <div class="col-md-7">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $category->status }}" required>
                                        <option value="{{$category->status}}">{{$category->status}}</option>
                                        <option value="">--------</option>
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
