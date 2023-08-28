@extends('front.layouts.app')
@section('page_title', 'All Books')
@section('content')
    <style>
        .single-blog p, .single-blog .blog-description span {
        overflow: visible !important;
        text-overflow: unset !important;
        -webkit-line-clamp: unset !important;
    }
    </style>   

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($publisher->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ucwords($publisher->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-page">
        <div class="container-fluid px-md-5">
            <div class="row course-details">
                <div class="col-md-12">
                    <div class="blog-container">
                        <div class="row">
                            @forelse($categories as $category)
                            <div class="col-md-3 my-3">
                                <a href="/book-publishers/{{$publisher->slug}}/category/{{$category->slug}}">
                                    <div class="single-blog pt-3 border border-primary border-2">
                                        <div class="blog-image">
                                            <img src="/storage/{{$category->image}}" class="img img-fluid" style="max-height: 200px">
                                        </div>
                                        <div class="blog-details text-center">
                                            <h4><a href="/book-publishers/{{$publisher->slug}}/category/{{$category->slug}}">{{ucwords($category->name)}}</a></h4>                                        
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @empty
                                <div>No Book Category Published</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>

@endsection
