@extends('front.layouts.app')

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
                <h2>All Books</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Shishir Books</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-container mt-5">
            <div class="row">
                @forelse($books as $book)
                <div class="col-md-4 mb-2">
                    <div class="single-blog">
                        <div class="blog-image">
                            <img src="/storage/{{$book->thumbnail}}">
                        </div>
                        <div class="blog-details">
                            <h4>{{$book->title}}</h4>
                            <div class="">{!! $book->description !!}</div>
                            <div>
                                <span>Price: <strong class="text-success">RS. {{$book->price - $book->discount}}</strong></span>
                                <span class="text-danger" style="float: right"><s>Rs. {{ $book->price }}</s></span>
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
