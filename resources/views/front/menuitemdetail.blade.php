@extends('front.layouts.app')

@section('page_title', ucwords($menuItem->name))
@section('og-title', ucwords($menuItem->name))
@section('og-url', url('/'.$mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug.'/'.$menuItem->slug))
@section('og-description', strip_tags($menuItem->description) ? strip_tags(str_replace('<', '  <', $menuItem->description)) : $menuItem->name )
@if($menuItem->thumbnail)
@section('og-image', asset('/storage/'.$menuItem->thumbnail))
@endif

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
            <h4 class="mb-2">{{$menuItem->name}}</h4>
            <div>
                {!! $menuItem->description !!}
            </div>
            
            <div class="my-4 row align-items-center">
                @if($menuItem->type == 'file')
                <div class="col-md-4">
                    <a href="/storage/{{$menuItem->fileurl}}" target="_blank" download class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                </div>
                @endif
                <div class="col-md-8">
                    <div class="sharethis-inline-share-buttons"></div>
                </div>
            </div>
            
            @if($menuItem->type == 'file')
                <div class="mt-4">
                    <iframe src="/storage/{{$menuItem->fileurl}}" 
                        frameborder="0" 
                        style="width: 100%; min-height:700px" 
                        target="_parent">
                    </iframe>
                </div>
            @endif
        </div>
    </div>

@endsection
