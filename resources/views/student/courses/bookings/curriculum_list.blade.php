@extends('student.layouts.app')
@section('student-title')
    Course Batch Curriculum
@endsection

@section('student-title-icon')
    <i class="far fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">    
        <div class="mt-2 text-center">
            <div class=" dchl-title h4">{{$batch->name}}</div>
        </div>
        <div class="pe-2 text-end">
            <a href="/student/online-course-bookings/{{$booking->id}}/curriculum" class="btn btn-sm btn-outline-primary active mb-1 ">Curriculum</a> 
            <a href="/student/online-course-bookings/{{$booking->id}}/files" class="btn btn-sm btn-outline-primary mb-1 ">Notes</a> 
            <a href="/student/online-course-bookings/{{$booking->id}}/videos" class="btn btn-sm btn-outline-primary mb-1 ">Videos</a> 
            <a href="/student/online-course-bookings/{{$booking->id}}/mcq-exams" class="btn btn-sm btn-outline-primary mb-1 ">MCQ Exams</a> 
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="enrolled-table table-responsive table-responsive-md">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Title</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($curriculums as $key=>$row)
                            <tr>
                                <td width="70">{{$key+1}}</td>
                                <td class="text-wrap">{{$row->title}}</td>
                                <td class="text-wrap" width="100">
                                    <a href="/student/online-course-bookings/{{$booking->id}}/curriculum/{{$row->id}}" class="btn btn-success btn-sm mb-1 ">View</a> 
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
           
        </div>
    </div>
  

@endsection
