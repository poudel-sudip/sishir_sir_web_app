@extends('admin.layouts.app')
@section('admin-title')
    Video Course Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Video Course</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$course->name}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Course ID:</div>
                            <div>{{$course->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Name:</div>
                            <div>{{$course->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Slug: </div>
                            <div>{{$course->slug}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Fee: </div>
                            <div>Rs. {{$course->fee ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Discount: </div>
                            <div>Rs. {{$course->discount ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Category: </div>
                            <div>{{$course->category->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Description: </div>
                            <div>{!! $course->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Is Pinned: </div>
                            <div>{{$course->isPinned}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Status: </div>
                            <div>{{$course->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Live Class Link: </div>
                            <div>{{$course->class_link ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Thumbnail Image: </div>
                            <div><img src="/storage/{{$course->thumbnail}}" width="200"></div>
                        </div>
                        <div class="course-row">
                            <div>Intro Video URL: </div>
                            <div>
                                {{$course->intro_video ?? ''}}  <br><br>
                                <a class="view-video btn btn-info" href="#videoModal" video-title="{{$course->name.' Introduction Video'}}" video-url="{{$course->intro_video}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play <span class="fas fa-video mdi mdi-video"></span></a>
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
