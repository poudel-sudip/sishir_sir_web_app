@extends('student.layouts.app')
@section('student-title')
    My Exams | {{$batch->name}}
@endsection
@section('student-title-icon')
    <i class="far fa-list-alt"></i>
@endsection

@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row mb-2">
            <div class="col-md-12 text-end">
                {{-- @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif --}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 student_exam_card">
                <div class="card-title h4 mb-3">
                    {{$batch->name}} | Exams
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active btn-sm" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">MCQ Exams</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link btn-sm" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Written Exam  Questions</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="enrolled-table table-responsive">
                            <table class="table" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>SN</th>
                                        <th>Question</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @php($i=1)
                                    @foreach($writtenexams as $exam)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td class="text-wrap"> {{$exam->exam->question}} </td>
                                        <td>
                                            @if($exam->status)
                                                <a href="/student/classroom/exams/{{$batch->id}}/written-exams/{{$exam->exam->id}}/view" class="btn btn-success btn-sm" class="btn btn-success">View</a>
                                            @else
                                                <a href="/student/classroom/exams/{{$batch->id}}/written-exams/{{$exam->exam->id}}/solve" class="btn btn-primary btn-sm">Solve</a>
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
