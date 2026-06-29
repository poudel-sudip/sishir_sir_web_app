@extends('student.layouts.app')
@section('student-title')
    Enrolled Course Batches
@endsection

@section('student-title-icon')
    <i class="far fa-calendar-check"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row mb-2">
            <div class="col-md-12 text-end">
                {{-- <a class="student-enroll-btn" href="{{ url('/student/course-bookings/create') }}">Book a Course Batcht</a> --}}
                <a class="student-enroll-btn" href="/courses">Book a Course Batch</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="enrolled-table table-responsive table-responsive-md">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                {{-- <th>Date</th> --}}
                                <th>Course Batch</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                {{-- <td>{{date('Y/m/d',strtotime($booking->created_at))}}</td> --}}
                                <td class="text-wrap">{{(optional(optional($booking->batch)->course)->name ?? '').'  ||  '.optional($booking->batch)->name.''}}</td>
                                <td class="text-wrap">{{$booking->status}}</td>
                                <td class="text-wrap">
                                    @if($booking->status!="Verified")
                                        <a href="/student/course-bookings/{{$booking->id}}/edit" class="btn btn-warning btn-sm mb-1 ">Verify</a> 
                                        <form id="delete-form-{{$booking->id}}" action="/student/course-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger btn-sm">Delete</a>
                                        </form>
                                    @else
                                        <a href="/student/course-bookings/{{$booking->id}}/files" class="btn btn-info btn-sm mb-1 ">Files</a> 
                                        <a href="/student/course-bookings/{{$booking->id}}/videos" class="btn btn-danger btn-sm mb-1 ">Videos</a> 
                                        <a href="/student/course-bookings/{{$booking->id}}/curriculum" class="btn btn-success btn-sm mb-1 ">Curriculum</a> 
                                        <a href="/student/course-bookings/{{$booking->id}}/mcq-exams" class="btn btn-primary btn-sm mb-1 ">MCQ Exams</a> 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
            <div class="col-12">
                {{$bookings->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
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
