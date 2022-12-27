@extends('admin.layouts.app')
@section('admin-title')
    Edit Menu Item
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Menu Item</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Groups</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/items') }}">Items</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Menu Item | {{$subgroup->name}} | {{$group->name}}</div>
                  <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/items/{{$item->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ __('Item Name') }}</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $item->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="order" class="col-sm-3 col-form-label">{{ __('Item Order') }}</label>
                            <div class="col-md-9">
                                <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') ?? $item->order ?? 1 }}" required autocomplete="order">
                                @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-sm-3 col-form-label">{{ __('Item Type') }}</label>
                            <div class="col-md-9">
                                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') ?? $item->type }}" required>
                                    <option value="{{$item->type}}">{{$item->type}}</option>
                                    <option value="">-----------------</option>
                                    <option value="file">file</option>
                                    <option value="text">text</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-sm-3 col-form-label">{{ __('Item File') }}</label>
                            <div class="col-md-9">
                                <small>{{$item->filename}}</small>
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file')}}"  autocomplete="file" >
                                <input type="hidden" name="old_file" value="{{$item->fileurl}}">
                                <input type="hidden" name="filename" value="{{$item->filename}}">
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label">{{ __('Item Description') }}</label>
                            <div class="col-md-9">
                                <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror">{{old('description') ?? $item->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">{{ __('Item Status') }}</label>
                            <div class="col-md-9">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                    <option value="{{$item->status}}">{{$item->status}}</option>
                                    <option value="">-----------------------</option>
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
                            <div class="col-md-6 offset-md-3">
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
