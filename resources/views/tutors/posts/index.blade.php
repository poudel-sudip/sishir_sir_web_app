@extends('tutors.layouts.app')
@section('tutor-title')
    My Posts
@endsection
@section('tutor-title-icon')
    <i class="far fa-newspaper"></i>
@endsection

@section('content')
    <style>
        .news-feeds-list{
            margin-top: 5px;
            border-top: 0;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            background: #ffffff;
        }
        .news-feeds-list .news-post{
            margin-top: 0;
            box-shadow: none;
        }
        .news-feeds-list .student-post-dec{
            margin-top: 0;
        }
        .tutor-post-dropdown a{
            padding-left: 10px;
        }
        .comment-action .fa-trash{
            font-size: 16px;
        }
        
    </style>
    <div class="tutor-content-wrapper student-enroll-section">
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
        <div class="row">
            @foreach($posts as $post)
            <div class="col-md-12">
                <div class="news-feeds-list">
                    <div class="tutor-post-list">
                        <div class="post-heading">
                            <h3>{{$post->title}} 
                                <span>@if($post->status == 'Unpublished')
                                <span class="text-danger">( {{$post->status}} )</span>
                                @else
                                    <span class="text-success">( {{$post->status}} )</span>
                                @endif</span>
                            </h3>
                            <span>Posted on  {!! date('d-M-y g:ia',strtotime($post->created_at)) !!}</span>
                        </div>
                        <div class="tutor-post-dropdown">
                            <a href="/tutor/posts/{{$post->id}}/edit"><i class="fas fa-edit text-primary"></i></a>
                            <form id="delete-form-{{$post->id}}" action="/tutor/posts/{{$post->id}}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$post->id}});"><i class="fas fa-trash text-danger"></i></a>
                            </form>
                        </div>
                    </div>
                    <div class="news-post">
                        <div class="student-post-dec">{!! $post->description !!}</div>
                        <img src="/storage/{{$post->thumbnail}}" class="w-100" alt="">
                        {{-- <h4 class="tutor-post-title">{{ $post->title }}</h4> --}}
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
                            <form  action="/tutor/posts/{{$post->id}}/comments/add" method="POST" enctype="multipart/form-data">
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
                                        <div class="comment-action">
                                            <span class="text-success">{{$comment->status}} </span>
                                            <form id="delete-comment-{{$comment->id}}" action="/tutor/posts/{{$post->id}}/comments/{{$comment->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteComment({{$comment->id}});"> <i class="fas fa-trash text-danger"></i></a>
                                            </form>
                                        </div>
                                    </div> 
                                </div>
                                @endforeach
                            </div>
                        </div>  
                    </div>
                </div>

               
                
            </div>
            @endforeach
        </div>
        
        </div>

        <script type="text/javascript">
            function deleteData(id)
            {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-'+id).submit();
                    Swal.fire(
                    'Deleted!',
                    'Your post has been deleted.',
                    'success'
                    )
                }
                })
            };
            function deleteComment(id)
            {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-comment-'+id).submit();
                    Swal.fire(
                    'Deleted!',
                    'Comment has been deleted.',
                    'success'
                    )
                }
                })
            };

        </script>
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
