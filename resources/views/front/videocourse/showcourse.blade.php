@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$course->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/video-courses/category/{{$course->category->slug ?? ''}}">{{ucwords($course->category->name ?? 'Category')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$course->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page mb-5">
        <div class="container">
            {{-- <div class="card-title">
                <div class="h3 text-center">{{$course->name}}</div>
            </div> --}}
            <div class="row">
                <div class="col-md-8">
                    <div class="image image-fluid img img-fluid">
                        @if($introvideo)
                            {!!$introvideo!!}
                        @else
                        <img src="/storage/{{$course->thumbnail}}" alt="" class="img img-fluid">
                        @endif
                    </div> 
                    <h4>{{$course->name}}</h4>
                    <div class="text-justify my-2">
                        {!! $course->description !!}
                    </div>
                    {{-- <hr>
                        <strong>Recommended Videos</strong>
                        @foreach($course->publicVideos as $video)
                            <li><a href="/video-courses/video/{{$video->slug}}">{{ucwords($video->title)}}</a></li>
                        @endforeach --}}
                        
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            {{-- <div>Price</div>  --}}
                            <div>Price <s> Rs. {{$course->fee}}</s> <b class="text-danger"> Rs. {{$course->fee - $course->discount}} /-</b></div>
                            <div class="text-center mt-2">
                                <a href="/student/video-course/enroll" class="btn booking-btn w-50 btn-sm">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="public-recommended-video">
                        <div class="mb-2"><strong>Recommended Videos</strong></div>
                        @foreach($course->publicVideos as $video)
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="rcmd-single-vid">
                                        {{-- <iframe src="{{$video->link}}" class="w-100" height="100">
                                        </iframe> --}}
                                        <iframe  class="w-100" height="100" style="background:url('/storage/{{$course->thumbnail}}');background-size:cover;">
                                        </iframe>
                                        <a href="/video-courses/video/{{$video->slug}}"><i class="far fa-play-circle"></i></a>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <a href="/video-courses/video/{{$video->slug}}"><h5>{{ucwords($video->title)}}</h5></a>
                                    <small>{!! date('d-M-y g:ia',strtotime($video->created_at)) !!}</small>
                                </div>
                            </div>
                            {{-- <li><a href="/video-courses/video/{{$video->slug}}">{{ucwords($video->title)}}</a></li> --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
