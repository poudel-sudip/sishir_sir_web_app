@extends('student.layouts.app')
@section('student-title')
    Show Result
@endsection

@section('student-title-icon')
    <i class="fas fa-eye"></i>
@endsection

@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12">
                <div class="view-evaluation"> 
                    <div class="text-center">
                        <div class=" dchl-title h4">{{$batch->name}}</div>
                    </div>
                    {{-- <div class="h6 text-center">{{$batch->name}}</div> --}}
                    <div class="h5 text-center mb-4">{{$exam->name}}</div>
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
                            @php($counter=1)
                            @foreach($solutions as $key=>$value)
                                <span class="question-key m-1 btn btn-sm {{$value == 'c' ? 'btn-success' : ($value == 'w' ? 'btn-danger' : 'btn-info') }} " data-key="{{ucwords($key)}}">{{$counter}}</span>
                            @php($counter++)
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="answer-details">
                    <h6>Question & Answer</h6>
                    @php($i=1)
                    @foreach ($answers as $ans)
                    <div class="mcq-solution-sheet d-none" id="ans-block-Q-{{ $i }}"> 
                        <div class="text-end mb-1"><a href="/student/mcq-exams/{{$exam->id}}/cqcs/create?title={{ rawurlencode('Q'.$i.'. '.($ans->question ?? $ans->getQuestion->name ?? '')) }}" class="ms-2 btn btn-sm btn-danger text-nowrap">Report Question</a></div>

                        <h5 class="d-flex gap-1">
                            <div class="">{{$i}}.</div>
                            <div class="text-justify" style="text-align:justify;">{!!$ans->question ?? $ans->getQuestion->name ?? '' !!}  <small class="text-secondary">({{$exam->marks_per_question}} Marks)</small></div>
                        </h5>
                        <h6>Options:</h6>
                        <div class="">
                            <div class="d-flex gap-1">
                                <div class="">A.</div>
                                <div class="text-justify" style="text-align:justify;">{!! $ans->getQuestion->opt_a ?? '' !!}</div>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="">B.</div>
                                <div class="text-justify" style="text-align:justify;">{!! $ans->getQuestion->opt_b ?? '' !!}</div>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="">C.</div>
                                <div class="text-justify" style="text-align:justify;">{!! $ans->getQuestion->opt_c ?? '' !!}</div>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="">D.</div>
                                <div class="text-justify" style="text-align:justify;">{!! $ans->getQuestion->opt_d ?? '' !!}</div>
                            </div>
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
                            <h6 style="color: red;">Rationale / Justification:</h6>
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

    <script type="text/javascript" src="{{asset('js/noprint.js')}}"></script>

    <script>
        $('.question-key').on('click', function(){
            var key = $(this).data('key');
            $('.mcq-solution-sheet').addClass('d-none');
            $('#ans-block-'+key).removeClass('d-none');
        });

    </script>
@endsection
