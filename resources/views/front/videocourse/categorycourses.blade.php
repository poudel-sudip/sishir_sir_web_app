@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Courses | {{$category->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="course-page">
        <div class="container">
            <div class="row courses-details">
                <div class="col-md-3">
                    <div class="side-navbar">
                        <h5><a href="{{ url('/video-courses') }}">All Video Categories</a></h5>
                        <ul class="course-nav">
                            @foreach($categories as $cat)
                                <li><a href="/video-courses/category/{{$cat->slug}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                      </div>
                </div>
                <div class="col-md-9">
                    <div class="all-course-list">
                        <div class="row">
                            @foreach($courses as $course)
                            <div class="col-md-4">
                                <div class="card-course">
                                    <div class="header">
                                        <a href="/video-courses/{{$course->slug}}" class="post-thumb">
                                            <img src="/storage/{{$course->thumbnail}}" alt="" class="img img-fluid">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <h5 class="post-title"><a href="/video-courses/{{$course->slug}}">{{$course->name}}</a></h5>
                                        <div class="course-info">
                                            <div class="start-course">Status:<span>{{$course->status}}</span></div>
                                        </div>
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
