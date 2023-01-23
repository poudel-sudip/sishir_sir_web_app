@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($menuItem->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item">{{ucwords($mainMenu->name)}}</li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}">{{ucwords($subMenu->name)}}</a></li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$menuCategory->slug}}">{{ucwords($menuCategory->name)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($menuItem->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-container mt-5">
            <h5>{{$menuItem->name}}</h5>
            <div>
                {!! $menuItem->description !!}
            </div>
            <div class="post-share-option" >
                @php($shareLink = url($mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug.'/'.$menuItem->slug))
                <h6 class="text-primary my-2 d-inline-block">Share On: </h6>
                <a target="_blank" href='//facebook.com/sharer/sharer.php?u={{$shareLink}}'><i class="fab fa-facebook-f"></i></a>
                <a target="_blank" href='//twitter.com/intent/tweet?text="{{$menuItem->name}}"&url="{{$shareLink}}"'><i class="fab fa-twitter"></i></a>
                <a target="_blank" href='//reddit.com/submit?title="{{$menuItem->name}}"&url="{{$shareLink}}"'><i class="fab fa-reddit-alien"></i></a>
                <a target="_blank" href='//telegram.me/share/url?url="{{$shareLink}}"&text="{{$menuItem->name}}"'><i class="fab fa-telegram-plane"></i></a>
                <a target="_blank" href='//wa.me/?text="{{$shareLink}}"'><i class="fab fa-whatsapp"></i></a>
                <a target="_blank" href='//linkedin.com/sharing/share-offsite?mini="true"&url="{{$shareLink}}"&title="{{$menuItem->name}}"'><i class="fab fa-linkedin-in"></i></a>
                <a target="_blank" href='//pinterest.com/pin/create/button/?url="{{$shareLink}}"'><i class="fab fa-pinterest-p"></i></a>
            </div>
            @if($menuItem->type == 'file')
                <div><a href="/storage/{{$menuItem->fileurl}}" target="_blank" download class="text-primary"> <i class="fa fa-download"></i>  Download</a></div>
                <div class="mt-4">
                    <iframe src="/storage/{{$menuItem->fileurl}}" 
                        frameborder="0" 
                        style="width: 100%; min-height:500px" 
                        target="_parent">
                    </iframe>
                </div>
            @endif
        </div>
    </div>

@endsection
