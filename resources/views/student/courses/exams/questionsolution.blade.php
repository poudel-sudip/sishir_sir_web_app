@extends('student.layouts.app')
@section('student-title')
    Solve Exam Question
@endsection

@section('student-title-icon')
    <i class="fas fa-eye"></i>
@endsection

@section('content')

    <div class="student-content-wrapper student-enroll-section bg-white">
        <div class="h6 text-center">{{$batch->course->name}}</div>
        <div class="h6 text-center">{{ $batch->name }}</div>
        <div class="text-end question-solution-remarks">Remarks: {{$answer->remarks}}</div>
        <div class="h5">{{$exam->question}}</div>
        <b>Answer:</b><br>
        <div class="question-solution">
            {!! $answer->answer !!}
        </div>
    </div>

@endsection
