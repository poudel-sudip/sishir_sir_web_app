@extends('student.layouts.app')
@section('student-title')
    {{$video->title}}
@endsection

@section('student-title-icon')
    <i class="fas fa-list-ol"></i>
@endsection


@section('content')
    <div class="student-content-wrapper student-enroll-section">
        <div class="row">
            <div class="col-md-12 student-show-video">
                {{-- <iframe src="{{$video->link}}" class="w-100">
                </iframe> --}}
                <div class="col-12" class="w-100">
                    {!! $videoplayer !!}
                </div>
                <h5>{{$video->title}}</h5>
                <hr>
                <h6> Video Content</h6>
                <div>{!! $video->content !!}</div>
            </div>
            <div class="col-md-4">
                
            </div>
            {{-- <div class="col-12 my-2">                                     
                <div>
                    <a class="view-video btn btn-primary" href="#videoModal" video-title="{{$video->title}}" video-url="{{$video->link}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play Video <span class="fas fa-video mdi mdi-video"></span></a>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Modal HTML -->
    {{-- <div id="videoModal" class="modal fade">
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
    </div> --}}
    
@endsection
