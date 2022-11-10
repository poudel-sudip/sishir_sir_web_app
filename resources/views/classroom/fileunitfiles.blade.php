@extends($header)

@section('student-title')
    Classroom Files
@endsection

@section('tutor-title')
    Classroom  Files
@endsection
@section('tutor-title-icon')
    <i class="fas fa-file-pdf"></i>
@endsection
@section('student-title-icon')
    <i class="fas fa-file-alt"></i>
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
                <h6>{{$batch->name}} <span>(Time: {{$todaytime->time ?? $batch->timeSlot ?? ''}})</span></h6>
            </div>
            <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
                <div class="chatroom-header text-center">
                    <a href="/classroom/chat/{{$batch->id}}" class="nav-link">Chat</a>
                    <a href="/classroom/files/{{$batch->id}}" class="nav-link active">Files</a>
                    <a href="/classroom/videos/{{$batch->id}}" class="nav-link">Videos</a>
                    <a href="/classroom/assignments/{{$batch->id}}" class="nav-link">Assignments</a>
                    <a href="/classroom/schedules/{{$batch->id}}" class="nav-link">Schedules</a>
                    <a href="/classroom/cqcs/{{$batch->id}}" class="nav-link">CQC</a>

                    @if($batch->status=='Running' && $batch->classroomLink!='' && auth()->user()->role!='Student')
                        <a href="{{$batch->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                    @endif

                    @if($meeting)
                        @if($meeting->status=='started')
                            <a href="{{$meeting->join_url}}" target="_blank" class="nav-link" title="Zoin Class"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="col-12 my-3 chatroom-header" style="font-size: 0.75rem !important; text-align:right">
                <a href="/classroom/files/{{$batch->id}}" class="nav-link active">Unit Wise Files</a>
                <a href="/classroom/files/{{$batch->id}}/all" class="nav-link ">All Files</a>
            </div>
        </div>

        <div class="row chatroom-main-content mt-4">
            <div class="col-12 mx-5 my-3 h5">{{ucwords($unit->name)}}</div>
            @if(auth()->user()->role!='Student')
                <div class="col-md-3 text-center">
                    <button type="button" class="btn create-new-file" data-toggle="modal" data-target="#create_file">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <div class="file-upload-hover">+ Create a new file</div>
                    </button>
                </div>
            @endif
            @forelse($unitfiles as $files)
                <div class="col-md-3 single-file col-6">
                    <div class="demo-file">
                        <object data="/storage/{{$files->filePath}}" type="application/pdf">
                            alt : <a href="/storage/{{$files->filePath}}">pdf</a>
                        </object>
                    </div>
                    <div class="hidden-lx">
                        <span class="icon-file-pdf"></span>
                    </div>
                    <div class="user-files text-center">
                        <button type="button" style="border:0;background:transparent;padding:0" data-toggle="modal" class="file-view-btn" data-target="#view_file" data-id="{{ $files->id }}">
                            <h4>{{$files->fileTitle}}</h4>
                        </button>
                    </div>
                    <div class="text-center">
                        <div class="upload-user text-primary"> By: {{$files->user_name}} <span>on {{$files->created_at}}</span></div>
                        @if(auth()->user()->role=='Admin')
                        <div class="mt-2">
                            <a class="edit-file btn-sm btn-info" href="#edit_file" file-title="{{$files->fileTitle}}" file-url="{{$files->filePath}}" file-id="{{$files->id}}" data-bs-toggle="modal" data-bs-target="#edit_file" data-toggle="modal" data-target="#edit_file">Edit</a>
                            <form class="d-inline" id="delete-form-{{$files->id}}" action="/classroom/files/{{$batch->id}}/{{$files->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a class="btn-sm btn-danger" href="javascript:{}" onclick="javascript:deleteData({{$files->id}});" title="Delete">Delete</a>
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
                    <form method="POST" action="/classroom/files/{{$batch->id}}/unit/{{$unit->id}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="unit" class="col-md-4 col-form-label text-md-right">{{ __('File Unit') }}</label>

                            <div class="col-md-8">
                                <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{$unit->name}}" required readonly>

                                @error('unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

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
    {{-- for file upload model end--}}

  
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


    {{-- File Edit Modal HTML --}}
    @if(auth()->user()->role!='Student')
        <div id="edit_file" class="modal fade">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Edit File </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/classroom/files/{{$batch->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
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
                            
                            <div class="form-group row">
                                <label for="file_unit" class="col-md-3 col-form-label">{{ __(' File Unit') }}</label>

                                <div class="col-md-9">
                                    <select name="file_unit" id="file_unit" class="form-control @error('file_unit') is-invalid @enderror">
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                        <option value="">----------------</option>
                                        @foreach($batch->units as $u)
                                        <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('file_unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
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

                            <div class="form-group row">
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
    {{-- File Edit Modal HTML end --}}

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
        $(document).ready(function(){
            $('.file-view-btn').click(function(){
                const id=$(this).attr('data-id');
                $.ajax({
                    url:'/classroom/view/'+id,
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

@endsection
