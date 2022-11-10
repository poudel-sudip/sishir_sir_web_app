@extends('student.layouts.app')
@section('student-title')
    Videos | {{$chapter->name}} | {{$chapter->course->name}}
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            @foreach ($videos as $vid)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="student-video-list">
                        <iframe src="{{$vid->link}}" class="w-100" height="200">
                            <p>iframe error</p>
                        </iframe>
                        <a href="/student/video-course/{{$booking->id}}/chapters/{{$chapter->id}}/videos/{{$vid->id}}" style="text-decoration: none"><i class="far fa-play-circle"></i>
                        </a>
                    </div>
                    <h6>{{($vid->title ?? '')}}</h6>  
                    {{-- <div class="student-video-list">
                        <div class="text-center">
                            <i class="fas fa-video"></i>
                            <h6>{{($vid->title ?? '')}}</h6>
                        </div>
                    </div> --}}
                </div>
            @endforeach
            {{-- <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Video Title</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($videos as $vid)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{($vid->title ?? '')}}</td>
                                <td><a href="/student/video-course/{{$booking->id}}/chapters/{{$chapter->id}}/videos/{{$vid->id}}" class="btn btn-sm btn-success">View</a></td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div> --}}
        </div>
    </div>

@endsection
