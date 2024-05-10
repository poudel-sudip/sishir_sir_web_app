@extends('front.layouts.app')

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Public Exams</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="/public-exams">Public Exams</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Success</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="about-page">
        <div class="container-fluid px-md-5">
            <div class="public-exam-section">
                <div class="row">
                    <div class="col-md-12">
                        {{-- @if('status')
                        <div class="alert alert-success" role="alert">
                            Hey <strong>{{$result->name}}</strong>, Your exam has been successfully submitted.
                            <br>
                            Your ID is <strong>{{$result->id}} </strong>. Keep your ID safe to view your result once published.
                        </div>
                        @endif --}}
                        <div class="row">
                            <div class="col-12">
                                Name: {{$result->name}} <br>
                                Email: {{$result->email}} <br>
                                ID: {{$result->id}} <br>
                            </div>
                            <div class="col-12 my-3">
                                <h6>Your Result Status is Given Below.</h6>
                                <div class="row px-5">
                                    <span class="col">TQ: {{ $result->total_questions ?? '' }} </span>
                                    <span class="col">FM: {{ ($result->total_questions * ($exam->exam->marks_per_question ?? 1)) }} </span>
                                    <span class="col">LQ: {{ $result->leaved_questions ?? '' }} </span>
                                    <span class="col">CQ: {{ $result->correct_questions ?? '' }} </span>
                                    <span class="col">WQ: {{ $result->wrong_questions ?? '' }} </span>
                                    <span class="col">MO: {{ ($result->correct_questions * ($exam->exam->marks_per_question ?? 1))-($result->wrong_questions * ($exam->exam->negative_marks ?? 0))}} </span>
                                </div>

                                @php($solutions = json_decode($result->remarks))
                                @if(count((array)$solutions))
                                    <div class="mt-4 d-flex justify-content-start align-items-center flex-wrap">
                                        <span class="m-1 btn btn-sm btn-success">Correct({{ $result->correct_questions ?? '' }})</span>
                                        <span class="m-1 btn btn-sm btn-danger">Wrong({{ $result->wrong_questions ?? '' }})</span>
                                        <span class="m-1 btn btn-sm btn-info">Leaved({{ $result->leaved_questions ?? '' }})</span>
                                    </div>
                                    <div class="mt-4 d-flex justify-content-center align-items-center flex-wrap">
                                        @foreach($solutions as $key=>$value)
                                            <span class="m-1 btn btn-sm {{$value == 'c' ? 'btn-success' : ($value == 'w' ? 'btn-danger' : 'btn-info') }} ">{{ucwords($key)}}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @if($exam->show_answer)
                                <div class="col-12 mt-2">
                                    <h6 class="btn border border-success correct-answer-btn"><span>Show</span> The Correct Answers</h6>
                                    <div class="hidden d-flex justify-content-center align-items-center flex-wrap">
                                        @foreach($question_solutions as $key=>$value)
                                            <span class="m-1 btn btn-sm border-primary ">{{$key}}:{{ucwords($value)}}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 text-end mt-3"><a href="/public-exams" class="btn btn-primary btn-sm">View Other Exams</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $('.correct-answer-btn').on('click',function(){
            $(this).next().toggleClass("hidden");
            $(this).find('span').text(function(_, oldText) {
                return oldText.trim() === 'Show' ? 'Hide' : 'Show';
            });
        
        });
    </script>

@endsection