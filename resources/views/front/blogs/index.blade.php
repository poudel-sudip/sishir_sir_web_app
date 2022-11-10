@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>All Blogs</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blog-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-blog">
                        <div class="blog-image">
                            <a href="/blogs/{{$last_blog->slug}}"><img src="/storage/{{$last_blog->image}}"></a>
                        </div>
                        <div class="blog-details">
                            <h4><a href="/blogs/{{$last_blog->slug}}">{{$last_blog->title}}</a></h4>
                            <div class="blog-description">{!! $last_blog->description !!}</div>
                            <div class="blog-footer-user">
                                <i class="fa fa-user"></i>
                                <h5>{{$last_blog->author}}</h5>
                                <span class="text-primary">at {{date('Y-m-d',strtotime($last_blog->created_at))}}</span>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <style>
        .hidden{
            display: none
        }
    </style>
    <div class="container">
        <div class="blog-container mt-5">
            <div class="row">
                @forelse($blogs as $blog)
                <div class="col-md-4 mb-2 @if ($loop->first) hidden @endif">
                    <div class="single-blog">
                        <div class="blog-image">
                            <a href="/blogs/{{$blog->slug}}"><img src="/storage/{{$blog->image}}"></a>
                        </div>
                        <div class="blog-details">
                            <h4><a href="/blogs/{{$blog->slug}}">{{$blog->title}}</a></h4>
                            <div class="blog-description">{!! $blog->description !!}</div>
                            <div class="blog-footer">
                                <div><i class="fa fa-commenting text-primary" aria-hidden="true"></i> <span class="text-success">{{$blog->comments->where('status','Published')->count()}}</span></div>
                                <div class="text-end">Published: <span class="text-primary"> {{date('Y-m-d',strtotime($blog->created_at))}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
              
                    <div>No Blogs Published</div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
