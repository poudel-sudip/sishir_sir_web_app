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
            <div class="blog-container mt-5">
                <div class="row">
                    @forelse($categories as $cat)
                        <div class="col-md-3 mb-3">
                            <div class="single-blog text-center py-3 library-item border border-primary">
                                <div class="">
                                    <a href="/book-publishers/{{$publisher->slug}}/category/{{$cat->slug}}"><i class="h1 fa fa-book"></i></a>
                                </div>
                                <h5><a href="/book-publishers/{{$publisher->slug}}/category/{{$cat->slug}}">{{ucwords($cat->name)}}</a></h5>
                            </div>
                        </div>
                    @empty                  
                        <div>No Book Category Published</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

@endsection
