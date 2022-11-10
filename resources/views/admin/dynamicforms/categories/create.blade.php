@extends('admin.layouts.app')
@section('admin-title')
    Create Form Category
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Form Category</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/dynamic-forms/categories') }}">Form Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Category </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add Form Category</div>
                    <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/dynamic-forms/categories" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="group" class="col-sm-4 col-form-label">{{ __('Form group') }}</label>
                            <div class="col-md-8">
                                <select id="group" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ old('group') }}">
                                    <option value="">Select a Form Group</option>
                                    @foreach($groups as $group)
                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </select>
                                @error('group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">{{ __('Category Name') }}</label>
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

                        <div class="form-group my-3">
                            <div class="card-header text-center">Form Details</div>
                        </div>

                        <div class="form-group row">
                            <label for="form_title" class="col-sm-4 col-form-label">{{ __('Form Title') }}</label>
                            <div class="col-md-8">
                                <input id="form_title" type="text" class="form-control @error('form_title') is-invalid @enderror" name="form_title" value="{{ old('form_title') }}"  autocomplete="form_title">
                                @error('form_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="banner" class="col-md-4 col-form-label">{{ __('Form Banner Image') }}</label>
                            <div class="col-md-8">
                                <input id="banner" type="file" class="form-control @error('banner') is-invalid @enderror" name="banner" value="{{ old('banner') }}" >

                                @error('banner')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group my-3">
                            <div class="card-header text-center">Form Elements</div>
                        </div>

                        <div class="form-group text-center my-3">
                         
                            <div class="d-inline-block text-center border">
                                <input type="checkbox" name="element_name" id="element_name">
                                <label for="element_name">Name</label>
                            </div>

                            <div class="d-inline-block text-center border">
                                <input type="checkbox" name="element_email" id="element_email">
                                <label for="element_email">Email</label>
                            </div>

                            <div class="d-inline-block text-center border">
                                <input type="checkbox" name="element_contact" id="element_contact">
                                <label for="element_contact">Contact</label>
                            </div>

                            <div class="d-inline-block text-center border">
                                <input type="checkbox" name="element_provience" id="element_provience">
                                <label for="element_provience">Provience</label>
                            </div>

                            <div class="d-inline-block text-center border">
                                <input type="checkbox" name="element_photo" id="element_photo">
                                <label for="element_photo">Photo</label>
                            </div>

                            <div class="d-inline-block text-center border">
                                <input type="checkbox" name="element_file" id="element_file">
                                <label for="element_file">File</label>
                            </div>

                            <div class="d-inline-block text-center border">
                                <input type="checkbox" name="element_message" id="element_message">
                                <label for="element_message">Message</label>
                            </div>
                            
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
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
