@extends('moderator.layouts.app')
@section('admin-title')
    Question Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Question Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/moderator/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/moderator/exams') }}">Exams</a></li>
                    <li class="breadcrumb-item"><a href="/moderator/exams/{{$exam->id}}/questions">Questions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Question Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Question ID:</div>
                            <div>{{$question->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Question:</div>
                            <div>{!! $question->name !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Option A:</div>
                            <div>{!! $question->opt_a !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Option B: </div>
                            <div>{!! $question->opt_b !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Option C: </div>
                            <div>{!! $question->opt_c !!} </div>
                        </div>
                        <div class="course-row">
                            <div>Correct Option: </div>
                            <div>{!! $question->opt_correct !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Rationale / Justification: </div>
                            <div>{!! $question->rationale !!}</div>
                        </div>
                                                                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
