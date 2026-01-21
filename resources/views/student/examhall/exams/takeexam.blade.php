@extends('student.layouts.app')
@section('student-title')
    Attempt Exam
@endsection
@section('student-title-icon')
    <i class="fas fa-check-square"></i>
@endsection

@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card student_exam_card">
                    <div class="card-header bg-white">  
                        {{-- <h4>{{$category->title}}</h4> --}}
                        <h4>{{$exam->name}}</h4>                     
                        <div class="icon-bar mcq-countdown" >
                           Exam Time CountDown : <span class="js-timeout"></span>
                        </div>
                        <div class="text-start" id="attempt-question-count"> </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="/student/exam-bookings/{{$category->id}}/exams/{{$exam->id}}/save" method="POST" id="exam-form">
                            @csrf

                            @php
                                $pages = $exam->questions->chunk(10); // Split into pages
                                $key = -1;
                            @endphp
                        
                            <!-- Top Navigation -->                               
                            <div class="owl-nav d-flex justify-content-end my-1" style="margin-top: -10px">
                                <button type="button" class="mx-1 btn border border-primary text-primary owl-prev" style="font-size: 18px;">Previous Page</button>
                                <button type="button" class="mx-1 btn border border-primary text-primary owl-next" style="font-size: 18px;">Next Page</button>
                            </div>
                        
                            <div class="owl-carousel MCQ-exam MCQ-List" style="">
                                @foreach($pages as $pageIndex => $questions)
                                    <div class="mcq-question-list page-{{ $pageIndex + 1 }}" style="">
                                        @foreach($questions as $key => $ques)                                        
                                            <div class="mcq-question my-2" style=" ">
                                                <input type="hidden" name="question-{{$key+1}}" value="{{$ques->id}}">
                                                <input type="hidden" name="ans-{{$key+1}}" value="">
                                                <h6 class="mt-3" style="font-size:20px; text-align:justify;">
                                                    {{$key+1}}. {!!$ques->name!!}
                                                    <small class="text-secondary">({{$exam->marks_per_question}} Marks)</small>
                                                </h6>
                        
                                                <div class="mcq-check-option mt-3" style="">
                                                    <div class="mcq-qstn-row">
                                                        <input type="radio" name="ans-{{$key+1}}" value="A" id="ans-{{$key+1}}-1" />
                                                        <span class="mcq-option">a.</span>
                                                        <label for="ans-{{$key+1}}-1"> {!! $ques->opt_a !!} </label>
                                                    </div>
                                                    <div class="mcq-qstn-row">
                                                        <input type="radio" name="ans-{{$key+1}}" value="B" id="ans-{{$key+1}}-2" />
                                                        <span class="mcq-option">b.</span>
                                                        <label for="ans-{{$key+1}}-2"> {!!$ques->opt_b!!} </label>
                                                    </div>
                                                    <div class="mcq-qstn-row">
                                                        <input type="radio" name="ans-{{$key+1}}" value="C" id="ans-{{$key+1}}-3" />
                                                        <span class="mcq-option">c.</span>
                                                        <label for="ans-{{$key+1}}-3"> {!!$ques->opt_c!!} </label>
                                                    </div>
                                                    <div class="mcq-qstn-row" style="">
                                                        <input type="radio" name="ans-{{$key+1}}" value="D" id="ans-{{$key+1}}-4" />
                                                        <span class="mcq-option">d.</span>
                                                        <label for="ans-{{$key+1}}-4"> {!!$ques->opt_d!!} </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="question-separator" style="">
                                            
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        
                            <!-- Bottom Navigation -->
                            <div class="owl-nav d-flex justify-content-end" style="margin-top: -10px">
                                <button type="button" class="mx-1 btn border border-primary text-primary owl-prev" style="font-size: 18px;">Previous Page</button>
                                <button type="button" class="mx-1 btn border border-primary text-primary owl-next" style="font-size: 18px;">Next Page</button>
                            </div>
                        
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-3 " style="font-size: 18px;">Submit Exam</button>
                            </div>

                            
                            <input type="hidden" name="index" value="<?php echo $key+1 ?>">
                            <input type="hidden" name="exam_id" value="{{$exam->id}}">
                            <input type="hidden" name="category_id" value="{{$category->id}}">
                            <input type="submit" value="Submit" class="exam-submit-button">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>   

@endsection

@section('page-footer-content')

    <script type="text/javascript">
        var interval;
        function countdown() {
        clearInterval(interval);
        interval = setInterval( function() {
                var timer = $('.js-timeout').html();
                timer = timer.split(':');
                var hours = parseInt(timer[0]);
                var minutes = parseInt(timer[1]);
                var seconds = parseInt(timer[2]);
                seconds -= 1;
                if(seconds < 0 )
                {
                    minutes -= 1;
                    seconds = 59; 
                    if(minutes < 0 && hours != 0) 
                    {
                        hours -=1;
                        minutes =59;
                    }
                }

                if (hours < 10 && length.hours != 2) hours = '0' + hours;
                if (minutes < 10 && length.minutes != 2) minutes = '0' + minutes;
                if (seconds < 10 && length.seconds != 2)seconds = '0' + seconds;
                
                $('.js-timeout').html(hours + ':' + minutes + ':' + seconds);

                if (hours== 0 && minutes == 0 && seconds == 0) { 
                    clearInterval(interval);  
                    alert("Time Over Please Click Ok Button"); 
                    $('#exam-form').submit(); 
                }
        }, 1000);
        }
        
        $('.js-timeout').text("{{ $exam->exam_time.':00' }}");
        countdown();
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const totalQuestions = document.querySelectorAll(".mcq-question").length; // Total number of questions
            const questionInputs = document.querySelectorAll(".mcq-check-option input[type='radio']");

            // Function to log the attempted question count
            function logAttemptedCount() {
                const attempted = document.querySelectorAll(".mcq-check-option input[type='radio']:checked").length;
                // console.clear(); // Clears the console for a clean output
                $('#attempt-question-count').html('');
                // console.log(`Attempted Questions: ${attempted} / ${totalQuestions}`);
                $('#attempt-question-count').html(`Attempted Questions: ${attempted} / ${totalQuestions}`);
            }

            // Add event listeners to each radio input
            questionInputs.forEach(input => {
                input.addEventListener("change", function () {
                    if (this.checked) {
                        logAttemptedCount(); // Trigger log when a radio button changes state
                    }
                });
            });

            // Initial log
            logAttemptedCount();
        });
    </script>

    <script>

        $(".MCQ-List").owlCarousel("destroy"); // Destroy existing instance
        var carousel = $(".MCQ-List").owlCarousel({
            items: 1,
            smartSpeed: 600,
            nav: false,
            dots: true,
            loop: false,
            autoHeight: true,
        });

        // Custom Navigation
        $(".owl-nav .owl-prev").click(function () {
            carousel.trigger("prev.owl.carousel");
        });

        $(".owl-nav .owl-next").click(function () {
            carousel.trigger('next.owl.carousel');                    
        });
        
    </script>

@endsection
