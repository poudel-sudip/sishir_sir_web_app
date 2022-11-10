@extends('front.layouts.app')
@section('title')
  Free Videos
@endsection
@section('content')
    <div class="container">
        <div class="popular-course-container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Free Videos</h2>
                </div>
            </div>
            <div class="row course-section">
                @foreach ($videos as $video)
                <div class="col-md-3">
                    <div class="card-course">
                        <div class="header">
                            <div class="post-thumb">
                                <img src="https://img.youtube.com/vi/{{$video->video_id}}/maxresdefault.jpg">
                            </div>
                        </div>
                        <div class="body">
                            <h5 class="post-title text-center">{{$video->title}}</h5>
                           <div class="course-info text-center">
                               <a class="play_video_btn course-price " href="#play_video" video-id="{{$video->video_id}}" data-bs-toggle="modal" data-bs-target="#play_video">View</a>
                           </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div class="modal fade" id="play_video" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Free Video</h5>
                    <button type="button" class="close border-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe
                        id="video_iframe"
                        class="embed-responsive-item"
                        src=""
                        frameborder="0"
                        width="100%"
                        allowfullscreen
                        style="min-height: 400px;">

                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        //home page player
        $(document).ready(function(){
            $('.play_video_btn').click(function(){
                console.log('hello');
                $('#video_iframe').attr('src','');
                let videoID = $(this).attr('video-id');
                let src= "https://www.youtube.com/embed/"+videoID+"?autohide=1&controls=1&showinfo=1";
                $('#video_iframe').attr('src',src);
            });
        });
    </script>
@endsection
