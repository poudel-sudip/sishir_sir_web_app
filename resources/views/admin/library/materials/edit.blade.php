@extends('admin.layouts.app')
@section('admin-title')
    Edit Library Material
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Library Material</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/library') }}">Library</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/library/'.$category->id.'/directories') }}">{{ucwords($category->name)}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Library Material | {{$category->name}}</div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/library/{{$category->id}}/materials/{{$material->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">{{ __('Material Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $material->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="order" class="col-sm-4 col-form-label">{{ __('Material Order') }}</label>
                            <div class="col-md-8">
                                <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') ?? $material->order }}" required autocomplete="order" >
                                @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label">{{ __('Material Type') }}</label>
                            <div class="col-md-8">
                                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required>
                                    <option value="{{$material->type}}">{{ucwords($material->type)}}</option>
                                    {{-- <option value="">-------------------</option>
                                    <option value="text">Text</option>
                                    <option value="file">File</option> --}}
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-sm-4 col-form-label">{{ __('Material File') }}</label>
                            <div class="col-md-8">
                                <small>{{$material->filename}}</small>
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file')}}"  autocomplete="file" >
                                <input type="hidden" name="old_file" value="{{$material->fileurl}}">
                                <input type="hidden" name="filename" value="{{$material->filename}}">
                                @error('file')
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
                                        <input id="membershipRadios1" type="radio" class="form-check-input" name="can_download" value="1" @if($material->download) checked @endif >Yes</label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input id="membershipRadios2" type="radio" class="form-check-input" name="can_download" value="0" @if(!$material->download) checked @endif>No</label>
                                    </div>
                                </div>
                                @error('can_download')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label">{{ __('Material Description') }}</label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror">{{old('description') ?? $material->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="thumbnail" class="col-sm-4 col-form-label">Thumbnail <small>(875*667 : 300kb)</small></label>
                            <div class="col-md-8">
                                <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') ?? $material->thumbnail  }}" autocomplete="thumbnail" >
                                <input type="hidden" name="old_thumbnail" value="{{$material->thumbnail}}">
                                @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">{{ __('Material Status') }}</label>
                            <div class="col-md-8">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                    <option value="{{$material->status}}">{{$material->status}}</option>
                                    <option value="">-------------------</option>
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
                            <div class="col-md-4 offset-md-4">
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
