@extends('student.layouts.app')
@section('student-title')
    Free Exams 
@endsection

@section('student-title-icon')
    <i class="fas fa-stopwatch"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-12 my-2">
                <h5> Free Exam Collections</h5>  
             </div>
            <div class="col-md-12 student_exam_card">
                <div class="enrolled-table table-responsive">
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
                            @foreach($free_exams as $row)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$row->exam->name ?? ''}} ({{ $row->exam ? ($row->exam->questions ? $row->exam->questions->count() : '-') : '-' }} Questions) </td>
                                <td>
                                    <a href="/public-exams/{{$row->id}}" class="btn btn-primary btn-sm">Attempt Exam</a>
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
