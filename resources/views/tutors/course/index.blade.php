@extends('tutors.layouts.app')
@section('tutor-title')
    My Courses
@endsection
@section('tutor-title-icon')
    <i class="fas fa-book"></i>
@endsection

@section('content')
    <div class="tutor-content-wrapper student-enroll-section">
        
        <div class="row">
            <div class="col-md-12 mb-2 text-end">
                <a class="student-enroll-btn" href="{{ url('/tutor/special-courses/create') }}">Add New Course</a>
            </div>
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Course</th>
                                <th>Fee</th>
                                <th>Start Date</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($courses as $course)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$course->course}}</td>
                                <td>Rs. {{$course->fee}}</td>
                                <td>{{date('Y/m/d',strtotime($course->startDate))}}</td>  
                                <td>{{$course->duration}}</td>    
                                <td>{{$course->status}}</td>    
                                <td class="classroom-btn" >
                                    @if($course->status!='Inactive')
                                    <a href="/special-course/classroom/chat/{{$course->id}}" class="btn btn-info btn-sm">Classroom</a>
                                    <a href="/tutor/special-courses/{{$course->id}}/bookings" class="btn btn-warning btn-sm">Bookings</a>
                                    @endif
                                    <a href="/tutor/special-courses/{{$course->id}}" class="btn btn-primary btn-sm">Show</a>
                                    <a href="/tutor/special-courses/{{$course->id}}/edit" class="btn btn-danger btn-sm">Edit</a>
                                </td>                       
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
