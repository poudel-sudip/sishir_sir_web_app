@extends('front.layouts.app')

@section('page_title', ucwords('Question Of The Day'))
@section('og-title', ucwords('Question Of The Day'))
@section('og-url', url('/question-of-the-day/'.$today_question->show_date))
@section('og-description', strip_tags($today_question->question) ? strip_tags(str_replace('<', '  <', $today_question->question)) : $today_question->question )
@if($today_question->image)
@section('og-image', $today_question->image )
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Question Of The Day</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Question Of The Day</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="ebook-section" style="background:transparent">      
            <div class="row">
                <div class="col-md-8">
                    <div class="ebook-page-details border-primary">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-end mb-2">
                                    <span class="mx-2"><i class="fa fa-pen"></i> {{date('Y-m-d',strtotime($today_question->show_date))}}</span>
                                    <span class="mx-2"><i class="fa fa-comments"></i> {{$today_question->comments()->count()}}</span>
                                    <span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span>
                                    <span class="mx-2"><i class="fa fa-share"></i> {{$counterData->page_share_count}}</span>
                                </div>
                                <div class="text-center">
                                    <img src="{{$today_question->image}}" alt="" class="img img-fluid">
                                </div>   
                                <div class="text-center mt-4">
                                    <div class="sharethis-inline-share-buttons" onclick="handleShare(event)" ></div>
                                </div>    
                            </div>                    
                        </div>      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ebook-page-details border-primary">
                        <h4 class="text-center text-primary"><u>Last Day Question</u></h4>
                        @foreach($previous_questions as $question)
                            <div class="text-center my-3">
                                <a href="/question-of-the-day/{{$question->show_date}}">
                                    <img src="{{$question->image}}" alt="" class="img img-fluid">
                                </a>
                            </div>  
                        @endforeach                            
                    </div> 
                </div>
            </div>
                    
            
            <div class="ebook-page-details">
                <div class="row">
                    <div class="col-4">
                        <h4>Comments ({{$today_question->comments()->count()}}) </h4>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-primary btn-sm" id="show_answer_btn" >
                            <i class="fa fa-eye"></i> See The Correct Answer
                        </button>
                    </div>
                    <div class="col-4 text-end">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            Add Comment
                        </button>
                    </div>
                </div>
                
                <div class="tutor-review-container">   
                    <div class="quesetion-correct-answer hidden" id="correct_answer_section">
                        <div class="alert alert-success">
                            <div>The Correct Answer is: </div>
                            <div>
                                <strong> 
                                    @if(strtolower($today_question->opt_correct) == 'a')
                                        A) {{$today_question->opt_a}}
                                    @elseif(strtolower($today_question->opt_correct) == 'b')
                                        B) {{$today_question->opt_b}}
                                    @elseif(strtolower($today_question->opt_correct) == 'c')
                                        C) {{$today_question->opt_c}}
                                    @elseif(strtolower($today_question->opt_correct) == 'd')
                                        D) {{$today_question->opt_d}}
                                    @else
                                    @endif
                                </strong>
                            </div>
                            <div class="mt-3">
                                <h6>Rationale / Justification:</h6>
                                <div>
                                    {!!$today_question->rationale!!}
                                </div>
                            </div>
                        </div>
                    </div>  

                    @if($today_question->comments()->count())
                        <div class="tutor-rev-whole-container" id="content">
                            @foreach($today_question->comments()->orderByDesc('id')->take(20)->get() as $review)
                                <div class="t-single-review item">
                                    <div class="row">
                                        <div class="col-md-3 t-review-header">
                                            <div class="pt-2">
                                                <i class="far fa-user reviewer-icon align-baseline"></i>
                                            </div>
                                            <div>
                                                <h4 class="reviewr-name">{{ucwords($review->name)}}</h4>
                                                <p>{{date('Y-m-d G:i',strtotime($review->created_at))}}</p>
                                            </div>
                                        </div>                                        
                                        <div class="col-md-9 text-justify">
                                            <div class="t-review">
                                                {!! $review->message !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach                                
                        </div>                        
                    @endif                    
                </div>
            </div>

            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h6 class="modal-title" id="reviewModalLabel">Post a Comment</h6>
                        </div>
                        <div class="modal-body">
                            <div class="leave-review">
                                <form action="/question-of-the-day/{{$today_question->show_date}}/comment/add" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">                                        
                                        <div class="col-md-6">
                                            <input type="text" name="name" placeholder="Full Name" class="comment-input" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="email" placeholder="email@gmail.com" class="comment-input" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="numeric" name="contact" placeholder="9876543210" class="comment-input" required>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="contents" class="comment-input" rows="4" placeholder="Write your Message"></textarea>
                                        </div>
                                        <div class="col-md-12 mt-3 text-end">
                                            <button type="button" class="review-submit btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <input type="submit" name="submit" value="Post" id="review-post" class="review-submit btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
                    
    </div>    

    <script>
        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Question Of The Day',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>

    <script>
        $('#show_answer_btn').on('click',function(e){
            $('#correct_answer_section').toggleClass('hidden');
        });
    </script>
@endsection 
