@extends('student.layouts.app')
@section('student-title')
    My Exams | {{$batch->name}}
@endsection
@section('student-title-icon')
    <i class="far fa-list-alt"></i>
@endsection

@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12 student_exam_card">
                <div class="card-title h4 mb-3">
                    Exams | {{$batch->name}} 
                </div>
                
                <div class="table-responsive table-responsive-md">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Exam Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($mcqexams as $exam)
                            <tr>
                                <td>{{$i}}</td>
                                <td class="text-wrap">{{$exam->exam->name ?? ''}}</td>
                                <td width= "250">
                                    @if($exam->status)
                                        <a href="/student/classroom/exams/{{$batch->id}}/mcq-exams/{{$exam->exam->id}}/view" class="btn btn-success btn-sm">View Evaluation</a>
                                        <form id="reset-form-{{$i}}" action="/student/classroom/exams/{{$batch->id}}/mcq-exams/{{$exam->exam->id}}/reset" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:resetData({{$i}});" class="btn btn-danger btn-sm">Reset Exam</a>
                                        </form> 
                                    @else
                                        <a href="/student/classroom/exams/{{$batch->id}}/mcq-exams/{{$exam->exam->id}}/attempt" class="btn btn-primary btn-sm">Attempt Exam</a>
                                    @endif
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

    <script type="text/javascript">
        function resetData(id)
        {
            if(confirm('Are You Sure You want to Reset this Exam ? You will not be able to revert it ? ')){
                document.getElementById('reset-form-'+id).submit();
            }
        }
    </script>
    
@endsection
