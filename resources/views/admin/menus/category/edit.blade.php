@extends('admin.layouts.app')
@section('admin-title')
    Edit Menu Menu Category
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Menu Menu Category</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Menu Item Category | {{$subgroup->name}} | {{$group->name}}</div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">{{ __('Menu Category Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $category->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="order" class="col-sm-4 col-form-label">{{ __('Category Order') }}</label>
                            <div class="col-md-8">
                                <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') ?? $category->order }}" required autocomplete="order" >
                                @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label">{{ __('Category Type') }}</label>
                            <div class="col-md-8">
                                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required>
                                    <option value="{{$category->type}}">{{ucwords($category->type)}}</option>
                                    <option value="">-------------------</option>
                                    <option value="heading">Heading</option>
                                    <option value="text">Text</option>
                                    <option value="file">File</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-sm-4 col-form-label">{{ __('Category File') }}</label>
                            <div class="col-md-8">
                                <small>{{$category->filename}}</small>
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file')}}"  autocomplete="file" >
                                <input type="hidden" name="old_file" value="{{$category->fileurl}}">
                                <input type="hidden" name="filename" value="{{$category->filename}}">
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
                                        <input id="membershipRadios1" type="radio" class="form-check-input" name="can_download" value="1" @if($category->download) checked @endif >Yes</label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input id="membershipRadios2" type="radio" class="form-check-input" name="can_download" value="0" @if(!$category->download) checked @endif>No</label>
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
                            <label for="description" class="col-sm-4 col-form-label">{{ __('Category Description') }}</label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror">{{old('description') ?? $category->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="thumbnail" class="col-sm-4 col-form-label">Thumbnail <small>(875*667 : 300kb)</small></label>
                            <div class="col-md-8">
                                <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') ?? $category->thumbnail  }}" autocomplete="thumbnail" >
                                <input type="hidden" name="old_thumbnail" value="{{$category->thumbnail}}">
                                @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="search_tags" class="col-md-4 col-form-label">{{ __('Search Tags') }}</label>

                            <div class="col-md-8">
                                <input id="search_tags" type="text" class="form-control @error('search_tags') is-invalid @enderror" name="search_tags" value="{{ old('search_tags') ?? $category->search_tags }}" autocomplete="search_tags">

                                @error('search_tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">{{ __('Category Status') }}</label>
                            <div class="col-md-8">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                    <option value="{{$category->status}}">{{$category->status}}</option>
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
