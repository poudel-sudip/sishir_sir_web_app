@extends('student.layouts.app')
@section('student-title')
    Enrolled Video Courses
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row mb-2">
            <div class="col-md-12 text-end">
                <a class="student-enroll-btn" href="{{ url('/student/video-course/enroll') }}">Book Video Course</a>
            </div>
        </div>
        <div class="row">
            @foreach ($bookings as $booking)
                <div class="col-md-4 student-video-card mb-3">
                    <div class="vid-card-img-container">
                        @if ($booking->status=="Verified")
                        <a href="/student/video-course/{{$booking->id}}/chapters"><img src="/storage/{{$booking->course->thumbnail}}" alt="" class="w-100"></a>
                        @else
                        <img src="/storage/{{$booking->course->thumbnail}}" alt="" class="w-100">
                        @endif
                    </div>
                    <div class="student-vid-dec">
                        <h6>{{($booking->course->name ?? '')}}</h6>
                        <div class="student-vid-status">
                            @if ($booking->status == "Verified")
                            <div class="text-success">{{$booking->status}}</div>
                            @else
                            <div class="text-primary">{{$booking->status}}</div>
                            @endif
                            <div class="text-end">
                                @if($booking->status!="Verified")
                                <a href="/student/video-course/{{$booking->id}}/edit" class="btn btn-warning btn-sm ">Verify</a> 
                                <form id="delete-form-{{$booking->id}}" action="/student/video-course/{{$booking->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm">Delete</a>
                                </form>
                                @else
                                {{-- <a href="/student/video-course/{{$booking->id}}/chapters" class="btn btn-primary btn-sm mb-1 ">Chapters</a>  --}}
                                <a href="/student/video-course/{{$booking->id}}/exams" class="btn btn-success btn-sm mb-1 ">Exams</a> 
                                <a href="/student/video-course/{{$booking->id}}/cqc" class="btn btn-info btn-sm mb-1 ">CQQ</a> 
                                    @if($booking->course->class_link)
                                    <a href="{{$booking->course->class_link}}" target="_blank" class="btn btn-danger btn-sm mb-1 ">Live Class</a> 
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- <div class="col-md-12">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Video Course</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                <td>{{($booking->course->name ?? '')}}</td>
                                <td>{{$booking->status}}</td>
                                <td>
                                    @if($booking->status!="Verified")
                                        <a href="/student/video-course/{{$booking->id}}/edit" class="btn btn-warning btn-sm mb-1 ">Verify</a> 
                                        <form id="delete-form-{{$booking->id}}" action="/student/video-course/{{$booking->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm">Delete</a>
                                        </form>
                                    @else
                                    <a href="/student/video-course/{{$booking->id}}/chapters" class="btn btn-primary btn-sm mb-1 ">Chapters</a> 
                                    <a href="/student/video-course/{{$booking->id}}/exams" class="btn btn-success btn-sm mb-1 ">Exams</a> 
                                    <a href="/student/video-course/{{$booking->id}}/cqc" class="btn btn-info btn-sm mb-1 ">CQQ</a> 
                                        @if($booking->course->class_link)
                                        <a href="{{$booking->course->class_link}}" target="_blank" class="btn btn-danger btn-sm mb-1 ">Live Class</a> 
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div> --}}
        </div>
    </div>

    <script type="text/javascript">
        function deleteData(id)
        {
            if(confirm('Are You Sure? ')){
                document.getElementById('delete-form-'+id).submit();
            }
        }
    </script>

@endsection
