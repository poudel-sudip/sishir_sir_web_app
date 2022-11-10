@extends('admin.layouts.app')
@section('admin-title')
    Upload Audio | {{ucwords($category->name)}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Upload Audio | {{ucwords($category->name)}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/audios') }}">Audio Categories</a></li>
              <li class="breadcrumb-item"><a href="/admin/audios/{{$category->id}}/files">Audios</a></li>
              <li class="breadcrumb-item active" aria-current="page">Upload Audio</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Upload New Audio | {{ucwords($category->name)}} </div>

                    <div class="card-body">
                        <form id="fileUploadForm" method="POST" action="/admin/audios/{{$category->id}}/files" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="file" class="col-md-12 col-form-label">{{ __('Choose Audio File') }} <br> <small>(Only MP3 or OGG Files less than 3MB)</small></label>

                                <div class="col-md-12">
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required>
                                    
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>

                                    @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-2">
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <script>
        
        $(document).ready(function () {
            
            $('#fileUploadForm').ajaxForm({
                beforeSend: function () {
                    var percentage = '0';
                    // alert("hello");
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage+'%', function() {
                        return $(this).attr("aria-valuenow", percentage + "%");
                    }).html(percentage + "%")
                },
                complete: function (xhr) {
                    // console.log(xhr);
                    // alert(xhr.responseText);
                    Swal.fire({
                        title: xhr.responseJSON.success,
                        icon: 'success',
                        showConfirmButton: true,
                    }).then((result)=>{
                        window.location.replace("/admin/audios/{{$category->id}}/files");
                    });
                }
            });
        });
      

        
    </script>

@endsection
