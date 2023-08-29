@extends('front.layouts.app')

@section('page_title', ucwords($book->title))
@section('og-title', ucwords($book->title))
@section('og-url', url('/books/'.$book->slug))
@section('og-description', strip_tags($book->description) ? strip_tags(str_replace('<', '  <', $book->description)) : $book->title )
@if($book->thumbnail)
@section('og-image', asset('/storage/'.$book->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($book->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        @if($book->publisher)
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$book->publisher->slug}}">{{ucwords($book->publisher->name)}}</a></li>
                        @endif
                        @if($book->category)
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$book->publisher->slug}}/category/{{$book->category->slug}}">{{ucwords($book->category->name)}}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($book->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container ebook-section" style="background:#f3f8fc;">            
            <div class="ebook-page-details">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="/storage/{{$book->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid">                                
                            </div>
                            <div class="col-md-7 book-details">
                                <div class="addto-ebook-favorite">
                                    <button onclick="" title="Add to favorite"><i class="fas fa-heart"></i></button>
                                </div>
                                <h2 class="mt-3 mt-md-0">{{strtoupper($book->title)}}</h2>
                                <h6>
                                    Publisher: <strong class="text-primary"> {{ucwords($book->publisher->name ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Category: <strong class="text-primary"> {{ucwords($book->category->name ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Author(s): <strong class="text-primary"> {{ucwords($book->author ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Edition: <strong class="text-primary"> {{ucwords($book->edition ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Published On: <strong class="text-primary"> {{ucwords($book->published_year ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Pages: <strong class="text-primary"> {{ucwords($book->pages ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Price: <strong class="text-success"> Rs. {{$book->price - $book->discount}}/- </strong>
                                </h6>                                
                                <h6>
                                    Availability: <strong class="text-primary"> {{ucwords($book->availability ?? ' ')}} </strong>
                                </h6>
                               
                                <div class="book-description text-secondary">
                                    {!! $book->description !!}
                                </div>
                                <div class="mt-3 ">
                                    <div class="text-end sharethis-inline-share-buttons"></div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>      
            </div>            
        </div>
    </div>

@endsection 
