@extends('front.layouts.app')
@section('page_title', 'Play MCQ Quiz ')
@section('content')

    <style>
        .MCQ-exam .owl-item {
            height: auto;
        }

    </style>

    <div class="container-fluid px-md-5">
        <div class="public-exam-section mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="public-question-list">                        
                        <div class="public-question-body">
                            <div id="exam-form">
                                @php
                                    $pages = $questions->chunk(1); // Split into pages
                                    $key = -1;
                                @endphp
                            
                                <div class="mb-3 p-3" >
                                    <div class="q-of-day-home-page px-5 py-3">
                                        <div class="bg-white">
                                            <div class="text-center q-heading px-4" style="width: fit-content !important;" >
                                                <h2 class="q-title">Play Quiz</h2>
                                            </div>
                                            
                                            <div class="owl-carousel MCQ-exam MCQ-List" style="">
                                                @foreach($pages as $pageIndex => $questions)
                                                    <div class="page-{{ $pageIndex + 1 }}" style="">
                                                        @foreach($questions as $key => $ques)
                                                            <div class="mcq-question mt-2" style=" ">
                                                                <div id="" class="q_block">
                                                                    <div class="q-question">
                                                                        Q{{$key+1}}. {!! $ques->question !!}
                                                                    </div>
                                    
                                                                    <div class="q-options-container">
                                                                        <div class="q-option" data-answer="A" data-correct="{{$ques->opt_correct}}">
                                                                            <span class="q-option-marker">A.</span>
                                                                            <div class="q-option-text">{!! $ques->opt_a !!}</div>
                                                                        </div>
                                                                        <div class="q-option" data-answer="B" data-correct="{{$ques->opt_correct}}">
                                                                            <span class="q-option-marker">B.</span>
                                                                            <div class="q-option-text">{!! $ques->opt_b !!}</div>
                                                                        </div>
                                                                        <div class="q-option" data-answer="C" data-correct="{{$ques->opt_correct}}">
                                                                            <span class="q-option-marker">C.</span>
                                                                            <div class="q-option-text">{!! $ques->opt_c !!}</div>
                                                                        </div>
                                                                        <div class="q-option" data-answer="D" data-correct="{{$ques->opt_correct}}">
                                                                            <span class="q-option-marker">D.</span>
                                                                            <div class="q-option-text">{!! $ques->opt_d !!}</div>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                                <div id="" class="qs_block px-3 text-start d-none">
                                                                    <div class="mt-3 q-on-solution"> <strong> Q{{$key+1}}. {!! $ques->question !!} </strong></div>
                                                                    <div class="mt-2">
                                                                        @php($correctkey = 'opt_'.strtolower($ques->opt_correct))                                                                        
                                                                        <em>Ans:</em> <strong class="text-success bold"> [{{$ques->opt_correct}}]  {{$ques->$correctkey}} </strong>
                                                                    </div>
                                                                    <div class="py-2">
                                                                        <em>Explanation:</em>
                                                                        <div>{!! $ques->rationale !!}</div>
                                                                    </div>
                                                                </div>   
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>                                                                                  
                                        </div>

                                        <div class="row justify-content-between align-items-center">
                                            <div class="col">
                                                <a role="button" class="q-view-btn d-none" id="q-viewans-btn">View Solution</a>
                                                <a role="button" class="q-view-btn d-none" id="q-gotit-btn">Got It !</a>
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
            autoHeight: false,
        });

        // Custom Navigation
        $(".owl-nav .owl-prev").click(function () {
            carousel.trigger("prev.owl.carousel");

            if($('.owl-carousel .owl-item.active .mcq-question').find('.q_block').hasClass('d-none'))
            {
                $('#q-viewans-btn').addClass('d-none');
                $('#q-gotit-btn').removeClass('d-none');
            }
            else
            {
                $('#q-viewans-btn').removeClass('d-none');
                $('#q-gotit-btn').addClass('d-none');
            }
                        
        });

        $(".owl-nav .owl-next").click(function () {
            carousel.trigger('next.owl.carousel');  
            if($('.owl-carousel .owl-item.active .mcq-question').find('.q_block').hasClass('d-none'))
            {
                $('#q-viewans-btn').addClass('d-none');
                $('#q-gotit-btn').removeClass('d-none');
            }
            else
            {
                $('#q-viewans-btn').removeClass('d-none');
                $('#q-gotit-btn').addClass('d-none');
            }
                                          
        });
        
    </script>

    <script>
        $( document ).ready(function() {
            $('.q-option').on('click',function(){
                $('#q-viewans-btn').removeClass('d-none');

                var myans = $(this).attr('data-answer');
                var correct = $(this).attr('data-correct');

                $(this).parent().find('.q-option').css('background-color', '');

                if (myans === correct) {
                    $(this).css('background-color', '#91ed91');
                } else {
                    $(this).css('background-color', '#f07f7f');
                    $(this).parent().find('.q-option[data-answer="' + correct + '"]').css('background-color', '#91ed91');
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

        });
    </script>

@endsection

