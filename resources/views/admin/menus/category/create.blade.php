@extends('admin.layouts.app')
@section('admin-title')
    Create Menu Category
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Menu Category</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Menu Item Category | {{$subgroup->name}} | {{$group->name}}</div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">{{ __('Menu Category Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
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
                                <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') ?? 1  }}" required autocomplete="order" >
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
                                    <option value="heading">Heading</option>
                                    <option value="file">File</option>
                                    <option value="text">Text</option>
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
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') ?? 1  }}" autocomplete="file" >
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label">{{ __('Description') }}</label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
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
                                <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{ old('thumbnail') ?? 1  }}" autocomplete="thumbnail" >
                                @error('thumbnail')
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
