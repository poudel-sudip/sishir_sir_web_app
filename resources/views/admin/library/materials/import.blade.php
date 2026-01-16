@extends('admin.layouts.app')
@section('admin-title')
    Import eLibrary PDF File | {{$category->name}} 
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Import eLibrary PDF File | {{$category->name}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/library') }}">eLibrary</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/library/'.$category->id.'/directories') }}">{{ucwords($category->name)}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Import </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Import eLibrary  PDF File | {{$category->name}} </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/library/{{$category->id}}/materials/import" enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            @method('PATCH')

                            {{-- <div class="form-group row">
                                <label for="main_library" class="col-md-4 col-form-label">{{ __('eLibrary') }}</label>
                                <div class="col-md-8">
                                    <select name="main_library" id="main_library" class="form-control @error('main_library') is-invalid @enderror" value="{{ old('main_library') }}" autofocus required>
                                        <option value="">Select A File Library</option>
                                        @foreach($libraries as $cat)
                                            <option value="{{$cat->id}}"> {{$cat->name}} </option>
                                        @endforeach
                                    </select>
                                    @error('main_library')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="library_group" class="col-md-4 col-form-label">{{ __('eLibrary Group') }}</label>
                                <div class="col-md-8">
                                    <select name="library_group" id="library_group" class="form-control @error('library_group') is-invalid @enderror" value="{{ old('library_group') }}" autofocus required>
                                        <option value="">Select A eLibrary Group</option>
                                        @foreach($libraries as $cat=>$val)
                                            <option value="{{$cat}}"> {{$cat}} </option>
                                        @endforeach
                                    </select>
                                    @error('library_group')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="main_library" class="col-md-4 col-form-label">{{ __('eLibrary') }}</label>
                                <div class="col-md-8">
                                    <select name="main_library" id="main_library" class="form-control @error('main_library') is-invalid @enderror" value="{{ old('main_library') }}" autofocus required>
                                    </select>
                                    @error('main_library')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sub_library" class="col-md-4 col-form-label">{{ __('Sub eLibrary') }}</label>
            
                                <div class="col-md-8">
                                    <select name="sub_library" id="sub_library" class="form-control @error('sub_library') is-invalid @enderror" value="{{ old('sub_library') }}"  >
                                    </select>
                                    @error('sub_library')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="pdf_files" class="col-md-4 col-form-label">{{ __('PDF Files') }}</label>
            
                                <div class="col-md-8">
                                        <select name="pdf_files[]" id="pdf_files" class="form-control @error('pdf_files') is-invalid @enderror" value="{{ old('pdf_files') }}" required multiple size="10" >
                                    </select>
                                    @error('pdf_files')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Copy Files') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            const libraries = @json($libraries);

            $(document).on('change', '#library_group', function() {
                $('#main_library').html("");
                $('#sub_library').html("");
                $('#pdf_files').html("");

                var label = $(this).val();
                var mat_libs = libraries[label];

                // var op='';
                var op='<option value=""> Select One Main eLibrary </option>';
                mat_libs.forEach((row) => {
                    op += '<option value="' + row.id + '">' + row.name + '</option>';
                });
                $('#main_library').append(op);
            });

            $(document).on('change', '#main_library', function() {
                var cat_id = $(this).val();
                $('#sub_library').html("");
                $('#pdf_files').html("");
                if(cat_id)
                {
                    get_files(cat_id);                
                }
            });

            $(document).on('change', '#sub_library', function() {
                var group_id = $(this).val();
                $('#pdf_files').html("");
                if(group_id)
                {
                    get_files(group_id);                
                }              
            });


            function get_files(id)
            {
                var op='';
                var request = new XMLHttpRequest();
                request.open('GET', '/admin/library/'+id+'/get-sub-materials', true);
                request.onload = function () {
                    if(request.status >= 200 && request.status < 400) 
                    {
                        var data = JSON.parse(this.response);
                        var sub_libs = data.sub_libraries;
                        var pdf_files = data.pdf_files;

                        if(sub_libs.length)
                        {
                            op='<option value=""> Select One Sub eLibrary </option>';
                            sub_libs.forEach((row) => {
                                op += '<option value="' + row.id + '">' + row.name + '</option>';
                            });
                            $('#sub_library').append(op);

                            op = '';
                        }

                        if(pdf_files.length)
                        {
                            pdf_files.forEach((row) => {
                                op += '<option value="' + row.id + '">' + row.name + '</option>';
                            });
                            $('#pdf_files').append(op);

                            op = '';
                        }

                        // console.log(sub_libs.length);
                        // console.log(pdf_files.length);                        
                    }
                };
                request.send();
            }

        });
    </script>


@endsection
