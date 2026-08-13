@extends('student.layouts.app')
@section('student-title')
    Attempt Final Exam
@endsection
@section('student-title-icon')
    <i class="fas fa-check-square"></i>
@endsection

@section('content')
    <div class="student-content-wrapper">       
        <div class="container-fluid ">
            <div class="public-exam-section mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="public-question-list">
                            <div class="public-question-header" style="">
                                <div class="text-center">
                                    <div class=" dchl-title h4">{{$batch->name}}</div>
                                </div>
                                <h5 class="text-center text-primary mb-4"><strong> {{$exam->name}} </strong></h5>  
                                                
                                <div class=" mt-1 d-flex justify-content-around">
                                    <div class=""><strong> Total Questions:</strong> {{$exam->questions()->count() ?? '0' }}</div>
                                    <div class=""><strong> Marks Per Question:</strong> {{$exam->marks_per_question}}</div>
                                    <div class=""><strong> Negative Marks:</strong> {{$exam->negative_marks}}</div>
                                    <div class="me-5">                                
                                        <strong>Exam Time CountDown :</strong> <span class="js-timeout"></span>
                                    </div>
                                </div>
                                <div class="text-center mt-3" id="attempt-question-count"> </div>
                            </div>
                            <div class="public-question-body">
                                <form action="/student/online-course-bookings/{{$booking->id}}/final-exam/{{$exam->id}}/save" method="POST" id="exam-form">
                                    @csrf
                                    @php
                                        $pages = $exam->questions->chunk(5); // Split into pages
                                        $key = -1;
                                    @endphp
                                
                                    <!-- Top Navigation -->                               
                                    <div class="owl-nav d-flex justify-content-end my-1" style="margin-top: -10px">
                                        <button type="button" class="mx-1 btn border border-primary text-primary owl-prev">Previous Page</button>
                                        <button type="button" class="mx-1 btn border border-primary text-primary owl-next">Next Page</button>
                                    </div>
                                
                                    <div class="owl-carousel MCQ-exam MCQ-List" style="">
                                        @foreach($pages as $pageIndex => $questions)
                                            <div class="mcq-question-list page-{{ $pageIndex + 1 }}" style="">
                                                @foreach($questions as $key => $ques)                                        
                                                    <div class="mcq-question my-2" style=" ">
                                                        <input type="hidden" name="question-{{$key+1}}" value="{{$ques->id}}">
                                                        <input type="hidden" name="ans-{{$key+1}}" value="">
                                                        <h6 class="h6 mt-3 d-flex gap-1">
                                                            <div class="">{{$key+1}}.</div>
                                                            <div class="text-justify" style="text-align:justify;">{!! $ques->name !!}  <small class="text-secondary">({{$exam->marks_per_question}} Marks)</small></div>
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
                                        <button type="button" class="mx-1 btn border border-primary text-primary owl-prev">Previous Page</button>
                                        <button type="button" class="mx-1 btn border border-primary text-primary owl-next">Next Page</button>
                                    </div>
                                
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mt-3 " >Submit Exam</button>
                                    </div>

                                    <div class="text-center">
                                        <input type="hidden" name="index" value="<?php echo $key+1 ?>">
                                        <input type="submit" value="Submit" class="btn btn-primary mt-3 mcq-submit-btn">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('page-footer-content')
    <script src="{{ asset('admin/js/sweetalert2@11.js') }}"></script>

    <script type="text/javascript">
        var interval;
        var formSubmitAllowed = false;

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
                    formSubmitAllowed = true;
                    $('#exam-form').submit();
                    // examSubmitAction('Time Over. Do You Want To Submit Your Exam?');
                }
            }, 1000);
        }
        
        $('.js-timeout').text("{{ $exam->exam_time.':00' }}");
        countdown();

        $('#exam-form').on("submit",function(event){
            if (!formSubmitAllowed) {
                event.preventDefault();
                examSubmitAction('Do You Want To Submit Your Exam?');
            }              
        });

        function examSubmitAction(title)
        {           

            formSubmitAllowed = true;
            $('#exam-form').submit();
            return false;

            Swal.fire({
                title: title,
                text: "",
                icon: 'warning',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                denyButtonColor: '#00e3f3',
                confirmButtonText: 'Yes, Submit It',
                cancelButtonText: 'No, Cancel It',
                denyButtonText: 'No, View Other Exams'
            }).then((result) => {
                if(result.isConfirmed) 
                {
                    formSubmitAllowed = true;
                    $('#exam-form').submit();
                }
                else
                {
                    // alert('cancncelled'); 
                    // window.location.href = '/student/online-course-bookings';                   
                }
            });

        }
    
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
                $('#attempt-question-count').html(`<strong> Attempted Questions: </strong> ${attempted} / ${totalQuestions}`);
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
