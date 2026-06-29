@extends('student.layouts.app')
@section('student-title')
    Enrolled Course Batch Videos
@endsection
@section('student-title-icon')
    <i class="fas fa-video"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="card">
            <div class="card-body text-center">
                <div class="h4 text-primary"> {{optional($batch->course)->name}} </div>
                <div class="h5 text-success"> {{$batch->name}} </div>
                <hr class="bg-danger">
                <div class="mt-4 row align-items-stretch">  
                    @forelse($videos as $video)
                        <div class="col-md-3 col-6 my-1">    
                            <div class="border p-2 border-info" style="height: 100%">
                                <div style="cursor: pointer" role="button" class="view-video" data-bs-toggle="modal" data-bs-target="#videoModal" video-title="{{$video->videoTitle}}" video-url="{{$video->videoPath}}" video-id="{{$video->id}}">
                                    <div class="h1 text-primary"><i class="fas fa-video"></i></div>
                                    <h6>{{$video->videoTitle}}</h6>
                                </div>
                                <div class="text-primary small">By: {{$video->user_name}} <span>on {{$video->created_at}}</span></div>
                                
                            </div>                              
                        </div>
                    @empty
                        <div class="col-md-3 my-2">No Videos Found</div>
                    @endforelse                      

                </div>
            </div>
        </div>
        
    </div>

    {{-- for view video model start--}}
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title text-white" id="playingTitle"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="videoPlayer" class="embed-responsive embed-responsive-16by9" style=""> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- for view video model end--}}
    
@endsection
