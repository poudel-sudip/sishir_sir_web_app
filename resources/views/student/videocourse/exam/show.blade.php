@extends('student.layouts.app')
@section('student-title')
    Show Exam Result
@endsection
@section('student-title-icon')
    <i class="fas fa-eye"></i>
@endsection

@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12">
                <div class="view-evaluation"> 
                    <div class="h4 text-center">{{$course->name}}</div>
                    <div class="h5 text-center">{{$exam->name}}</div>
                    <div class="show-result-header">
                        <div>
                            <p>Total Questions: {{$result->total_questions}}</p>
                            <p>Correct Questions: {{$result->correct_questions}}</p>
                        </div>
                        <div>
                            <p>Marks Per Question: {{$exam->marks_per_question}}</p>
                            <p>Wrong Questions: {{$result->wrong_questions}}</p>
                        </div>
                        <div>
                            <p>Negative Marks Per Question: {{$exam->negative_marks}}</p>
                            <p><b>Marks Obtained: {{($result->correct_questions * $exam->marks_per_question)-($result->wrong_questions*$exam->negative_marks)  }}</b></p>
                        </div>
                        <div class="text-end">
                            <p>Leaved Questions: {{$result->leaved_questions}}</p> 
                        </div>
                    </div>
                </div>
               
                <div class="answer-details">
                    <h6>Question & Answer</h6>
                    @php($i=1)
                    @foreach ($answers as $ans)
                    <div class="mcq-solution-sheet"> 
                        <h5>{{$i}}. {!!$ans->question ?? $ans->getQuestion->name ?? '' !!}</h5>
                        <h6>Options:</h6>
                        <div class="row">
                            <div class="col-md-3">A. {!! $ans->getQuestion->opt_a ?? '' !!}</div>
                            <div class="col-md-3">B. {!! $ans->getQuestion->opt_b ?? '' !!}</div>
                            <div class="col-md-3">C. {!! $ans->getQuestion->opt_c ?? '' !!}</div>
                            <div class="col-md-3">D. {!! $ans->getQuestion->opt_d ?? '' !!}</div>
                        </div>
                        <hr>
                        <div class="mcq-solution">
                            <div class="correct-answer"><span class="icon-checkbox-checked text-success"></span>Correct Answer:  {!!$ans->correct_ans!!}</div>
                            <div>Your Answer:  
                                @if ($ans->correct_ans == $ans->your_ans)
                                <i class="fa fa-check text-primary" aria-hidden="true"></i> <span>{!!$ans->your_ans!!}</span>
                                @else
                                <i class="fa fa-times text-danger" aria-hidden="true"></i> <span>{!!$ans->your_ans!!}</span>
                                @endif
                                {{-- {{$ans->your_ans}} --}}
                            </div>
                        </div>
                    </div>
                    @php($i++)
                    @endforeach
                   
                </div>
            </div>
        </div>
    </div>
@endsection
