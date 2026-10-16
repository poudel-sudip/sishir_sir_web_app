@extends('admin.layouts.app')
@section('admin-title')
    Import Menu PDF File  
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Import Menu PDF Files </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/files') }}">Files</a></li>
                <li class="breadcrumb-item active" aria-current="page">Import Menu</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Import Menu PDF File | {{$batch->name}} </div>
                    <div class="card-body">
                        <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/files/import-menu" enctype="multipart/form-data" class="forms-sample">
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
                                <label for="menu_group" class="col-md-4 col-form-label">{{ __('Menu Group') }}</label>
                                <div class="col-md-8">
                                    <select name="menu_group" id="menu_group" class="form-control @error('menu_group') is-invalid @enderror" value="{{ old('menu_group') }}" autofocus required>
                                        <option value="">Select A Menu Group</option>
                                        @foreach($menu_groups as $cat)
                                            <option value="{{$cat->id}}"> {{$cat->name}} </option>
                                        @endforeach
                                    </select>
                                    @error('menu_group')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="menu_sub_group" class="col-md-4 col-form-label">{{ __('Menu Sub Group') }}</label>
            
                                <div class="col-md-8">
                                        <select name="menu_sub_group" id="menu_sub_group" class="form-control @error('menu_sub_group') is-invalid @enderror" value="{{ old('menu_sub_group') }}"  >
                                    </select>
                                    @error('menu_sub_group')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="menu_category" class="col-md-4 col-form-label">{{ __('Menu Category') }}</label>
            
                                <div class="col-md-8">
                                        <select name="menu_category" id="menu_category" class="form-control @error('menu_category') is-invalid @enderror" value="{{ old('menu_category') }}"  >
                                    </select>
                                    @error('menu_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="menu_item" class="col-md-4 col-form-label">{{ __('Menu Item') }}</label>
            
                                <div class="col-md-8">
                                        <select name="menu_item" id="menu_item" class="form-control @error('menu_item') is-invalid @enderror" value="{{ old('menu_item') }}"  >
                                    </select>
                                    @error('menu_item')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="file_source" class="col-md-4 col-form-label">{{ __('Current File Source') }}</label>
            
                                <div class="col-md-8">
                                    <input type="text" name="file_source" id="file_source" class="form-control @error('file_source') is-invalid @enderror" value="{{old('file_source')}}" readonly required>
                                    @error('file_source')
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
            $(document).on('change', '#menu_group', function() {
                var id = $(this).val();
                $('#menu_sub_group').html("");
                $('#menu_category').html("");
                $('#menu_item').html("");
                $('#pdf_files').html("");
                $('#file_source').val("");
                
                var url = `/admin/menus/groups/${id}/filejson`;
                get_files(url);                
            });

            $(document).on('change', '#menu_sub_group', function() {
                var id = $(this).val();
                $('#menu_category').html("");
                $('#menu_item').html("");
                $('#pdf_files').html("");
                $('#file_source').val("");
                
                var url = `/admin/menus/groups/sub-groups/${id}/filejson`;
                get_files(url);                
            });

            $(document).on('change', '#menu_category', function() {
                var id = $(this).val();
                $('#menu_item').html("");
                $('#pdf_files').html("");
                $('#file_source').val("");
                
                var url = `/admin/menus/groups/sub-groups/categories/${id}/filejson`;
                get_files(url);                
            });

            $(document).on('change', '#menu_item', function() {
                var id = $(this).val();
                $('#pdf_files').html("");
                $('#file_source').val("");
                
                var url = `/admin/menus/groups/sub-groups/categories/items/${id}/filejson`;
                get_files(url);                
            });

            function get_files(url)
            {
                $('#file_source').val("");
                $('#pdf_files').html("");

                var op='';
                var request = new XMLHttpRequest();
                request.open('GET', url, true);
                request.onload = function () {
                    if(request.status >= 200 && request.status < 400) 
                    {
                        var data = JSON.parse(this.response);
                        var source = data.source;
                        var sub_groups = data.sub_groups;
                        var menu_categories = data.menu_categories;
                        var menu_items = data.menu_items;
                        var pdf_files = data.pdf_files;

                        if(!source)
                        {
                            return;
                        }

                        $('#file_source').val(source);

                        if(sub_groups && sub_groups.length)
                        {
                            op='';
                            $('#menu_sub_group').html("");
                            op='<option value=""> Select One Sub Menu Group </option>';
                            sub_groups.forEach((row) => {
                                op += '<option value="' + row.id + '">' + row.name + '</option>';
                            });
                            $('#menu_sub_group').append(op);
                            op = '';
                        }

                        if(menu_categories && menu_categories.length)
                        {
                            op='';
                            $('#menu_category').html("");
                            op='<option value=""> Select One Menu Category </option>';
                            menu_categories.forEach((row) => {
                                op += '<option value="' + row.id + '">' + row.name + '</option>';
                            });
                            $('#menu_category').append(op);
                            op = '';
                        }

                        if(menu_items && menu_items.length)
                        {
                            op='';
                            $('#menu_item').html("");
                            op='<option value=""> Select One Menu Item </option>';
                            menu_items.forEach((row) => {
                                op += '<option value="' + row.id + '">' + row.name + '</option>';
                            });
                            $('#menu_item').append(op);
                            op = '';
                        }

                        if(pdf_files.length)
                        {
                            op = '';
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
