@extends($header)
@section('student-title')
    Classroom Videos
@endsection
@section('student-title-icon')
    <i class="fas fa-video"></i>
@endsection

@section('content')

    <div class="student-content-wrapper chatroom-section content-wrapper">
        @if (session('status'))
        <span class="alert alert-success" role="alert">
            {{ session('status') }}
        </span>
        @endif
        <div class="row">
            <div class="col-md-12 text-center">
                <h6>{{$batch->name}} @if($batch->timeSlot) <span>({{ $batch->timeSlot ?? ''}})</span> @endif </h6>        
            </div>
            <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
                <div class="chatroom-header text-center">
                    <a href="/classroom/chat/{{$batch->id}}" class="nav-link">Chat</a>
                    <a href="/classroom/files/{{$batch->id}}" class="nav-link">Files</a>
                    <a href="/classroom/videos/{{$batch->id}}" class="nav-link active">Videos</a>
                    <a href="/classroom/cqcs/{{$batch->id}}" class="nav-link">CQC</a>
                    @if(auth()->user()->role == 'Student')
                    <a href="/student/classroom/exams/{{$batch->id}}" class="nav-link">Exams</a>
                    @endif
                    @if($batch->status=='Running' && $batch->classroomLink!='' )
                        <a href="{{$batch->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                    @endif
                </div>
            </div>
            <div class="col-12 my-3 chatroom-header" style="font-size: 0.75rem !important; text-align:right">
                <a href="/classroom/videos/{{$batch->id}}" class="nav-link">Unit Wise Videos</a>
                <a href="/classroom/videos/{{$batch->id}}/all" class="nav-link active">All Videos</a>
            </div>
            
        </div>

        <div class="row chatroom-main-content ">  
            <div class="col-12 mx-5 my-3 h5">All Videos</div>
            @if(auth()->user()->role!='Student')
            <div class="col-md-3 text-center">
            <button type="button" class="btn create-new-file" data-toggle="modal" data-target="#create_video">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <div class="file-upload-hover">+ Create a new Video</div>
            </button>
            </div>
            @endif       
            @forelse ($batch->classVideos as $video)
            <div class="col-md-3 col-6">
                <div class="classroom-videos mt-3">
                <div class="video-btn">
                    <a class="view-video h4" href="#videoModal" video-title="{{$video->videoTitle}}" video-url="{{$video->videoPath}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal"><span class="fas fa-video mdi mdi-video"></span></a>
                    <h5>{{$video->videoTitle}}</h5>
                </div>
                <div class="text-center">
                    <div class="upload-user"> By: {{$video->user_name}} <span>on {{$video->created_at}}</span></div>
                    @if(auth()->user()->role=='Admin')
                    <div class="mt-2">
                        <a class="edit-video btn-sm btn-info" href="#edit_video" video-title="{{$video->videoTitle}}" video-url="{{$video->videoPath}}" video-id="{{$video->id}}" data-bs-toggle="modal" data-bs-target="#edit_video" data-toggle="modal" data-target="#edit_video">Edit</a>
                        <form class="d-inline" id="delete-form-{{$video->id}}" action="/classroom/videos/{{$batch->id}}/{{$video->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a class="btn-sm btn-danger" href="javascript:{}" onclick="javascript:deleteData({{$video->id}});" title="Delete">Delete</a>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
            @empty
                <p class="text-center mt-5">Videos not available....</p>
            @endforelse
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
           
            </div>
            
    </div>
{{-- for video upload model --}}
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
            <div class="row">
                <div class="col-md-12">
                    @if(auth()->user()->role!='Student')
                        <form method="POST" action="/classroom/videos/{{$batch->id}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="videotitle" class="col-md-3 col-form-label text-md-right">{{ __(' Video Title') }}</label>

                                <div class="col-md-9">
                                    <input id="videotitle" type="text" class="form-control @error('videotitle') is-invalid @enderror" name="videotitle" value="{{ old('videotitle') }}" required autofocus>

                                    @error('videotitle')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="uservideo" class="col-md-3 col-form-label text-md-right">{{ __(' Video URL') }}</label>

                                <div class="col-md-9">
                                    <input id="uservideo" type="text" class="form-control @error('uservideo') is-invalid @enderror" name="uservideo" value="{{ old('uservideo') }}" required>

                                    @error('uservideo')
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
                    @endif
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

    <!--Video View Modal HTML -->
    <div id="videoModal" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="playingTitle"> </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="videoPlayer" class="embed-responsive embed-responsive-16by9"> </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role!='Student')
        <!--Video Edit Modal HTML -->
        <div id="edit_video" class="modal fade">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Edit Video </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/classroom/videos/{{$batch->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
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
                            
                            <div class="form-group row">
                                <label for="video_unit" class="col-md-3 col-form-label">{{ __(' Video Unit') }}</label>

                                <div class="col-md-9">
                                    <select name="video_unit" id="video_unit" class="form-control @error('video_unit') is-invalid @enderror">
                                        <option value="">Select Video Unit</option>
                                        @foreach($batch->units as $u)
                                        <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('video_unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
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

                            <div class="form-group row">
                                <label for="video_url" class="col-md-3 col-form-label">{{ __(' Video URL') }}</label>

                                <div class="col-md-9">
                                    <input id="video_url" type="text" class="form-control @error('video_url') is-invalid @enderror" name="video_url" value="{{ old('video_url') }}" required>

                                    @error('video_url')
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
    @endif

    <script type="text/javascript" async src="https://play.vidyard.com/embed/v4.js"></script>

    
    <script>
        // this script is used to prompt edit model

          //home page player
        $(document).ready(function(){
            $('.edit-video').click(function(){
                
                //clear previous data
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

                // alert("id="+vid+" | title="+vtitle+" | url="+vurl);
            });
        });
    </script>

@endsection
