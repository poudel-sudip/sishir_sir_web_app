@extends('front.layouts.app')

@section('page_title', 'Play Free Video')
@section('og-title', 'Play Free Video')
@section('og-url', url('/free-videos/'.$video->id))
@section('og-description', 'Play Free Video')

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($video->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/free-videos') }}">All Videos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($video->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid  ebook-section " style="background: transparent;">     
                  
            <div class="ebook-page-details " style="height: 100%">
                <div class="text-end mx-5 mb-3"><span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span></div> 
                <div class="w-100">
                    <iframe
                        id="video_iframe"
                        class="embed-responsive-item"
                        src="https://www.youtube.com/embed/{{$video->video_id}}?autohide=1&controls=1&showinfo=1&autoplay=1"
                        frameborder="0"
                        width="100%"
                        allowfullscreen
                        style="min-height: 450px;">

                    </iframe>
                </div>
            </div>            
        </div>
    </div>

@endsection 
