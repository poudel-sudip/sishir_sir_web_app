@extends('front.layouts.app')
@section('page_title', 'Blogs')
@section('content')
    <div class="container-fluid px-md-5">
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
        
    </div>
    {{-- <hr> --}}
    <style>
        .hidden{
            display: none
        }
    </style>
    <div class="container-fluid px-md-5">
        <div class="blog-container mt-5">
            <div class="row">
                @forelse($blogs as $blog)
                <div class="col-md-4 mb-2">
                    <div class="single-blog rounded">
                        <div class="blog-image">
                            <a href="/blogs/{{$blog->id}}"><img src="/storage/{{$blog->image}}"></a>
                        </div>
                        <div class="blog-details">
                            <h4><a href="/blogs/{{$blog->id}}">{{$blog->title}}</a></h4>
                            <div class="blog-description">{!! Helper::excerpt($blog->description,220) !!}</div>
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
            <div class="">
                {{$blogs->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
        </div>
    </div>

@endsection
