@extends('admin.layouts.app')
@section('admin-title')
    Import Library Material PDF File | {{$group->title}} 
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Import Library Material PDF File | {{$group->title}} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-groups') }}">eBooks</a></li>
                <li class="breadcrumb-item"><a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files">Contents</a></li>
                <li class="breadcrumb-item active" aria-current="page">Import </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Import Library Material PDF File | {{$group->title}} </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/copy-singles" enctype="multipart/form-data" class="forms-sample">
                            @csrf
            
                            <div class="form-group row">
                                <label for="pdf_bank_set" class="col-md-4 col-form-label">{{ __('eBook Set') }}</label>

                                <div class="col-md-8">
                                    <input id="pdf_bank_set" type="text" class="form-control @error('pdf_bank_set') is-invalid @enderror" name="pdf_bank_set" value="{{ old('pdf_bank_set') ?? $group->title }}" readonly>

                                    @error('pdf_bank_set')
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
                                        @foreach($singles as $row)
                                            <option value="{{$row->id}}">{{$row->title}}</option>
                                        @endforeach
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
