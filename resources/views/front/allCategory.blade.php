@extends('front.layouts.app')
@section('title')
  Courses
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>All Courses</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Courses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="course-page">
        <div class="container">
            {{-- <div class="row">
                <div class="col-md-12 text-center about-heading">
                  <span class="page-sub-heading">E-TUTORS A GLORIOUS JOURNEY</span>
                  <h2 class="mb-3">"A Journey of thousand miles begins with a single step"</h2>
                </div>
            </div> --}}
            <div class="row courses-details">
                <div class="col-md-3">
                    <div class="side-navbar">
                        <h5><a href="{{ url('/courses') }}">All Categories</a></h5>
                        <ul class="course-nav">
                            @foreach($categories as $cat)
                                <li><a href="/category/{{$cat->slug}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                      </div>
                </div>
                <div class="col-md-9">
                    <div class="all-course-list">
                        <div class="row">
                            @foreach($course as $course)
                            <div class="col-md-4">
                                <div class="card-course">
                                    <div class="header">
                                        <a href="/courses/{{$course->slug}}" class="post-thumb">
                                            <img src="/storage/{{$course->image}}" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <h5 class="post-title"><a href="/courses/{{$course->slug}}">{{$course->name}}</a></h5>
                                        <div class="course-info">
                                            {{-- <div>
                                            <span class="course-price">Rs 3999 <a href=""></a></span>
                                            <span class="course-duration">45 days</span>
                                            </div> --}}
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
