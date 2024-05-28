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
                    <div class="h4 text-center">{{$category->title}}</div>
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
                <div class="view-evaluation">
                    <h6 class="my-2">Solution Status</h6>
                    @php($solutions = json_decode($result->remarks))
                    @if(count((array)$solutions))
                        <div class="d-flex justify-content-start align-items-center flex-wrap">
                            <span class="m-1 btn btn-sm btn-success">Correct({{ $result->correct_questions ?? '' }})</span>
                            <span class="m-1 btn btn-sm btn-danger">Wrong({{ $result->wrong_questions ?? '' }})</span>
                            <span class="m-1 btn btn-sm btn-info">Leaved({{ $result->leaved_questions ?? '' }})</span>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-wrap">
                            @foreach($solutions as $key=>$value)
                                <span class="m-1 btn btn-sm {{$value == 'c' ? 'btn-success' : ($value == 'w' ? 'btn-danger' : 'btn-info') }} ">{{ucwords($key)}}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="answer-details">
                    <div class="row mb-2 align-items-center">
                        <div class="col-6">
                            <h6>Question & Answer</h6>
                        </div>
                        <div class="col-6 text-end">
                            @if($exam->answer_video)
                            <a class="view-video btn btn-primary" href="#videoModal" video-title="{{'Video Answer Solution for '.$exam->name}}" video-url="{{$exam->answer_video}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play Solution Video <span class="fas fa-video"></span></a>
                            @endif
                            @if($exam->answer_pdf)
                            <a class="view-pdf btn btn-success" href="#pdfModal" pdf-title="{{'PDF Answer Solution for '.$exam->name}}" pdf-url="{{$exam->answer_pdf}}" data-bs-toggle="modal" data-bs-target="#pdfModal" data-toggle="modal" data-target="#pdfModal">View Solution PDF <span class="fas fa-file-pdf"></span></a>
                            @endif
                        </div>
                    </div>
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
                            </div>
                        </div>
                        @if(trim($ans->getQuestion->rationale))
                        <hr>
                        <h6>Rationale / Justification:</h6>
                        <div>
                            {!! $ans->getQuestion->rationale ?? '' !!}
                        </div>
                        @endif
                    </div>
                    @php($i++)
                    @endforeach
                   
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

    <!-- Modal HTML -->
    <div id="pdfModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pdfViewLModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="view_pdf_title"> </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="view_pdf_body" class="embed-responsive embed-responsive-16by9">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            $('.view-pdf').click(function(){
                const title = $(this).attr('pdf-title');
                const path = $(this).attr('pdf-url');
                // alert(path);
                $('#view_pdf_title').html("");
                $('#view_pdf_body').html("");
                $('#view_pdf_title').html(title);                
                $('#view_pdf_body').append(
                    '<iframe src="/storage/'+path+'" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>'
                );               
                
            })
        })
    </script>

@endsection
