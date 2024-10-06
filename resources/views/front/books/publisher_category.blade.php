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
                <h2>{{($publisher->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{($publisher->name)}}</li>
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
                            <div class="seller-item border border-primary rounded border-2">
                                <div class="seller-header text-center">
                                    <a href="/book-publishers/{{$publisher->slug}}/category/{{$cat->slug}}">
                                        <img src="/storage/{{$cat->image}}" alt="" onerror="this.src='/images/default-post.png'" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                                    </a>
                                    <h5 class="mt-3"><a href="/book-publishers/{{$publisher->slug}}/category/{{$cat->slug}}">{{($cat->name)}}</a></h5>
                                </div>
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
