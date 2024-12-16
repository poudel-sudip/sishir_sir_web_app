@extends('moderator.layouts.app')
@section('admin-title')
    Exam Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Exam</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/moderator/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/moderator/exam-category') }}">Exam Categories</a></li>
                <li class="breadcrumb-item"><a href="/moderator/exam-category/{{$exam->category->id ?? ''}}/exams">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$exam->name}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Exam ID:</div>
                            <div>{{$exam->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Category:</div>
                            <div>{{$exam->category->title ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Name:</div>
                            <div>{{$exam->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Date: </div>
                            <div>{{$exam->exam_date}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Time: </div>
                            <div>{{$exam->exam_time}} HH:MM</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Description: </div>
                            <div>{!! $exam->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Marks Per Question: </div>
                            <div>{!! $exam->marks_per_question !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Nagative Markings: </div>
                            <div>{{$exam->negative_marks}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Status: </div>
                            <div>{{$exam->status}}</div>
                        </div>
                        
                        <div class="course-row">
                            <div>PDF View: </div>
                            <div>{{$exam->pdf_view ? 'Enabled' : 'Disabled'}}</div>
                        </div>

                        <div class="course-row">
                            <div>Solution Video URL: </div>
                            <div>
                                {{$exam->answer_video ?? ''}}  <br>
                                <a class="view-video btn btn-info" href="#videoModal" video-title="{{$exam->name}}" video-url="{{$exam->answer_video}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play <span class="fas fa-video mdi mdi-video"></span></a>
                            </div>
                        </div>

                        <div class="course-row">
                            <div>Solution PDF: </div>
                            <div>
                                @if($exam->answer_pdf)
                                <iframe src="/storage/{{$exam->answer_pdf}}" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div id="videoModal" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-white align-items-center">
                    <h5 class="modal-title" id="playingTitle"> </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="videoPlayer" class="embed-responsive embed-responsive-16by9"> </div>
                </div>
            </div>
        </div>
    </div>

@endsection
