@extends('admin.layouts.app')
@section('admin-title')
    Batch Files
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Course Batch Files</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                <li class="breadcrumb-item active" aria-current="page">Files</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h5 text-primary"> {{optional($batch->course)->name}} </div>
                        <div class="h4 text-info"> {{$batch->name}} </div>
                        <hr class="bg-info">
                        <div class="mt-4 row align-items-stretch">
                            <div class="col-md-3 col-12 my-1 align-self-center">
                                <button type="button" class="btn btn-outline-info p-4" data-toggle="modal" data-target="#create_file">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    <div class="file-upload-hover">Add New File</div>
                                </button>
                            </div>

                            @forelse($files as $pdf)
                                <div class="col-md-3 col-6 my-1">    
                                    <div class="border p-2 border-info" style="height: 100%">
                                        <div style="cursor: pointer" role="button" class="file-view-btn" data-toggle="modal" data-target="#view_file" file-title="{{$pdf->fileTitle}}" file-url="{{$pdf->filePath}}" file-id="{{$pdf->id}}">
                                            <div class="h1 text-danger"><i class="fa fa-file-pdf-o"></i></div>
                                            <h4>{{$pdf->fileTitle}}</h4>
                                        </div>
                                        <div class="text-primary small">By: {{$pdf->user_name}} <span>on {{$pdf->created_at}}</span></div>
                                        <div class="mt-2">
                                            <a class="edit-file btn-sm btn-info" href="#edit_file" file-title="{{$pdf->fileTitle}}" file-url="{{$pdf->filePath}}" file-id="{{$pdf->id}}" data-bs-toggle="modal" data-bs-target="#edit_file" data-toggle="modal" data-target="#edit_file">Edit</a>
                                            <form class="d-inline" id="delete-form-{{$pdf->id}}" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/files/{{$pdf->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn-sm btn-danger" href="javascript:{}" onclick="javascript:deleteData({{$pdf->id}});" title="Delete">Delete</a>
                                            </form>
                                        </div>
                                    </div>                              
                                </div>
                            @empty
                                <div class="col-md-3 my-2">No Files Found</div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- for file upload model start--}}
    <div class="modal fade" id="create_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>

                <div class="modal-body enroll_form">
                    <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/files" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row my-0">
                            <label for="filetitle" class="col-md-4 col-form-label text-md-right">{{ __('Your File Title') }}</label>

                            <div class="col-md-8">
                                <input id="filetitle" type="text" class="form-control @error('filetitle') is-invalid @enderror" name="filetitle" value="{{ old('filetitle') }}" autofocus>

                                @error('filetitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-0">
                            <label for="userfile" class="col-md-4 col-form-label text-md-right">{{ __('Your File') }}</label>

                            <div class="col-md-8">
                                <input id="userfile" type="file" class="form-control @error('userfile') is-invalid @enderror" name="userfile" value="{{ old('userfile') }}" required accept=".pdf">

                                @error('userfile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-0">
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
    {{-- for file upload model end--}}

    {{-- File Edit Modal HTML --}}
    <div id="edit_file" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Edit File </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/files" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row my-0">
                            <label for="file_id" class="col-md-3 col-form-label">{{ __(' File ID') }}</label>

                            <div class="col-md-9">
                                <input id="file_id" type="text" class="form-control @error('file_id') is-invalid @enderror" name="file_id" value="{{ old('file_id') }}" required readonly>

                                @error('file_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row my-0">
                            <label for="file_title" class="col-md-3 col-form-label">{{ __(' File Title') }}</label>

                            <div class="col-md-9">
                                <input id="file_title" type="text" class="form-control @error('file_title') is-invalid @enderror" name="file_title" value="{{ old('file_title') }}" required autofocus>

                                @error('file_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-0">
                            <label for="new_file" class="col-md-3 col-form-label">{{ __(' File') }}</label>

                            <div class="col-md-9">
                                <input id="new_file" type="file" class="form-control @error('new_file') is-invalid @enderror" name="new_file" value="{{ old('new_file') }}">
                                <input type="hidden" id="old_file" name="old_file" value="{{ old('old_file') }}">
                                @error('new_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-0">
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
    {{-- File Edit Modal HTML end --}}

    {{-- for view file model start--}}
    <div class="modal fade" id="view_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="file-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="file-image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- for view file model end--}}



    <script type="text/javascript">
        function deleteData(id)
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-'+id).submit();
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
            })
        }
    </script>

    <script>
        // this script is used to prompt edit model
        $(document).ready(function(){
            $('.edit-file').click(function(){
                
                //clear previous data
                $('#file_id').attr('value','');
                $('#file_title').attr('value','');
                $('#old_file').attr('value','');

                //fetch current data
                let fid = $(this).attr('file-id');
                let ftitle = $(this).attr('file-title');
                let furl = $(this).attr('file-url');

                //set the value to edit model
                $('#file_id').attr('value',fid);
                $('#file_title').attr('value',ftitle);
                $('#old_file').attr('value',furl);

            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.file-view-btn').click(function(){
                
                //clear previous data
                $('#file-title').html('');
                $('#file-image').html('');

                let fid = $(this).attr('file-id');
                let ftitle = $(this).attr('file-title');
                let furl = $(this).attr('file-url');

                $('#file-title').html(ftitle);
                $('#file-image').append(
                    // '<iframe src="'+furl+'" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>'
                    `<object data="`+furl+`"
                    type="application/pdf"
                    width="100%"
                    height="450">
                        <iframe
                        src="`+furl+`"
                        width="100%"
                        height="100%"
                        style="border: none">
                            <p>
                                Your browser does not support PDFs.
                                <a href="`+furl+`">Download the PDF</a>
                            </p>
                        </iframe>
                    </object>`
                );
                
            });
        })
    </script>

@endsection
