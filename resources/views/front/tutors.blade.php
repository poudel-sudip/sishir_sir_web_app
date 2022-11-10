@extends('front.layouts.app')
@section('title')
  Tutors
@endsection
@section('content')
    <div class="container">
        <div class="popular-course-container">
            <div class="row">
                <div class="col-md-12">
                    <h2>All Tutors</h2>
                </div>
            </div>
            <div class="row course-section tutor-page-section">
                @foreach ($tutors as $tutor)
                <div class="col-md-3">
                    <div class="card-course">
                        <div class="header">
                            <div class="post-thumb">
                                <a href="/tutor/{{$tutor->slug}}">
                                @if($tutor->user->photo)
                                <img src="/storage/{{$tutor->user->photo}}" alt="{{$tutor->name}}">
                                @else
                                    <img src="{{ asset('images/tutor.jpg') }}" alt="{{$tutor->name}}">
                                @endif
                                </a>
                            </div>
                        </div>
                        <div class="body">
                            <h5 class="post-title text-center">{{$tutor->name}}</h5>
                           <div class="course-info text-center">
                             <a class="course-price" href="/tutor/{{$tutor->slug}}">View Details</a>
                           </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection