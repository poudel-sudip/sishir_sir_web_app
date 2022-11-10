@extends('student.layouts.app')
@section('student-title')
    Chapters | {{$course->name}}
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
           @foreach ($chapters as $chapter)
               <div class="col-md-4 mb-3">
                <a href="/student/video-course/{{$booking->id}}/chapters/{{$chapter->id}}/videos" style="text-decoration: none">
                   <div class="student-vid-chapter border shadow">
                    <span class="text-primary">Chapter {{$chapter->sn}}</span>
                    <h6 class="text-black">{{($chapter->name ?? '')}}</h6>
                    <div class="student-vid-cpt-action">
                        <div class="col-6 text-black">
                            <i class="fas fa-file-video text-success"></i>
                            {{$chapter->videos->count()}}
                            @if ($chapter->videos->count() >= 2)
                                Videos
                            @else
                            Video
                            @endif
                        </div>
                        {{-- <div class="text-end col-6">
                            <a href="/student/video-course/{{$booking->id}}/chapters/{{$chapter->id}}/videos" class="btn btn-sm btn-success">Show Videos</a>
                        </div> --}}
                    </div>
                   </div>
                </a>
               </div>
           @endforeach
            {{-- <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Chapter</th>
                                <th></th>
                                <th>Videos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters as $chapter)
                            <tr>
                                <td>{{$chapter->sn}}</td>
                                <td>{{($chapter->name ?? '')}}</td>
                                <td>{{$chapter->videos->count()}}</td>
                                <td><a href="/student/video-course/{{$booking->id}}/chapters/{{$chapter->id}}/videos" class="btn btn-sm btn-success">Show Videos</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div> --}}
        </div>
    </div>

@endsection
