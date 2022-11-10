@extends($header)
@section('student-title')
    Classroom Videos
@endsection
@section('tutor-title')
    Classroom Videos
@endsection
@section('tutor-title-icon')
 <i class="fas fa-video"></i>
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
                <h6>{{$batch->name}} <span>(Time: {{$todaytime->time ?? $batch->timeSlot ?? ''}})</span></h6>
            </div>
            <div class="col-md-12 text-center" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
                <div class="chatroom-header text-center">
                    <a href="/classroom/chat/{{$batch->id}}" class="nav-link">Chat</a>
                    <a href="/classroom/files/{{$batch->id}}" class="nav-link">Files</a>
                    <a href="/classroom/videos/{{$batch->id}}" class="nav-link active">Videos</a>
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
                <a href="/classroom/videos/{{$batch->id}}" class="nav-link active">Unit Wise Videos</a>
                <a href="/classroom/videos/{{$batch->id}}/all" class="nav-link">All Videos</a>
            </div>
        </div>

        <div class="row chatroom-main-content ">     
            @forelse ($units as $unit)
            <div class="col-md-3 col-6">
                <div class="classroom-videos mt-3">
                    
                    <div class="video-btn border">
                        <a href="/classroom/videos/{{$batch->id}}/unit/{{$unit->id}}" class="view-video" style="font:inherit;color:inherit">
                            <span class="fas fa-video mdi mdi-video"></span>
                            <h5>{{ucwords($unit->name)}}</h5>
                            <p> {{$unit->classVideos->count()}} Videos</p>
                        </a>
                    </div>
                
                </div>
            </div>
            @empty
                <p class="text-center mt-5">Unit Not Assigned. Please Check All Videos.</p>
            @endforelse  
        </div>  
    </div>

@endsection
