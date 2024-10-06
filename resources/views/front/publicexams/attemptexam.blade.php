@extends('front.layouts.app')
@section('page_title', 'Attempt: '.($exam->name))
@section('content')
    <div class="container-fluid px-md-5">
        <div class="public-exam-section mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="public-question-list">
                    <div class="public-question-header">
                        <h5 class="text-center">{{$exam->name}}</h5>  
                            <div class="d-flex justify-content-around">
                                <span> Name: {{$user->name}} </span>
                                <span> Email: {{$user->email}} </span>
                                <span> Contact: {{$user->contact}} </span>
                                <span>Courses: {{ $user->courses }}</span>
                            </div>                   
                            <div class="icon-bar mt-1 d-flex justify-content-around">
                                <div class="">Total Questions: {{$exam->questions()->count() ?? '0' }}</div>
                                <div class="">Marks Per Question: {{$exam->marks_per_question}}</div>
                                <div class="">Negative Marks: {{$exam->negative_marks}}</div>
                                <div class="me-5">                                
                                    Exam Time CountDown : <span class="js-timeout"></span>
                                </div>
                            </div>
                    </div>
                    <div class="public-question-body">
                        <form action="/public-exams/{{$openexam->slug}}/save" method="POST" id="exam-form">
                            @csrf
                            <div class="owl-carousel MCQ-exam">
                                @php($key=-1)
                                @foreach($exam->questions as $key=>$ques)
                                <div class="mcq-question-list row">
                                    <div class="col-md-7 mcq-question">
                                        <input type="hidden" name="question-{{$key+1}}" value="{{$ques->id}}">
                                        <input type="hidden" name="ans-{{$key+1}}" value="">
                                        <h6 > {{$key+1}}. {!!$ques->name!!}</h6>
                                    </div>
                                    <div class="mcq-check-option col-md-5">
                                        <div class="mcq-qstn-row">
                                        <input type="radio" name="ans-{{$key+1}}" value="A" id="ans-{{$key+1}}-1" /> <span class="mcq-option">a.</span><label for="ans-{{$key+1}}-1"> {!! $ques->opt_a !!} </label>
                                        </div>
                                        <div class="mcq-qstn-row">
                                            <input type="radio" name="ans-{{$key+1}}" value="B" id="ans-{{$key+1}}-2" /> <span class="mcq-option">b.</span><label for="ans-{{$key+1}}-2"> {!!$ques->opt_b!!} </label>
                                        </div>
                                        <div class="mcq-qstn-row">
                                            <input type="radio" name="ans-{{$key+1}}" value="C" id="ans-{{$key+1}}-3" /> <span class="mcq-option">c.</span><label for="ans-{{$key+1}}-3"> {!!$ques->opt_c!!} </label>
                                        </div>
                                        <div class="mcq-qstn-row">
                                            <input type="radio" name="ans-{{$key+1}}" value="D" id="ans-{{$key+1}}-4" /> <span class="mcq-option">d.</span><label for="ans-{{$key+1}}-4"> {!!$ques->opt_d!!} </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                <input type="hidden" name="index" value="<?php echo $key+1 ?>">
                                <input type="hidden" name="exam_id" value="{{$openexam->id}}">
                                <input type="hidden" name="user_name" value="{{$user->name}}">
                                <input type="hidden" name="user_email" value="{{$user->email}}">
                                <input type="hidden" name="user_contact" value="{{$user->contact}}">
                                <input type="hidden" name="courses" value="{{$user->courses}}">
                                <input type="submit" value="Submit" class="btn btn-primary mt-3 mcq-submit-btn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('admin/js/sweetalert2@11.js') }}"></script>

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
                    examSubmitAction('Time Over. Do You Want To Submit Your Exam?');
                }
            }, 1000);
        }
        
        $('.js-timeout').text("{{ $exam->exam_time.':00' }}");
        countdown();

        $('#exam-form').on("submit",function(event){
            event.preventDefault();

            examSubmitAction('Do You Want To Submit Your Exam?');

            return false;
        });

        function examSubmitAction(title)
        {

            Swal.fire({
                title: title,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Submit It',
                cancelButtonText: 'No, Cancel It'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#exam-form').submit();
                }
                else
                {
                    // alert('cancncelled');
                    window.location.href = '/public-exams';
                }
            });

        }
    
    </script>

@endsection
