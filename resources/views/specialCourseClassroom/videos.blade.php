@extends($header)
@section('student-title')
    Classroom Videos
@endsection

@section('content')

    <div class="container chatroom-section content-wrapper">
        @if (session('status'))
        <span class="alert alert-success" role="alert">
            {{ session('status') }}
        </span>
        @endif
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>{{$course->course}} <span>(Time: {{$course->timeSlot}})</span></h5>
            </div>
            <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
                <div class="chatroom-header text-center">
                    <a href="/special-course/classroom/chat/{{$course->id}}" class="nav-link ">Chat</a>
                    <a href="/special-course/classroom/files/{{$course->id}}" class="nav-link ">Files</a>
                    <a href="/special-course/classroom/videos/{{$course->id}}" class="nav-link active">Videos</a>
                    <!-- <a href="/special-course/classroom/assignments/{{$course->id}}" class="nav-link">Assignments</a> -->
                    @if($course->status=='Active' && $course->classroomLink!='')
                        <a href="{{$course->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row file-main-content chatroom-main-content ">            
            @forelse ($course->videos as $video)
            <div class="col-md-3">
                <div class="classroom-videos mt-3">
                <div class="video-btn">
                    <a class="view-video h4" href="#videoModal" video-title="{{$video->videoTitle}}" video-url="{{$video->videoPath}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal"><span class="fa fa-file-video-o"></span></a>
                    <h5>{{$video->videoTitle}}</h5>
                </div>
                <div class="chatroom-video-action">
                    <div class="upload-user"> By: {{$video->user_name}} <span>on {{$video->created_at}}</span></div>
                    @if(auth()->user()->role=='Admin')
                    <div>
                        <form class="d-inline" id="delete-form-{{$video->id}}" action="/special-course/classroom/videos/{{$course->id}}/{{$video->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a class="file-video-delete-btn" href="javascript:{}" onclick="javascript:deleteData({{$video->id}});"><span class="mdi mdi-delete"></span></a>
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
            <div class="row">
                <div class="col-md-12">
                    @if(auth()->user()->role!='Student')
                        <hr>
                        <form method="POST" action="/special-course/classroom/videos/{{$course->id}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="videotitle" class="col-md-4 col-form-label text-md-right">{{ __(' Video Title') }}</label>

                                <div class="col-md-6">
                                    <input id="videotitle" type="text" class="form-control @error('videotitle') is-invalid @enderror" name="videotitle" value="{{ old('videotitle') }}" required autofocus>

                                    @error('videotitle')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="uservideo" class="col-md-4 col-form-label text-md-right">{{ __(' Video URL') }}</label>

                                <div class="col-md-6">
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


    <!-- Modal HTML -->
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

    <script type="text/javascript" async src="https://play.vidyard.com/embed/v4.js"></script>

@endsection
