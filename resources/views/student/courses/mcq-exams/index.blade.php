@extends('student.layouts.app')
@section('student-title')
    MCQ Exams | {{$batch->name}}
@endsection
@section('student-title-icon')
    <i class="far fa-list-alt"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">
        <div class="mt-2 text-center">
            <div class=" dchl-title h4">{{$batch->name}}</div>
        </div>
        <div class=" text-end pe-2">
            <a href="/student/online-course-bookings/{{$booking->id}}/curriculum" class="btn btn-sm btn-outline-primary  mb-1 ">Curriculum</a> 
            <a href="/student/online-course-bookings/{{$booking->id}}/files" class="btn btn-sm btn-outline-primary  mb-1 ">Notes</a> 
            <a href="/student/online-course-bookings/{{$booking->id}}/videos" class="btn btn-sm btn-outline-primary  mb-1 ">Videos</a> 
            <a href="/student/online-course-bookings/{{$booking->id}}/mcq-exams" class="btn btn-sm btn-outline-primary active mb-1 ">MCQ Exams</a> 
        </div>

        <div class="row">
            <div class="col-md-12 student_exam_card">
                                
                <div class="table-responsive table-responsive-md">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th width="50">SN</th>
                                <th>Exam Title</th>
                                <th class="text-center text-md-end pe-5">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mcq_exams as $key=>$exam)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="text-wrap">{{$exam->exam->name ?? ''}}</td>
                                    <td class="text-wrap text-end">
                                        @if($exam->status)
                                            <a href="/student/online-course-bookings/{{$booking->id}}/mcq-exams/{{$exam->exam->id}}/view" class="btn btn-success btn-sm mb-1">View Evaluation</a>
                                            <form id="reset-form-{{$key+1}}" action="/student/online-course-bookings/{{$booking->id}}/mcq-exams/{{$exam->exam->id}}/reset" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:resetData({{$key+1}});" class="btn btn-danger btn-sm mb-1">Reset Exam</a>
                                            </form> 
                                            <a href="/student/mcq-exams/{{$exam->exam->id}}/cqcs" class="btn btn-primary btn-sm">View CQCs</a>

                                        @else
                                            <a href="/student/online-course-bookings/{{$booking->id}}/mcq-exams/{{$exam->exam->id}}/attempt" class="btn btn-primary btn-sm">Attempt Exam</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        function resetData(id)
        {
            if(confirm('Are You Sure You want to Reset this Exam ? You will not be able to revert it ? ')){
                document.getElementById('reset-form-'+id).submit();
            }
        }
    </script>
    
@endsection
