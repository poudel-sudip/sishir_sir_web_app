@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Tutor Post Details</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/tutor/{{$post->tutor->slug}}">{{$post->tutor->name}}</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="blogs-details-container bg-white">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{$post->title}}</h2>
                    <h6 style="display: inline; margin-right:20px"><span class="icon-user-tie text-primary"></span> {{$post->tutor->name}}</h6>
                    <h6 style="display: inline; margin-right:20px"> <span class="fa fa-upload text-primary"></span> Published On: <span class="text-primary text-13">{{date('M d, Y g:i a',strtotime($post->created_at))}}</span></h6>
                    <h6 style="display: inline; margin-right:20px"><span class="fa fa-eye text-primary"></span>Views: <span class="text-primary text-13">{{$post->views}} </span></h6>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <img src="/storage/{{$post->thumbnail}}" style="width: 100%;">
                </div>
                <div class="col-md-12 mt-3">
                    <div class="blog-full-description">{!! $post->description !!}</div>
                </div>
            </div>
        </div>

        <div class="container mt-3">
            <h4>Share</h4>
            <ol>
                <li class="d-inline border"><a target="_blank" href='//facebook.com/sharer/sharer.php?u={{url(`/tutor-posts/`. $post->slug)}}'>Facebook</a></li>
                <li class="d-inline border"><a target="_blank" href='//twitter.com/intent/tweet?text="{{$post->title}}"&url="{{url(`/tutor-posts/`. $post->slug)}}"'>Twitter</a></li>
                <li class="d-inline border"><a target="_blank" href='//reddit.com/submit?title="{{$post->title}}"&url="{{url(`/tutor-posts/`. $post->slug)}}"'>Reddit</a></li>
                <li class="d-inline border"><a target="_blank" href='//telegram.me/share/url?url="{{url(`/tutor-posts/`. $post->slug)}}"&text="{{$post->title}}"'>Telegram</a></li>
                <li class="d-inline border"><a target="_blank" href='//wa.me/?text="{{url(`/tutor-posts/`. $post->slug)}}"'>Whatsapp</a></li>
                <li class="d-inline border"><a target="_blank" href='//linkedin.com/sharing/share-offsite?mini="true"&url="{{url(`/tutor-posts/`. $post->slug)}}"&title="{{$post->title}}"'>linkedin</a></li>
                <li class="d-inline border"><a target="_blank" href='//pinterest.com/pin/create/button/?url="{{url(`/tutor-posts/`. $post->slug)}}"'>Pinterest</a></li>
                
            </ol>
        </div>

        <div class="blogs-comment-container mt-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="mt-4 leave-comment">
                        <p>Leave Your Comment</p>
                        <form  action="/tutor-posts/{{$post->id}}/comments/add" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="message" class="comment-input" rows="3">your message</textarea>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="name" class="comment-input" placeholder="Your Name">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="email" class="comment-input" placeholder="email">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="contact" class="comment-input" placeholder="contact">
                                </div>
                                <div class="col-md-12 mt-3 text-end">
                                    <input type="submit" name="submit" value="Submit" class="comment-submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="comment-header mb-3">
                        @if (count($post->comments->where('status','Published')) <= 1)
                        <span>{{$post->comments->where('status','Published')->count()}} Comment</span>
                        @else
                        <span>{{$post->comments->where('status','Published')->count()}} Comments</span>
                        @endif
                    </div>
                    @foreach ($post->comments->where('status','Published') as $comment)
                    <div class="single-comment">
                        <img src="{{ asset('images/comment.png') }}" alt="" width="100">
                        <div class="commentter">
                            <h5>{{$comment->name}} </h5><span> {{$comment->email}}</span>
                            <p>{{ $comment->created_at }}</p>
                            <div class="message">{!! $comment->message !!}</div>
                        </div> 
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>

@endsection
