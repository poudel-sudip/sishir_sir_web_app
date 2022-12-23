@extends('student.layouts.app')
@section('student-title')
    Student Home
@endsection
@section('student-title-icon')
    <i class="fas fa-house-user"></i>
@endsection

@section('content')
<style>
    .readMore .addText {
        display: none;
    }
</style>
    <div> @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
    </div>
    <section class="news-feeds student-content-wrapper">
        <div class="main-news-home">
            <div class="student-home-block mt-4">

                {{-- <div class="student-dashboard-card block-first">
                    <div class="first-row">
                        <span>Course Bookings</span>
                        <i class="far fa-calendar-check"></i>
                    </div>
                    <div class="second-row">
                        <a class="btn" href="/student/course-bookings">View Bookings</a>
                        <span>{{$count->bookings->courses ?? '-'}}</span>
                    </div>
                </div>

                <div class="student-dashboard-card block-second">
                    <div class="first-row">
                        <span>Course Classroom</span>
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="second-row">
                        <a class="btn" href="/student/course-classroom">View Classes</a>
                        <span>{{$count->bookings->classroom ?? '-'}}</span>
                    </div>
                </div> --}}

                <div class="student-dashboard-card block-third">
                    <div class="first-row">
                        <span>ExamSet Bookings</span>
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="second-row">
                        <a class="btn" href="/student/exam-bookings">View Bookings</a>
                        <span>{{$count->bookings->exams ?? '-'}}</span>
                    </div>
                </div>

                <div class="student-dashboard-card block-fourth">
                    <div class="first-row">
                        <span>E-Book Bookings</span>
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="second-row">
                        <a class="btn" href="/student/ebook-bookings">View Bookings</a>
                        <span>{{$count->bookings->ebooks ?? '-'}}</span>
                    </div>
                </div>
                

            </div>

            {{-- <div class="news-feeds-list">
                <h3>News Feeds</h3>
                @forelse ($posts as $post)
                    <div class="news-post">
                        <div class="post-tutor-user">
                            <img src="{{ $post->user ? ($post->user->photo ? ('/storage/$post->user->photo') : (asset('images/student.jpg'))) : (asset('images/student.jpg')) }}" alt="">
                            <div><a>{{ $post->author }}</a><span> posted on {!! date('d-M-y g:ia',strtotime($post->created_at)) !!}</span></div>
                        </div>
                        <div class="student-post-dec readMore">{!! $post->description !!}</div>
                        <img src="/storage/{{$post->thumbnail}}" class="w-100" alt="">
                        <h4 class="tutor-post-title">{{ $post->title }}</h4>
                        <div class="comment-view-section">
                            <div class="write-comment-on-post">
                                <a href="javascript:{}" onclick="javascript:postData({{$post->id}});"><i class="fas fa-comment"></i> Leave a comment</a>                                         
                            </div>
                            <div class="post-comment-share">
                                @if (count($post->comments->where('status','Published')) <= 1)
                                <span>{{$post->comments->where('status','Published')->count()}} Comment</span>
                                @else
                                <a class="comment-count-button" href="javascript:{}" onclick="javascript:postComments({{$post->id}});">{{$post->comments->where('status','Published')->count()}} Comments</a>
                                @endif
                                <div class="post-share-student"><span><i class="fas fa-share-square"></i> Share</span>
                                <!-- share on media start-->
                                <div class="post-share-option">
                                    <a target="_blank" href='//facebook.com/sharer/sharer.php?u={{url(`/blogs/`. $post->slug)}}'><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href='//twitter.com/intent/tweet?text="{{$post->title}}"&url="{{url(`/blogs/`. $post->slug)}}"'><i class="fab fa-twitter"></i></a>
                                    <a target="_blank" href='//reddit.com/submit?title="{{$post->title}}"&url="{{url(`/blogs/`. $post->slug)}}"'><i class="fab fa-reddit-alien"></i></a>
                                    <a target="_blank" href='//telegram.me/share/url?url="{{url(`/blogs/`. $post->slug)}}"&text="{{$post->title}}"'><i class="fab fa-telegram-plane"></i></a>
                                    <a target="_blank" href='//wa.me/?text="{{url(`/blogs/`. $post->slug)}}"'><i class="fab fa-whatsapp"></i></a>
                                    <a target="_blank" href='//linkedin.com/sharing/share-offsite?mini="true"&url="{{url(`/blogs/`. $post->slug)}}"&title="{{$post->title}}"'><i class="fab fa-linkedin-in"></i></a>
                                    <a target="_blank" href='//pinterest.com/pin/create/button/?url="{{url(`/blogs/`. $post->slug)}}"'><i class="fab fa-pinterest-p"></i></a>
                                </div>
                                <!-- share on media end-->
                                </div> 
                            </div>
                            
                        </div>
                        <div id="write-comment-{{ $post->id }}" class="write-comment-student">
                            <form  action="/blogs/{{$post->id}}/comments/add" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="post-comment-textarea">
                                    <div class="text-area">
                                        <textarea name="message" class="comment-input" placeholder="write a comment"></textarea>
                                    </div>
                                    <div class="comment-user-hidden">
                                        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                        <input type="hidden" name="contact" value="{{ Auth::user()->contact }}">
                                    </div>
                                    <div class="comment-arrow">
                                        <button type="submit" class="comment-submit"><i class="fas fa-location-arrow"></i></button>
                                    </div>
                                </div>
                            </form>
                            <div class="tutor-comment-list">
                                @foreach ($post->comments->where('status','Published') as $comment)
                                <div class="single-comment">
                                    <i class="far fa-user"></i>
                                    <div class="commentter">
                                        <h5>{{$comment->name}} </h5>
                                        <span class="commentter-mail"> {{$comment->email}}</span> on 
                                        <span class="commentter-date">{{ $comment->created_at }}</span>
                                        <div class="message">{!! $comment->message !!}</div>
                                    </div> 
                                </div>
                                @endforeach
                            </div>
                        </div> 
                        
                    </div>
                @empty
                    <p>Blog Posts not available</p>
                @endforelse
            </div> --}}
        </div>
        <div class="news-feeds-contact">
            @include('student.studentContact')
        </div>
    </section>
    <script>
        function postData(id){
            post=document.getElementById('write-comment-'+id)
            $(post).toggle( "slow" );
        };
        function postComments(id){
            comment=document.getElementById('write-comment-'+id)
            $(comment).toggle( "slow" );
        }
        
      </script>

      <script>
          $(document).ready(function() {
            var max = 320;
            $(".readMore").each(function() {
                var str = $(this).text();
                if ($.trim(str).length > max) {
                    var subStr = str.substring(0, max);
                    var hiddenStr = str.substring(max, $.trim(str).length);
                    $(this).empty().html(subStr);
                    $(this).append(' <a href="javascript:void(0);" class="link">Read more…</a>');
                    $(this).append('<span class="addText">' + hiddenStr + '</span>');
                }
            });
            $(".link").click(function() {
                $(this).siblings(".addText").contents().unwrap();
                $(this).remove();
            });
        });
      </script>

@endsection
