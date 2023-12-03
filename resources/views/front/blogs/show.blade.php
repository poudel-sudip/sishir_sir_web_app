@extends('front.layouts.app')
@section('page_title', ucwords($blog->title))
@section('og-title', ucwords($blog->title))
@section('og-url', url('blogs/'.$blog->slug))
@if($blog->image)
@section('og-image', asset('/storage/'.$blog->image))
@endif
@section('og-description', strip_tags(str_replace('<', '  <', $blog->description)))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Blog Details</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/blogs') }}">Blogs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($blog->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container bg-white">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-primary">{{strtoupper($blog->title)}}</h3>
                        </div>
                        <div class="">
                            <span class="mx-2"><i class="fa fa-user"></i> {{$blog->author}}</span>
                            <span class="mx-2"><i class="fa fa-pen"></i> {{$blog->created_at}}</span>
                            <span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span>
                            <span class="mx-2"><i class="fa fa-share"></i> {{$counterData->page_share_count}}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <img src="/storage/{{$blog->image}}" style="width: 100%">
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="blog-full-description">{!! $blog->description !!}</div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                        </div>
                    </div>
                    <div class="row blogs-comment-container mt-4">
                        <div class="col-md-12">
                            <div class="mt-4 leave-comment">
                                <p>Leave Your Comment</p>
                                <form  action="/blogs/{{$blog->id}}/comments/add" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea name="message" class="comment-input" rows="3" placeholder="write your comment"></textarea>
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
                <div class="col-md-4">
                    <div class="home-blog-list">
                        <h5 class="mb-3"><u>Latest Blogs</u></h5>
                        @foreach ($lateat_blogs as $blogs)
                        <div class="row mb-2 @if ($blog->id == $blogs->id) hidden @endif">
                            <div class="col-4">
                                <img src="/storage/{{$blogs->image}}">
                            </div>
                            <div class="col-8">
                                <h4 class="blog-list-title"><a href="/blogs/{{$blogs->slug}}">{{$blogs->title}}</a></h4>
                                <div>Published: <span class="text-primary"> {{date('Y-m-d',strtotime($blogs->created_at))}}</span></div>
                                <div>By: <span class="text-success"> {{$blogs->author}}</span></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Blog Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>
 
@endsection
