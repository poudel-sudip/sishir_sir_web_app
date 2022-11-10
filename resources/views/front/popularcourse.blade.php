@extends('front.layouts.app')
@section('title')
  Popular Courses
@endsection
@section('content')
    <div class="container">
        <div class="popular-course-container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Popular Courses</h2>
                </div>
            </div>
            <div class="row course-section">
                @foreach ($data as $course)
                <div class="col-md-3">
                    <div class="card-course">
                        <div class="header">
                            <div class="post-thumb">
                                <img src="/storage/{{$course->image}}" alt="{{$course->name}}">
                            </div>
                            <div class="post-category">
                            <a href="">{{$course->category->name}}</a>
                            </div>
                        </div>
                        <div class="body">
                            <h5 class="post-title text-center">{{$course->name}}</h5>
                           <div class="course-info text-center">
                             <a class="course-price" href="/courses/{{$course->slug}}">View Details</a>
                           </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection