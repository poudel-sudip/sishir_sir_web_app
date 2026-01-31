@extends('admin.layouts.app')
@section('admin-title')
    Image Puzzle Question Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Image Puzzle Question Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/play-puzzle/image') }}">Image Puzzles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Image Puzzle Question Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Question ID:</div>
                            <div>{{$question->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Question:</div>
                            <div><img src="/storage/{{ $question->question }}" alt="Question Image" class="img-fluid"></div>
                        </div>
                        <div class="course-row">
                            <div>Answer</div>
                            <div>{!! $question->answer !!}</div>
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
