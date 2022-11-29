@extends($header)
@section('student-title')
    Classroom Files
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
                    <a href="/classroom/files/{{$batch->id}}" class="nav-link active">Files</a>
                    <a href="/classroom/videos/{{$batch->id}}" class="nav-link">Videos</a>
                    <a href="/classroom/cqcs/{{$batch->id}}" class="nav-link">CQC</a>

                    @if($batch->status=='Running' && $batch->classroomLink!='' )
                        <a href="{{$batch->classroomLink}}" target="_blank" class="nav-link" title="Zoin Class" oncontextmenu="return false"><i class="fa fa-video-camera" aria-hidden="true"></i> Join</a>
                    @endif

                </div>
            </div>
            <div class="col-12 my-3 chatroom-header" style="font-size: 0.75rem !important; text-align:right">
                <a href="/classroom/files/{{$batch->id}}" class="nav-link active">Unit Wise Files</a>
                <a href="/classroom/files/{{$batch->id}}/all" class="nav-link">All Files</a>
            </div>
        </div>

        <div class="row chatroom-main-content ">     
            @forelse ($units as $unit)
            <div class="col-md-3 col-6">
                <div class="classroom-videos mt-3">
                    
                    <div class="video-btn border">
                        <a href="/classroom/files/{{$batch->id}}/unit/{{$unit->id}}" class="view-video" style="font:inherit;color:inherit">
                            <span class="fa fa-folder-open"></span>
                            <h5>{{ucwords($unit->name)}}</h5>
                            <p> {{$unit->classFiles->count()}} Files</p>
                        </a>
                    </div>
                
                </div>
            </div>
            @empty
                <p class="text-center mt-5">Unit Not Assigned. Please Check <a href="/classroom/files/{{$batch->id}}/all">All Files</a>. </p>
            @endforelse  
        </div>  
    </div>

@endsection
