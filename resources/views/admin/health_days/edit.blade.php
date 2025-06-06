@extends('admin.layouts.app')
@section('admin-title')
    Edit Health Day
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Health Day</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/health-days') }}">Health Days</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Health Day</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Health Day</div>
                    <div class="card-body">
                        <form method="POST" action="{{ ('/admin/health-days/'.$healthDay->id) }}" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="date" class="col-md-12 col-form-label">{{ __('Date') }}</label>

                                <div class="col-md-12">
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') ?? date('Y-m-d', strtotime($healthDay->date)) }}" required autocomplete="date" autofocus>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-12 col-form-label">{{ __('Health Day Title') }}</label>

                                <div class="col-md-12">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $healthDay->title }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pdf_file" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('Pdf File') }}</label>
                                <div class="col-md-12">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file')}}"  autocomplete="pdf_file" >
                                    <input type="hidden" name="old_pdf_file" value="{{$healthDay->pdf_file}}">
                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 col-form-label">{{ __('Description ') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required >{!! old('description') ?? $healthDay->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- <div class="form-group row">
                                <label for="status" class="col-md-12 col-form-label">{{ __(' Status') }}</label>

                                <div class="col-md-12">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required>
                                        <option value="active" {{ $healthDay->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $healthDay->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
