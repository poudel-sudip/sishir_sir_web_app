@extends('publishers.layouts.app')
@section('admin-title')
    Create Chapter Files | {{$chapter->title}} 
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Chapter Files| {{$chapter->title}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/publisher/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/publisher/ebooks/all') }}">E-Book</a></li>
                <li class="breadcrumb-item"><a href="/publisher/ebooks/{{$ebook->id}}/chapters">Chapters</a></li>
                <li class="breadcrumb-item"><a href="/publisher/ebooks/{{$ebook->id}}/chapters/{{$chapter->id}}/files">Chapters</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Chapter Files </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Create Chapter Files| {{$chapter->title}}</div>
                    <div class="card-body">
                        <form method="POST" action="/publisher/ebooks/{{$ebook->id}}/chapters/{{$chapter->id}}/files" enctype="multipart/form-data" class="forms-sample">
                            @csrf

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Upload Image') }}</label>
                                <div class="col-md-8">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" >

                                    @error('image')
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
