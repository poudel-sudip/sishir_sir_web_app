@extends('front.layouts.app')
@section('page_title', $category->name.' | Books')
@section('content')
    <style>
        .single-blog p, .single-blog .blog-description span {
        overflow: visible !important;
        text-overflow: unset !important;
        -webkit-line-clamp: unset !important;
    }
    </style>   

    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($category->name)}} | Books</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="/books-category/{{$category->slug}}">{{ucwords($category->name)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Books</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-page">
        <div class="container">
            <div class="row course-details">
                <div class="col-md-3">
                    <div class="side-navbar">
                        <h5><a href="{{ url('/books') }}">All Categories</a></h5>
                        <ul class="course-nav">
                            @foreach($categories as $cat)
                                <li><a href="/books-category/{{$cat->slug}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="blog-container">
                        <div class="row">
                            @forelse($books as $book)
                            <div class="col-md-4 my-3">
                                <div class="single-blog pt-3">
                                    <div class="blog-image">
                                        <img src="/storage/{{$book->thumbnail}}">
                                    </div>
                                    <div class="blog-details">
                                        <h4><a href="/books/{{$book->slug}}">{{$book->title}}</a></h4>
                                        {{-- <div class="">{!! $book->description !!}</div> --}}
                                        <div class="mx-2">
                                            <span>Price: <strong class="text-success">Rs. {{$book->price - $book->discount}}</strong></span>
                                            <span class="text-danger" style="float: right"><s>Rs. {{ $book->price }}</s></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div>No Books Published</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>

@endsection
