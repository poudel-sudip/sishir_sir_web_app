@extends('admin.layouts.app')
@section('admin-title')
    Batch Videos
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Course Batch Videos</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                <li class="breadcrumb-item active" aria-current="page">Videos</li>
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
                                <button type="button" class="btn btn-outline-info p-4" data-toggle="modal" data-target="#create_video">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    <div class="file-upload-hover">Add New Video</div>
                                </button>
                            </div>

                            @forelse($videos as $video)
                                <div class="col-md-3 col-6 my-1">    
                                    <div class="border p-2 border-info" style="height: 100%">
                                        <div style="cursor: pointer" role="button" class="view-video" data-toggle="modal" data-target="#videoModal" video-title="{{$video->videoTitle}}" video-url="{{$video->videoPath}}" video-id="{{$video->id}}">
                                            <div class="h1 text-info"><i class="fa fa-video-camera"></i></div>
                                            <h4>{{$video->videoTitle}}</h4>
                                        </div>
                                        <div class="text-primary small">By: {{$video->user_name}} <span>on {{$video->created_at}}</span></div>
                                        <div class="mt-2">
                                            <a class="edit-video btn-sm btn-info" href="#edit_video" video-title="{{$video->videoTitle}}" video-url="{{$video->videoPath}}" video-id="{{$video->id}}" data-bs-toggle="modal" data-bs-target="#edit_video" data-toggle="modal" data-target="#edit_video">Edit</a>
                                            <form class="d-inline" id="delete-form-{{$video->id}}" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/videos/{{$video->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn-sm btn-danger" href="javascript:{}" onclick="javascript:deleteData({{$video->id}});" title="Delete">Delete</a>
                                            </form>
                                        </div>
                                    </div>                              
                                </div>
                            @empty
                                <div class="col-md-3 my-2">No Videos Found</div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- for video upload model start--}}
    <div class="modal fade" id="create_video" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Video</h5>
                    <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>

                <div class="modal-body enroll_form">
                    <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/videos" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row my-0">
                            <label for="videotitle" class="col-md-4 col-form-label text-md-right">{{ __('Your Video Title') }}</label>

                            <div class="col-md-8">
                                <input id="videotitle" type="text" class="form-control @error('videotitle') is-invalid @enderror" name="videotitle" value="{{ old('videotitle') }}" autofocus>

                                @error('videotitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-0">
                            <label for="uservideo" class="col-md-4 col-form-label text-md-right">{{ __('Your Video Link') }}</label>

                            <div class="col-md-8">
                                <input id="uservideo" type="text" class="form-control @error('uservideo') is-invalid @enderror" name="uservideo" value="{{ old('uservideo') }}" required>

                                @error('uservideo')
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
    {{-- for video upload model end--}}

    {{-- video Edit Modal HTML --}}
    <div id="edit_video" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Video </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/admin/courses/{{$course->id}}/batches/{{$batch->id}}/videos" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row my-0">
                            <label for="video_id" class="col-md-3 col-form-label">{{ __(' Video ID') }}</label>

                            <div class="col-md-9">
                                <input id="video_id" type="text" class="form-control @error('video_id') is-invalid @enderror" name="video_id" value="{{ old('video_id') }}" required readonly>

                                @error('video_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row my-0">
                            <label for="video_title" class="col-md-3 col-form-label">{{ __(' Video Title') }}</label>

                            <div class="col-md-9">
                                <input id="video_title" type="text" class="form-control @error('video_title') is-invalid @enderror" name="video_title" value="{{ old('video_title') }}" required autofocus>

                                @error('video_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-0">
                            <label for="video_url" class="col-md-3 col-form-label">{{ __(' Video Link') }}</label>

                            <div class="col-md-9">
                                <input id="video_url" type="text" class="form-control @error('video_url') is-invalid @enderror" name="video_url" value="{{ old('video_url') }}">

                                @error('video_url')
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
    {{-- video Edit Modal HTML end --}}

    {{-- for view video model start--}}
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title text-white" id="playingTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="videoPlayer" class="embed-responsive embed-responsive-16by9"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- for view video model end--}}

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
                    'Your record has been deleted.',
                    'success'
                    )
                }
            })
        }
    </script>

    <script>
        // this script is used to prompt edit model
        $(document).ready(function(){
            $('.edit-video').click(function(){
                
                $('#video_id').attr('value','');
                $('#video_title').attr('value','');
                $('#video_url').attr('value','');

                //fetch current data
                let vid = $(this).attr('video-id');
                let vtitle = $(this).attr('video-title');
                let vurl = $(this).attr('video-url');

                //set the value to edit model
                $('#video_id').attr('value',vid);
                $('#video_title').attr('value',vtitle);
                $('#video_url').attr('value',vurl);               

            });
        });
    </script>

   

@endsection
