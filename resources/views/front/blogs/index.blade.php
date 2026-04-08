@extends('front.layouts.app')
@section('page_title', 'Newsroom')
@section('content')
    <style>
        .hidden{
            display: none
        }
    </style>

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3"> All News </h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Newsroom</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if (isset($blog_categories) && $blog_categories->count())
        <div class="mb-1">
            <nav>
                <div class="d-flex align-items-center justify-content-center footer-imp-link">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper category-swiper nav nav-tabs"> 
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="/newsroom"> <button class="nav-link border active">Home</button> </a>
                            </div>
                            @foreach($blog_categories as $cat)
                                <div class="swiper-slide">
                                    <a href="/newsroom-category/{{$cat->id}}"> <button class="nav-link border">{{$cat->name}}</button> </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                </div>
            </nav>
        </div>
    @endif
    
    <div class="container-fluid px-md-5">
        <div class="blog-container">
            <div class="row">
                @forelse($blogs as $blog)
                <div class="col-md-4 mb-2">
                    <div class="single-blog rounded border border-primary rounded">
                        <div class="blog-image">
                            <a href="/newsroom/{{$blog->id}}"><img src="/storage/{{$blog->image}}"></a>
                        </div>
                        <div class="blog-details" style="background: #bde3ff">
                            <h4><a href="/newsroom/{{$blog->id}}" style="color: #1374ba">{{$blog->title}}</a></h4>
                            <div class="blog-description">{!! Helper::excerpt($blog->description,220) !!}</div>
                            <div class="blog-footer border-danger">
                                <div><i class="fa fa-commenting text-primary" aria-hidden="true"></i> <span class="text-success">{{$blog->comments->where('status','Published')->count()}}</span></div>
                                <div class="text-end">Published: <span class="text-primary"> {{date('Y-m-d',strtotime($blog->created_at))}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>                
                @empty              
                    <div>No News Published</div>
                @endforelse
            </div>
            <div class="">
                {{$blogs->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
        </div>
    </div>

@endsection
