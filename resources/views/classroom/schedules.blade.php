@extends($header)
@section('student-title')
    Schedules
@endsection
@section('tutor-title')
    Classroom Schedules
@endsection
@section('tutor-title-icon')
    <i class="fas fa-clock"></i>
@endsection
@section('student-title-icon')
    <i class="fas fa-calendar-alt"></i>
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
                <a href="/classroom/assignments/{{$batch->id}}" class="nav-link">Assignments</a>
                <a href="/classroom/schedules/{{$batch->id}}" class="nav-link active">Schedules</a>
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
    <div class="container">
        <div class="col-md-12">
            <div class="enrolled-table table-responsive">
                <table class="table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Tutor</th>
                            <th>Topic</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php($i=1)
                        @foreach($schedules as $schedule)
                        <tr>
                            <td>{{$i}}</td>
                            <td> {{date('Y-m-d (D)',strtotime($schedule->date))}} </td>
                            <td> {{$schedule->time}} </td>
                            <td> {{$schedule->tutor}} </td>
                            <td> {{$schedule->topic}} </td>
                        </tr>
                        @php($i++)
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
