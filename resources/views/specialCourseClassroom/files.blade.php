@extends($header)

@section('student-title')
    Classroom Files
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
            <h5>{{$course->course}} <span>(Time: {{$course->timeSlot}})</span> </h5>
        </div>
        <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
            <div class="chatroom-header text-center">
                <a href="/special-course/classroom/chat/{{$course->id}}" class="nav-link ">Chat</a>
                <a href="/special-course/classroom/files/{{$course->id}}" class="nav-link active">Files</a>
                <a href="/special-course/classroom/videos/{{$course->id}}" class="nav-link">Videos</a>
                <!-- <a href="/special-course/classroom/assignments/{{$course->id}}" class="nav-link">Assignments</a> -->
                @if($course->status=='Active' && $course->classroomLink!='')
                    <a href="{{$course->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                @endif
            </div>
        </div>
    </div>
    <div class="row chatroom-main-content file-main-content mt-4">
        @if(auth()->user()->role!='Student')
        <div class="col-md-3 text-center">
            <button type="button" class="btn create-new-file" data-toggle="modal" data-target="#create_file">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <div class="file-upload-hover">+ Create a new file</div>
                </button>
        </div>
        @endif
        @forelse($course->files as $files)
        <div class="col-md-3 single-file">
            <div class="demo-file">
                <object data="/storage/{{$files->filePath}}" type="application/pdf">
                    alt : <a href="/storage/{{$files->filePath}}">pdf</a>
                </object>
            </div>
            <div class="hidden-lx">
                <span class="icon-file-pdf"></span>
            </div>
            <div class="user-files">
                <button type="button" style="border:0;background:transparent;padding:0" data-toggle="modal" class="file-view-btn" data-target="#view_file" data-id="{{ $files->id }}">
                    <h4>{{$files->fileTitle}}</h4>
                </button>

            </div>
            <div class="chatroom-video-action">
                <div class="user-name-time">{{$files->user_name}} <span>on {{date('Y/m/d',strtotime($files->created_at))}}</span>
                </div>
                @if(auth()->user()->role=='Admin')
                <div>
                    <form class="d-inline" id="delete-form-{{$files->id}}" action="/special-course/classroom/files/{{$course->id}}/{{$files->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="file-video-delete-btn" href="javascript:{}" onclick="javascript:deleteData({{$files->id}});"><span class="mdi mdi-delete"></span></a>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
            <div class="col-md-3">No Files Found</div>
        @endforelse
    </div>
</div>

{{-- for file upload model --}}
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
            <form method="POST" action="/special-course/classroom/files/{{$course->id}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="filetitle" class="col-md-4 col-form-label text-md-right">{{ __('Your File Title') }}</label>

                    <div class="col-md-8">
                        <input id="filetitle" type="text" class="form-control @error('filetitle') is-invalid @enderror" name="filetitle" value="{{ old('filetitle') }}" required autofocus>

                        @error('filetitle')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="userfile" class="col-md-4 col-form-label text-md-right">{{ __('Your File') }}</label>

                    <div class="col-md-8">
                        <input id="userfile" type="file" class="form-control @error('userfile') is-invalid @enderror" name="userfile" value="{{ old('userfile') }}" required>

                        @error('userfile')
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

  {{-- for view file model --}}
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
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>



<script>
    $(document).ready(function(){
        $('.file-view-btn').click(function(){
            const id=$(this).attr('data-id');
            $.ajax({
                url:'/special-course/classroom/view/'+id,
                dataType: 'json',
                type:'GET',
                data:{
                    "id":id
                },
                success:function(data){
                    $('#file-title').html(data.fileTitle);
                    $('#file-image').html("");
                    $('#file-image').append(
                        '<iframe src="/storage/'+data.filePath+'" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>'
                    )
                }
            })
        })
    })
</script>
@endsection
