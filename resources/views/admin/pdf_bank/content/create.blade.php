@extends('admin.layouts.app')
@section('admin-title')
    Add PDF File | {{$group->title}} 
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add PDF File | {{$group->title}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-groups') }}">PDF Banks</a></li>
                <li class="breadcrumb-item"><a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files">Contents</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add PDF File | {{$group->title}} </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files" enctype="multipart/form-data" class="forms-sample">
                            @csrf

                            {{-- <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">{{ __('PDF Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Chapter-1" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">{{ __('PDF File Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" >

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pdf_file" class="col-md-4 col-form-label">{{ __('PDF File') }}</label>
                                
                                <div class="col-md-8">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file') }}" >

                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('File Status') }}</label>

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
