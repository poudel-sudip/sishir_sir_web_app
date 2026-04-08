@extends('front.layouts.app')
@section('page_title', 'All Videos')
@section('content')
    <style>
        .single-blog p, .single-blog .blog-description span {
        overflow: visible !important;
        text-overflow: unset !important;
        -webkit-line-clamp: unset !important;
    }
    </style>   

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3">All Videos</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Videos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-page">

        <div class="container-fluid px-md-5">
            <div class="blog-container mt-5">
                <div class="row">
                    @forelse($videos as $video)
                    <div class="col-md-4 card-course">
                        <a href="/free-videos/{{$video->id}}">
                            <div class="single-video w-100" style="position: relative;">
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 1; cursor: pointer;z-index:99" ></div>
                                <iframe
                                    class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/{{$video->video_id}}"
                                    frameborder="0"
                                    width="100%"
                                    height="100%"
                                    allowfullscreen
                                    style="width:100%; height:100%; min-height:250px">
                                </iframe>                                        
                            </div>
                        </a>                        
                    </div>
                    @empty                  
                        <div>No Videos Published</div>
                    @endforelse
                </div>
                <div class="">
                    {{$videos->onEachSide(1)->links('paginator.bootstrap')}}
                </div>
            </div>
        </div>
    </section>

@endsection
