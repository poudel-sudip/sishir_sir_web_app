@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($video->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/video-courses/{{$course->slug ?? ''}}">{{ucwords($course->name ?? 'Course')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($video->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="image image-fluid img img-fluid public-vid-show">
                        {{-- <iframe src="{{$video->link}}" class="w-100">
                        </iframe> --}}
                        @if($videoplayer)
                            {!!$videoplayer!!}
                        @else
                        <img src="/storage/{{$course->thumbnail}}" alt="" class="img img-fluid">
                        @endif
                    </div> 
                    <h4>{{ucwords($video->title)}}</h4>
                    <div class="text-justify my-2">
                        {!! $video->content !!}
                    </div>                           
                        
                </div>

                <div class="col-md-4">
                    <strong>Recommended Videos</strong>
                    @foreach($recommended as $row)
                    <div class="row mb-3 mt-2">
                        <div class="col-6">
                            <div class="rcmd-single-vid">
                                {{-- <iframe src="{{$row->link}}" class="w-100" height="100">
                                </iframe> --}}
                                <iframe  class="w-100" height="100" style="background:url('/storage/{{$course->thumbnail}}');background-size:cover;">
                                </iframe>
                                <a href="/video-courses/video/{{$row->slug}}"><i class="far fa-play-circle"></i></a>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="/video-courses/video/{{$row->slug}}"><h5>{{ucwords($row->title)}}</h5></a>
                            <small>{!! date('d-M-y g:ia',strtotime($row->created_at)) !!}</small>
                        </div>
                    </div>
                        {{-- <li><a href="/video-courses/video/{{$row->slug}}">{{ucwords($row->title)}}</a></li> --}}
                    @endforeach
                </div>
            </div>
            {{-- <div class="card p-3">
                <div class="card-title">
                    <div class="h3 text-center">{{ucwords($video->title)}}</div>
                </div>
                
            </div> --}}
        </div>
    </section>

@endsection
