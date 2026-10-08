@extends('front.layouts.app')

@section('content')

    <div class="container-fluid px-md-5 py-4 ">
        <!-- Result Title -->
        <div class="text-center mb-5">
            <svg style="height:50px; color:red;" class="trophy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            <h2 class="">{{$analysis->title}}</h2>
            <h5 class="mt-2 text-muted"> 
                <span class="mx-3">ID: {{$analysis->result_id}}</span>
                <span class="mx-3">Name: {{$analysis->user_name}}</span>
            </h5>
        </div>

        <!-- Stats Overview -->
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card text-center p-4 rounded-3 bg-white shadow-sm h-100 animated_border border-danger border-2">
                    <div class="stat-label text-muted">Score</div>
                    <div class="stat-value fw-bold text-danger fs-3 mb-1" id="score">{{$analysis->marks_obtained}}/{{$analysis->full_marks}}</div>
                    <div class="stat-label text-muted" id="percentage">{{$analysis->percentage}}%</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card text-center p-4 rounded-3 bg-white shadow-sm h-100 animated_border border-danger border-2">
                    <div class="stat-label text-muted">Grade</div>
                    <div class="stat-value fw-bold text-danger fs-3 mb-1" id="grade">{{$analysis->grade}}</div>
                    <div class="grade-badge {{$analysis->grade_class}}" id="performance-msg">{{$analysis->grade_msg}}</div>
                </div>
            </div>
            
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card text-center p-4 rounded-3 bg-white shadow-sm h-100 animated_border border-danger border-2">
                    <div class="stat-label text-muted">Accuracy</div>
                    <div class="stat-value fw-bold text-danger fs-3 mb-1" id="accuracy">{{$analysis->percentage}}%</div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="accuracy-bar" style="width: {{$analysis->percentage}}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Overview -->
        <div class="mt-4 card border-0 shadow-card">
            <div class="card-body p-4">
                <h5 class="mb-4"> <i class="fas fa-bullseye me-2"></i> Performance Analysis</h5>

                <div class="analysis-grid">
                    <div class="analysis-item correct">                           
                        <i class="fas fa-check-circle analysis-icon"></i>
                        <div class="analysis-value" id="correct-count">{{$analysis->correct_questions}}</div>
                        <div class="analysis-label">Correct Answers</div>
                    </div>
                    
                    <div class="analysis-item incorrect">
                        <i class="fas fa-times-circle analysis-icon"></i>
                        <div class="analysis-value" id="incorrect-count">{{$analysis->wrong_questions}}</div>
                        <div class="analysis-label">Incorrect Answers</div>
                    </div>
                    
                    <div class="analysis-item unattempted">
                        <i class="fas fa-exclamation-circle analysis-icon"></i>
                        <div class="analysis-value" id="unattempted-count">{{$analysis->leaved_questions}}</div>
                        <div class="analysis-label">Unattempted</div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    {{-- <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3">Public Exam Result</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/public-exams">Public Exams</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Success</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> --}}

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
                            {{-- <div class="col-12">
                                Name: {{$result->name}} <br>
                                Email: {{$result->email}} <br>
                                ID: {{$result->id}} <br>
                            </div> --}}
                            <div class="col-12 my-3">
                                <h6 class="fs-4">Answer Solution Status</h6>
                                {{-- <div class="row px-5">
                                    <span class="col">TQ: {{ $result->total_questions ?? '' }} </span>
                                    <span class="col">FM: {{ ($result->total_questions * ($exam->exam->marks_per_question ?? 1)) }} </span>
                                    <span class="col">LQ: {{ $result->leaved_questions ?? '' }} </span>
                                    <span class="col">CQ: {{ $result->correct_questions ?? '' }} </span>
                                    <span class="col">WQ: {{ $result->wrong_questions ?? '' }} </span>
                                    <span class="col">MO: {{ ($result->correct_questions * ($exam->exam->marks_per_question ?? 1))-($result->wrong_questions * ($exam->exam->negative_marks ?? 0))}} </span>
                                </div> --}}

                                @php($solutions = json_decode($result->remarks))
                                @if(count((array)$solutions))
                                    {{-- <div class="mt-4 d-flex justify-content-start align-items-center flex-wrap">
                                        <span class="m-1 btn btn-sm btn-success">Correct({{ $result->correct_questions ?? '' }})</span>
                                        <span class="m-1 btn btn-sm btn-danger">Wrong({{ $result->wrong_questions ?? '' }})</span>
                                        <span class="m-1 btn btn-sm btn-info">Leaved({{ $result->leaved_questions ?? '' }})</span>
                                    </div> --}}
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
                                    <div class="hidden">
                                        <div class="d-flex justify-content-center align-items-center flex-wrap">
                                            @foreach($question_solutions as $key=>$value)
                                                <span class="m-1 btn btn-sm border-primary ">{{$key}}:{{ucwords($value)}}</span>
                                            @endforeach
                                        </div>
                                        @if($view_pdf)
                                        <div class="">
                                            <a href="/public-exams/{{$exam->id}}/download-questions" target="_blank" class="mt-1 btn border border-danger text-danger">View Question PDF <i class="fas fa-file-pdf "></i></a>
                                        </div>
                                        @endif
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