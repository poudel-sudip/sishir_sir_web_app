@extends($header)
@section('student-title')
    Assignments
@endsection
@section('tutor-title')
    Classroom Assignments
@endsection
@section('tutor-title-icon')
 <i class="fas fa-file-alt"></i>
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
            <div class="enrolled-table table-responsive">
                <table class="table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Question</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php($i=1)
                        @foreach($assignments as $assign)
                        <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap"> {{$assign->question->question}} </td>
                            <td>
                                @if(auth()->user()->role=='Student')
                                    @if($assign->status)
                                        <a href="/classroom/assignments/{{$batch->id}}/{{$assign->question->id}}/view" class="btn btn-success btn-sm">View</a>
                                    @else
                                        <a href="/classroom/assignments/{{$batch->id}}/{{$assign->question->id}}/solve" class="btn btn-primary btn-sm">Solve</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @php($i++)
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if(auth()->user()->role!='Student')
                    <hr>
                    <form method="POST" action="/classroom/assignments/{{$batch->id}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="question" class="col-md-4 col-form-label text-md-right">{{ __(' Question') }}</label>

                                <div class="col-md-8">
                                    <input id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required autofocus>

                                @error('question')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group row mb-0 mt-2">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
