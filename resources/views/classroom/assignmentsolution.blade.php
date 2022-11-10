@extends($header)
@section('student-title')
    Assignment Solution
@endsection
@section('student-title-icon')
    <i class="fas fa-file-alt"></i>
@endsection

@section('content')
<div class="student-content-wrapper chatroom-section content-wrapper" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
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
    <div class="container">
        <div class="col-md-12">
            <div class="student_exam_card">
                <div class="h6 text-end">Remarks: {{$answer->remarks}}</div>
                <div class="h5">{{$assignment->question}}</div>
                <b>Answer:</b><br>
                <div class="">
                    {!! $answer->answer !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
