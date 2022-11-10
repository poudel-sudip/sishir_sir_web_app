@extends('admin.layouts.app')
@section('admin-title')
    Video Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Video Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
                    <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/chapters">Chapters</a></li>
                    <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos">Videos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show Video </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$video->title}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Video Course:</div>
                            <div>{{$course->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Chapter Name:</div>
                            <div>{{$chapter->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Video Title: </div>
                            <div>{{$video->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Video Slug: </div>
                            <div>{{$video->slug }}</div>
                        </div>
                        <div class="course-row">
                            <div>Is Public Video </div>
                            <div>{{$video->isPublic }}</div>
                        </div>
                        <div class="course-row">
                            <div>Video URL: </div>
                            <div>{{url($video->link) }}</div>
                        </div>
                        <div class="course-row">
                            <div>Video Content: </div>
                            <div>{!! $video->content !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Video Status: </div>
                            <div>{{$video->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Play Video: </div>
                            <div> 
                                <a class="view-video btn btn-info" href="#videoModal" video-title="{{$video->title}}" video-url="{{$video->link}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play <span class="fas fa-video mdi mdi-video"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div id="videoModal" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="playingTitle"> </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="videoPlayer" class="embed-responsive embed-responsive-16by9"> </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
