@extends('front.layouts.app')
@section('title')
  Running Batches
@endsection
@section('content')
    <div class="container">
        <div class="popular-course-container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Running Batches</h2>
                </div>
            </div>
            <div class="row course-section">
                @foreach ($data as $batch)
                <div class="col-md-3">
                    <div class="card-course">
                        <div class="header">
                            <div class="post-thumb">
                                <img src="/storage/{{$batch->course->image}}" alt="{{$batch->name}}">
                            </div>
                            <div class="post-category">
                            <a href="">{{$batch->course->name}}</a>
                            </div>
                        </div>
                        <div class="body">
                            <h5 class="post-title text-center">{{$batch->name}}</h5>
                           <div class="course-info text-center">
                             <a class="course-price" href="/courses/{{$batch->course->slug}}/{{$batch->slug}}">View Details</a>
                           </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection