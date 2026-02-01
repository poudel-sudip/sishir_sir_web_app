@extends('front.layouts.app')
@section('page_title', 'Play Puzzle ')
@section('content')

    <style>
        .MCQ-exam .owl-item {
            height: auto;
        }

        .ans-box {
            text-transform: uppercase;
            font-weight: bold
        }

        .hint-box {
            background: #71c4ff47;
        }

        p{
            color: inherit;
        }

    </style>

    <div class="container-fluid px-md-5">
        <div class="public-exam-section bg-transparent mt-5 p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="public-question-list">                        
                        <div class="public-question-body">
                            <div id="exam-form">
                                @php
                                    $pages = $questions->chunk(1); // Split into pages
                                    $key = -1;
                                @endphp
                            
                                <div class="bg-white p-1" style="border-radius: 15px !important; border: 8px solid #1375b9;">
                                    <div class="q-of-day-home-page px-1 px-md-5 py-3 " style="border-radius: 15px !important; border: 3px solid #ff0000; height: auto;">
                                        <div class="" style="height: auto;">
                                            <div class="text-center q-heading px-4" style="width: fit-content !important;" >
                                                <h2 class="q-title text-danger">Play Puzzle</h2>
                                            </div>
                                            
                                            <div class="owl-carousel MCQ-exam MCQ-List" style="">
                                                @foreach($pages as $pageIndex => $questions)
                                                    <div class="page-{{ $pageIndex + 1 }}" style="">
                                                        @foreach($questions as $key => $ques)
                                                            <div class="mcq-question mt-2" style="height: auto;">
                                                                <div id="" class="q_block">
                                                                    <div class="q-question">
                                                                        <div class="d-flex gap-1">
                                                                            <div class="">Q{{$key+1}}.</div>
                                                                            <div class="text-justify">{!! $ques->question !!}</div>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <div class="q-options-container">
                                                                        <div class="answer-group mt-3 d-flex align-items-center justify-content-center gap-2 flex-wrap" data-qid="{{ $ques->id }}" data-answer="{{ $ques->formatted_answer }}">
                                                                        
                                                                            @foreach ($ques->chars as $i => $charData)
                                                                                <input type="text"
                                                                                    id="{{ $ques->id }}_ans_{{ $i }}"
                                                                                    class="rounded p-1 text-center ans-box {{ $charData['is_hint'] ? 'hint-box' : '' }}"
                                                                                    style="width: 2rem;"
                                                                                    maxlength="1"
                                                                                    value="{{$charData['is_hint'] ? $charData['char'] : ''}}"
                                                                                    {{ $charData['is_hint'] ? 'readonly' : '' }}>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="text-center d-none ans_status" id="{{ $ques->id }}_ans_status">
                                                                            <span class="mt-3 d-inline-block rounded-pill text-white p-2 status"></span>
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <em class="fw-bold text-danger">Hints:</em>
                                                                            <div class="text-justify text-dark">{!! $ques->rationale !!}</div>
                                                                        </div>
                                                                        
                                                                    </div> 
                                                                </div>
                                                                <div id="" class="qs_block px-3 text-start d-none">
                                                                    <div class="mt-3 q-on-solution">
                                                                        <div class="d-flex gap-1">
                                                                            <strong>Q{{$key+1}}.</strong>
                                                                            <strong class="text-justify"> {!! $ques->question !!}</strong>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <em>Ans:</em> <strong class="text-success bold text-justify"> {{$ques->formatted_answer}} </strong>
                                                                    </div>
                                                                    <div class="py-2">
                                                                        <em class="fw-bold text-danger">Explanation:</em>
                                                                        <div class="text-justify text-dark">{!! $ques->rationale !!}</div>
                                                                    </div>
                                                                </div>   
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach

                                                <div class="page-end-page">
                                                    <div class="mcq-question mt-2" style="height: auto;">
                                                        <div class="text-center p-4">
                                                            <h4 class="text-success">You have reached the end of the Sample Puzzle Questions.</h4>
                                                            <p class="mt-3">Login as Student to play full puzzle  and earn reward points.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                                                                  
                                        </div>

                                        <div class="row justify-content-between align-items-center">
                                            <div class="col">
                                                <a role="button" class="q-view-btn d-none text-nowrap" id="q-viewans-btn">View Solution</a>
                                                <a role="button" class="q-view-btn d-none text-nowrap" id="q-gotit-btn">Got It !</a>
                                            </div>

                                            <div class="col owl-nav d-flex justify-content-end" style="margin-top: 10px;">
                                                <button type="button" class="mx-1 btn border border-primary text-primary owl-prev">Previous </button>
                                                <button type="button" class="mx-1 btn border border-primary text-primary owl-next">Next</button>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-footer-content')     

    <script>

        $(".MCQ-List").owlCarousel("destroy"); // Destroy existing instance
        var carousel = $(".MCQ-List").owlCarousel({
            items: 1,
            smartSpeed: 600,
            nav: false,
            dots: false,
            loop: false,
            autoHeight: true,
        });

        // Custom Navigation
        $(".owl-nav .owl-prev").click(function () {
            carousel.trigger("prev.owl.carousel");

            $('#q-viewans-btn').addClass('d-none');
            if($('.owl-carousel .owl-item.active .mcq-question').find('.q_block').hasClass('d-none'))
            {
                $('#q-gotit-btn').removeClass('d-none');
            }
            else
            {
                if(!$('.owl-carousel .owl-item.active .mcq-question .q_block .q-options-container').find('.ans_status').hasClass('d-none'))
                {
                    $('#q-viewans-btn').removeClass('d-none');
                }
                $('#q-gotit-btn').addClass('d-none');
            }
                        
        });

        $(".owl-nav .owl-next").click(function () {
            carousel.trigger('next.owl.carousel');  

            $('#q-viewans-btn').addClass('d-none');
            if($('.owl-carousel .owl-item.active .mcq-question').find('.q_block').hasClass('d-none'))
            {
                $('#q-gotit-btn').removeClass('d-none');
            }
            else
            {
                if(!$('.owl-carousel .owl-item.active .mcq-question .q_block .q-options-container').find('.ans_status').hasClass('d-none'))
                {
                    $('#q-viewans-btn').removeClass('d-none');
                }
                $('#q-gotit-btn').addClass('d-none');
            }
                                          
        });
        
    </script>

    <script>
        $( document ).ready(function() {
            
            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("ans-box")) {

                    e.target.value = e.target.value.toUpperCase();
                    if (e.target.value.length === 1) {

                        let next = e.target.nextElementSibling;

                        while (next && (next.classList.contains("hint-box"))) {
                            next = next.nextElementSibling;
                        }

                        if (next && next.classList.contains("ans-box")) {
                            next.focus();
                        }
                    }

                    const group = e.target.closest(".answer-group");
                    checkAnswer(group.dataset.qid);
                }
            });

            document.addEventListener("keydown", function(e) {

                if (e.target.classList.contains("ans-box")) {

                    if (e.key === "Backspace" && e.target.value === "") {

                        let prev = e.target.previousElementSibling;

                        while (prev && (prev.classList.contains("hint-box"))) {
                            prev = prev.previousElementSibling;
                        }

                        if (prev && prev.classList.contains("ans-box")) {
                            prev.focus();
                        }
                    }

                    const group = e.target.closest(".answer-group");
                    checkAnswer(group.dataset.qid);
                }
            });

            $('#q-viewans-btn').on('click',function(){

                $('.owl-carousel .owl-item.active .mcq-question').find('.q_block').addClass('d-none');
                $('.owl-carousel .owl-item.active .mcq-question').find('.qs_block').removeClass('d-none');
                $('#q-viewans-btn').addClass('d-none');
                $('#q-gotit-btn').removeClass('d-none');
            });

            $('#q-gotit-btn').on('click',function(){
                $('.owl-carousel .owl-item.active .mcq-question').find('.qs_block').addClass('d-none');
                $('.owl-carousel .owl-item.active .mcq-question').find('.q_block').removeClass('d-none');
                $('#q-viewans-btn').removeClass('d-none');
                $('#q-gotit-btn').addClass('d-none');               
            });

            function checkAnswer(qid) 
            {
                const group = document.querySelector(`.answer-group[data-qid="${qid}"]`);
                const correct = group.dataset.answer;
                const inputs = group.querySelectorAll(".ans-box");

                let user = "";

                inputs.forEach(input => {
                    user += input.value.toUpperCase();
                });

                inputs.forEach(i => i.style.border = "2px solid black");
                inputs.forEach(i => i.style.color = "black");

                $('#'+qid+'_ans_status').addClass('d-none');
                $('#'+qid+'_ans_status .status').removeClass('bg-success bg-danger').text('');
                $('#q-viewans-btn').addClass('d-none');

                if (user.length !== correct.length) {
                    return false;
                }

                $('#q-viewans-btn').removeClass('d-none');
                $('#'+qid+'_ans_status').removeClass('d-none');
                const statusElem = $('#'+qid+'_ans_status .status');

                if (user === correct) {
                    inputs.forEach(i => i.style.border = "2px solid green");
                    inputs.forEach(i => i.style.color = "green");
                    $('#'+qid+'_ans_status .status').addClass('bg-success').text("Correct Answer!");
                } else {
                    inputs.forEach(i => i.style.border = "2px solid red");
                    inputs.forEach(i => i.style.color = "red");
                    $('#'+qid+'_ans_status .status').addClass('bg-danger').text("Wrong Answer!");
                }

                group.closest(".owl-stage-outer").style.height = "auto";

                return user === correct;

            }

        });
    </script>

@endsection

