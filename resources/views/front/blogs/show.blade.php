@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Blog Details</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container bg-white">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{$blog->title}}</h2>
                    <h6 style="display: inline; margin-right:20px"><span class="icon-user-tie text-primary"></span> {{$blog->author}}</h6>
                    <span>Published On: <span class="text-primary text-13">{{$blog->created_at}}</span></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <img src="/storage/{{$blog->image}}" style="width: 100%">
                </div>
                <div class="col-md-12 mt-3">
                    <div class="blog-full-description">{!! $blog->description !!}</div>
                </div>
            </div>
        </div>

        <div class="blogs-comment-container mt-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="mt-4 leave-comment">
                        <p>Leave Your Comment</p>
                        <form  action="/blogs/{{$blog->id}}/comments/add" method="POST" enctype="multipart/form-data">
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
                        @if (count($blog->comments->where('status','Published')) <= 1)
                        <span>{{$blog->comments->where('status','Published')->count()}} Comment</span>
                        @else
                        <span>{{$blog->comments->where('status','Published')->count()}} Comments</span>
                        @endif
                    </div>
                    @foreach ($blog->comments->where('status','Published') as $comment)
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
