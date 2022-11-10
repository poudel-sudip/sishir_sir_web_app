@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>E-Books</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">E-Books</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
  
    <section class="course-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="all-course-list">
                        <h3 class="text-center mb-4">All E-Books</h3>
                        <div class="row">
                            @foreach($books as $book)
                                <div class="col-md-3">
                                    <div class="card-course">
                                        <div class="header">
                                            <a href="/ebooks/{{$book->slug}}" class="post-thumb">
                                                <img src="/storage/{{$book->thumbnail}}" alt="">
                                            </a>
                                        </div>
                                        <div class="body">
                                            <h4><a href="/ebooks/{{$book->slug}}">{{ucwords($book->title)}}</a></h4>
                                            <h6 class="text-primary">Author: {{ucwords($book->author)}} </h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection