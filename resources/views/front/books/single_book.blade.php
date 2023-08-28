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
        <div class="blogs-details-container bg-white">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>{{$book->title}}</h2>
                            <div class="d-flex flex-wrap">
                                <h6 class="mx-3"><span class="icon-user-tie text-primary"></span> {{$book->author}}</h6>
                                <div class="mx-3">Edition: <strong class="text-primary">{{$book->edition}}</strong></div>
                                <div class="mx-3">Published On: <strong class="text-primary">{{$book->published_year}}</strong></div>
                                <div class="mx-3">Pages: <strong class="text-primary">{{$book->pages}}</strong></div>
                                <div class="mx-3">Category: <strong class="text-primary ">{{ucwords($book->category->name ?? '')}}</strong></div>
                                <div class="mx-3">Publisher: <strong class="text-primary ">{{ucwords($book->publisher->name ?? '')}}</strong></div>
                                <div class="mx-3">Availability: <strong class="text-primary ">{{ucwords($book->availability)}}</strong></div>
                            </div>
                                                        
                        </div>
                        <div class="col-12 my-3">
                            <div class="sharethis-inline-share-buttons"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <img src="/storage/{{$book->thumbnail}}" style="width: 100%">
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="blog-full-description">{!! $book->description !!}</div>
                        </div>
                    </div> 
                </div>
                
            </div>
        </div>
    </div>

@endsection
