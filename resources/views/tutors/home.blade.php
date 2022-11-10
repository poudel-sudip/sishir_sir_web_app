@extends('tutors.layouts.app')
@section('tutor-title')
    Tutor Home
@endsection
@section('tutor-title-icon')
    <i class="fas fa-house-user"></i>
@endsection
@section('content')
    <div class="tutor-content-wrapper">
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="col-md-4 col-sm-6">
                <div class="tutor-dashboard-card first-block">
                    <div class="grid-item-1">
                        <p>Batch and course</p>
                        <h6>My Classes</h6>
                    </div>
                    <div  class="grid-item-2">
                        <i class="fas fa-laptop"></i> 
                        <p>Number of Classes</p>
                        <h2>{{$count->classes}}</h2>
                    </div>
                    <div  class="grid-item-3">
                        <a href="/tutor/classroom" class="btn btn-sm">View Classes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="tutor-dashboard-card second-block">
                    <div class="grid-item-1">
                        <p>Batch and course</p>
                        <h6>Special Classes</h6>
                    </div>
                    <div  class="grid-item-2">
                        <i class="fas fa-laptop-house"></i>
                        <p>Number of Classes</p>
                        <h2>{{$count->specialClasses}}</h2>
                    </div>
                    <div  class="grid-item-3">
                        <a href="/tutor/special-courses" class="btn btn-sm">View Classes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="tutor-dashboard-card third-block">
                    <div class="grid-item-1">
                        <p>all post</p>
                        <h6>My Post</h6>
                    </div>
                    <div  class="grid-item-2">
                        <i class="far fa-edit"></i>
                        <p>Number of Posts</p>
                        <h2>{{$count->post}}</h2>
                    </div>
                    <div  class="grid-item-3">
                        <a href="/tutor/posts" class="btn btn-sm">View Post</a>
                    </div>
                </div>
            </div>
           
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="news-feeds-list">
                    <h3>News Feeds</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="create-post-tutor">
                                <img src="/storage/{{auth()->user()->photo }}" alt="{{ Auth::user()->name }}" width="60">
                                <a href="{{ url('/tutor/posts/create') }}">
                                    <input type="text" placeholder="What's on your mind ?" readonly>
                                </a>
                            </div>
                        </div>
                    </div>
                    @forelse ($post as $post)
                        <div class="news-post">
                            <div class="post-tutor-user">
                                <img src="/storage/{{$post->tutor->user->photo}}" alt="{{ $post->tutor->name }}">
                                <div>
                                    <a href="/tutor/{{$post->tutor->slug}}">{{ $post->tutor->name }} </a><span> posted on {!! date('d-M-y g:ia',strtotime($post->created_at)) !!}</span>
                                </div>
                            </div>
                            <div class="student-post-dec">{!! $post->description !!}</div>
                            <img src="/storage/{{$post->thumbnail}}" class="w-100" alt="">
                            <h4 class="tutor-post-title">{{ $post->title }}</h4>
                            <div class="comment-view-section">
                                <div class="write-comment-on-post">
                                    <a href="javascript:{}" onclick="javascript:postData({{$post->id}});"><i class="fas fa-comment"></i> Leave a comment</a>                                         
                                </div>
                                <div class="post-comment-share">
                                    {{-- <span>Views: {{$post->views}}</span> --}}
                                    @if (count($post->comments->where('status','Published')) <= 1)
                                    <span>{{$post->comments->where('status','Published')->count()}} Comment</span>
                                    @else
                                    <a class="comment-count-button" href="javascript:{}" onclick="javascript:postComments({{$post->id}});">{{$post->comments->where('status','Published')->count()}} Comments</a>
                                    @endif
                                    <div class="post-share-student"><span><i class="fas fa-share-square"></i> Share</span>
                                    {{-- share on media start--}}
                                    <div class="post-share-option">
                                        <a target="_blank" href='//facebook.com/sharer/sharer.php?u={{url(`/tutor-posts/`. $post->slug)}}'><i class="fab fa-facebook-f"></i></a>
                                        <a target="_blank" href='//twitter.com/intent/tweet?text="{{$post->title}}"&url="{{url(`/tutor-posts/`. $post->slug)}}"'><i class="fab fa-twitter"></i></a>
                                        <a target="_blank" href='//reddit.com/submit?title="{{$post->title}}"&url="{{url(`/tutor-posts/`. $post->slug)}}"'><i class="fab fa-reddit-alien"></i></a>
                                        <a target="_blank" href='//telegram.me/share/url?url="{{url(`/tutor-posts/`. $post->slug)}}"&text="{{$post->title}}"'><i class="fab fa-telegram-plane"></i></a>
                                        <a target="_blank" href='//wa.me/?text="{{url(`/tutor-posts/`. $post->slug)}}"'><i class="fab fa-whatsapp"></i></a>
                                        <a target="_blank" href='//linkedin.com/sharing/share-offsite?mini="true"&url="{{url(`/tutor-posts/`. $post->slug)}}"&title="{{$post->title}}"'><i class="fab fa-linkedin-in"></i></a>
                                        <a target="_blank" href='//pinterest.com/pin/create/button/?url="{{url(`/tutor-posts/`. $post->slug)}}"'><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                    {{-- share on media end--}}
                                    </div> 
                                </div>
                                
                            </div>
                            <div id="write-comment-{{ $post->id }}" class="write-comment-student">
                                <form  action="/tutor/{{$post->id}}/comments/add" method="POST" enctype="multipart/form-data">
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
                        <p>Tutors post is not available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
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
@endsection

 
