@extends($header)
@section('student-title')
    Solve Assignment
@endsection
@section('student-title-icon')
    <i class="fas fa-edit"></i>
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
            <div class="chatroom-header">
                <a href="/classroom/chat/{{$batch->id}}" class="nav-link ">Chat</a>
                <a href="/classroom/files/{{$batch->id}}" class="nav-link">Files</a>
                <a href="/classroom/videos/{{$batch->id}}" class="nav-link">Videos</a>
                <a href="/classroom/assignments/{{$batch->id}}" class="nav-link active">Assignments</a>
                <a href="/classroom/schedules/{{$batch->id}}" class="nav-link">Schedules</a>
                <a href="/classroom/cqcs/{{$batch->id}}" class="nav-link">CQC</a>

                @if($batch->status=='Running' && $batch->classroomLink!='' && auth()->user()->role!='Student')
                    <a href="{{$batch->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                @endif

                @if($meeting)
                    @if($meeting->status=='started')
                        <a href="{{$meeting->join_url}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                    @endif
                @endif

            </div>
        </div>
    </div>
    <hr>
    <div class="container student_exam_card">
        <div class="col-md-12">
            <form class="form-sample" method="POST" action="/classroom/assignments/{{$batch->id}}/{{$assignment->id}}/save" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="answer" class="col-12 col-form-label h4"> {{$assignment->question}} </label>

                    <div class="col-12">
                        <textarea id="answer" class="form-control summernote @error('answer') is-invalid @enderror" name="answer" required autocomplete="answer" ></textarea>
                        @error('answer')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="col-md-6 offset-md-5">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
