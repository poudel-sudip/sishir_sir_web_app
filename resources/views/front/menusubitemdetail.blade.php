@extends('front.layouts.app')

@section('page_title', ucwords($menuSubItem->name))
@section('og-title', ucwords($menuSubItem->name))
@section('og-url', url('/'.$mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug.'/'.$menuItem->slug.'/'.$menuSubItem->slug))
@section('og-description', strip_tags($menuSubItem->description) ? strip_tags(str_replace('<', '  <', $menuSubItem->description)) : $menuSubItem->name )
@if($menuSubItem->thumbnail)
@section('og-image', asset('/storage/'.$menuSubItem->thumbnail))
@endif

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($menuSubItem->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item">{{ucwords($mainMenu->name)}}</li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}">{{ucwords($subMenu->name)}}</a></li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$menuCategory->slug}}">{{ucwords($menuCategory->name)}}</a></li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->slug}}/{{$subMenu->slug}}/{{$menuCategory->slug}}/{{$menuItem->slug}}">{{ucwords($menuItem->name)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($menuSubItem->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="blog-container mt-5">
            <h4 class="mb-2">{{$menuSubItem->name}}</h4>
            <div>
                {!! $menuSubItem->description !!}
            </div>
            
            <div class="my-4 row align-items-center">
                @if($menuSubItem->type == 'file')
                <div class="col-md-4">
                    <a href="/storage/{{$menuSubItem->fileurl}}" target="_blank" download class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                </div>
                @endif
                <div class="col-md-8">
                    <div class="sharethis-inline-share-buttons"></div>
                </div>
            </div>
            
            @if($menuSubItem->type == 'file')
                <div class="mt-4">
                    <iframe src="/storage/{{$menuSubItem->fileurl}}" 
                        frameborder="0" 
                        style="width: 100%; min-height:700px" 
                        target="_parent">
                    </iframe>
                </div>
            @endif
        </div>

    </div>

    <script>
        function createPopupWin(url) {
            let height = 400;
            let width = 800;
            var left = ( screen.width - width ) / 2;
            var top = ( screen.height - height ) / 2;
            var newWindow = window.open( url, "Center Window", 'resizable = yes, width=' + width + ', height=' + height + ', top='+ top + ', left=' + left);
        }
    </script>

@endsection
