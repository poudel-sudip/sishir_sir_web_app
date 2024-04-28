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
                <h2>{{ ucwords($category->name ?? ($publisher->name.' all')) }} Books</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$publisher->slug}}">{{ucwords($publisher->name)}}</a></li>
                        @if($category)
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$publisher->slug}}/category/{{$category->slug}}">{{ucwords($category->name)}}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">Books</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-page">
        <div class="container-fluid px-md-5">
            <div class="row course-details">
                <div class="col-md-3">
                    <div class="side-navbar">
                        <h5><a href="/book-publishers/{{$publisher->slug}}/all-books">All Books</a></h5>
                        <ul class="course-nav" style="height:auto; min-height: 370px; ">
                            @foreach($categories as $cat)
                                <li><a href="/book-publishers/{{$publisher->slug}}/category/{{$cat->slug}}">{{ucwords($cat->name)}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="blog-container">
                        <div class="row">
                            @forelse($books as $book)
                            <div class="col-md-4 my-3">
                                <a href="/books/{{$book->slug}}">
                                    <div class="single-blog pt-3 border border-primary border-2">
                                        <div class="blog-image text-center">
                                            <img src="/storage/{{$book->thumbnail}}">
                                        </div>
                                        <div class="blog-details">
                                            <h4 class="text-center"><a href="/books/{{$book->slug}}">{{$book->title}}</a></h4>
                                            <div class="text-center text-danger" style="margin-top: -0.5rem;"> (Edition: <span class="text-primary">{{ $book->edition ?? '' }}</span>) </div>
                                            <div class="mx-2">
                                                <span>Price: <strong class="text-success">Rs. {{($book->price - (($book->price*$book->discount)/100))}}</strong></span>
                                                <span class="text-danger" style="float: right"><s>Rs. {{ $book->price }}</s></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
