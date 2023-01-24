@extends('front.layouts.app')
@section('page_title', 'Search: '.ucwords($query ?? ''))
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($query ?? '')}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Search</li>
                        <li class="breadcrumb-item active" aria-current="page">{{$query ?? ''}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="search-area-container">
            <div class="row">
                <div class="col md-12">
                    <h4>Search Results for : {{$query ?? ''}}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6 single-search-area">  
                    <h5>Posts: {{count($menu_posts)}}</h5> 
                    @foreach($menu_posts as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>
    
                <div class="col-6 single-search-area">
                    <h5> Books: {{count($books)}} </h5>
                    @foreach($books as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    <h5> Premium Exams: {{count($premium_exams)}} </h5>
                    @foreach($premium_exams as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    <h5> Blogs: {{count($blogs)}} </h5>
                    @foreach($blogs as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

@endsection
