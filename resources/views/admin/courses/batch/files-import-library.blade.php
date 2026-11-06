@extends('admin.layouts.app')
@section('admin-title')
    Import Library Material PDF File  
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Import Library PDF Files </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/files') }}">Files</a></li>
                <li class="breadcrumb-item active" aria-current="page">Import Library</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Import Library Material PDF File | {{$batch->name}} </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/files/import-library" enctype="multipart/form-data" class="forms-sample">
                            @csrf

                            <div class="form-group row">
                                <label for="batch_name" class="col-sm-4 col-form-label">Batch Name</label>
                                <div class="col-sm-8">
                                <input id="batch_name" type="text" class="form-control @error('batch_name') is-invalid @enderror" name="batch_name" value="{{ old('batch_name') ?? $batch->name }}" required autocomplete="batch_name" readonly>

                                @error('batch_name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="unit_id" class="col-sm-4 col-form-label">Unit Id</label>
                                <div class="col-sm-8">
                                <input id="unit_id" type="text" class="form-control @error('unit_id') is-invalid @enderror" name="unit_id" value="{{ old('unit_id') ?? $unit->id ?? null }}" required autocomplete="unit_id" readonly>

                                @error('unit_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="main_library" class="col-md-4 col-form-label">{{ __('Material Library') }}</label>
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
                            </div>
            
                            <div class="form-group row">
                                <label for="sub_library" class="col-md-4 col-form-label">{{ __('Material Sub Library') }}</label>
            
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
            $(document).on('change', '#main_library', function() {
                var cat_id = $(this).val();
                $('#sub_library').html("");
                $('#pdf_files').html("");
                get_files(cat_id);                
            });

            $(document).on('change', '#sub_library', function() {
                var group_id = $(this).val();
                $('#pdf_files').html("");
                get_files(group_id);                
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
                            op='<option value=""> Select One Sub Library </option>';
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
