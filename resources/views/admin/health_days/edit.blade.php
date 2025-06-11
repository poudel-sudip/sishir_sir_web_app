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
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                                <label for="category_id" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Category') }}</label>

                                <div class="col-md-12">
                                    <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" name="category_id" value="{{ old('category_id') }}" >
                                        <option value="">Select Health Day Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{$cat->id}}" {{$cat->id == $healthDay->category_id ? 'selected' : ''}}>{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Date') }}</label>

                                <div class="col-md-12">
                                    <input id="date" type="text" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') ?? $healthDay->date }}" required autocomplete="date" autofocus>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Health Day Title') }}</label>

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
                                <label for="author_name" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Health Day Author') }}</label>

                                <div class="col-md-12">
                                    <input id="author_name" type="text" class="form-control @error('author_name') is-invalid @enderror" name="author_name" value="{{ old('author_name') ?? $healthDay->author_name }}"  autocomplete="author_name" >

                                    @error('author_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="author_image" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('Author Image') }}</label>
                                <div class="col-md-12">
                                    <input id="author_image" type="file" class="form-control @error('author_image') is-invalid @enderror" name="author_image" value="{{ old('author_image') ?? $healthDay->author_image  }}" autocomplete="author_image" accept="image/*" >
                                    @error('author_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pdf_file" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('PDF File') }}</label>
                                <div class="col-md-12">
                                    <input id="pdf_file" type="file" class="form-control @error('pdf_file') is-invalid @enderror" name="pdf_file" value="{{ old('pdf_file') ?? $healthDay->pdf_file  }}" autocomplete="pdf_file" accept=".pdf">
                                    @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sorting_date" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('Sorting Date') }}</label>
                                <div class="col-md-12">
                                    @php($sorting_dates = explode(':',($healthDay->sorting_date ?? '00:00')))
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <select name="sorting_month" id="sorting_month" class="form-control" required>
                                                @foreach ($sorting_month as $k=>$v)
                                                    <option value="{{$k}}" {{$sorting_dates[0] == $k ? 'selected' : ''}} >{{$v}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="ml-2">
                                            <select name="sorting_date" id="sorting_date" class="form-control" required>
                                                @for ($i=1;$i<=32;$i++)
                                                    <option value="{{ sprintf('%02d', $i) }}" {{$sorting_dates[1] == sprintf('%02d', $i) ? 'selected' : ''}}>{{ sprintf('%02d', $i) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>                                    
                                    @error('sorting_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-12 pb-0 mb-0 col-form-label">{{ __('Description ') }}</label>

                                <div class="col-md-12">
                                    <textarea id="description" class="form-control summernote @error('description') is-invalid @enderror" name="description" required >{!! old('description') ?? $healthDay->description !!}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="thumbnail_image" class="col-sm-12 pb-0 mb-0 col-form-label">{{ __('Thumbnail Image') }}</label>
                                <div class="col-md-12">
                                    <input id="thumbnail_image" type="file" class="form-control @error('thumbnail_image') is-invalid @enderror" name="thumbnail_image" value="{{ old('thumbnail_image') ?? $healthDay->thumbnail_image  }}" autocomplete="thumbnail_image" accept="image/*" >
                                    @error('thumbnail_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>                           

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
