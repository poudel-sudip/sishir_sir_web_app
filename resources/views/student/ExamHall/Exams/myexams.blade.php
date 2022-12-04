@extends('student.layouts.app')
@section('student-title')
    Exams | {{$category->title}}
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-12 my-2">
                <h5> Exam Collections | {{$category->title}} </h5>  
             </div>
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
                    <table class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>SN</th>
                                <th>Set Name</th>
                                <th>Exam Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($cat_exams as $exam)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$category->title ?? ''}}</td>
                                <td>{{$exam->exam->name ?? ''}}</td>
                                <td>
                                    @if($exam->status)
                                        <a href="/student/exam-bookings/{{$category->id}}/exams/{{$exam->exam->id}}/view" class="btn btn-success btn-sm">View Evaluation</a>
                                        <form id="reset-form-{{$i}}" action="/student/exam-bookings/{{$category->id}}/exams/{{$exam->exam->id}}/reset" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:resetData({{$i}});" class="btn btn-danger btn-sm">Reset Exam</a>
                                        </form>                                    
                                    @else
                                        <a href="/student/exam-bookings/{{$category->id}}/exams/{{$exam->exam->id}}/attempt" class="btn btn-primary btn-sm">Attempt Exam</a>
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
