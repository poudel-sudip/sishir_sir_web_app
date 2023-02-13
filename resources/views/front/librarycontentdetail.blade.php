@extends('front.layouts.app')

@section('page_title', ucwords($material->name))
@section('og-title', ucwords($material->name))
@section('og-url', url('/library/'.$library_category->slug.'/'.$material->slug))
@section('og-description', strip_tags($material->description) ? strip_tags(str_replace('<', '  <', $material->description)) : $material->name )
@if($material->thumbnail)
@section('og-image', asset('/storage/'.$material->thumbnail))
@endif

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($material->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/library') }}">Library</a></li>
                        <li class="breadcrumb-item"><a href="/library/{{$library_category->slug}}">{{ucwords($library_category->name)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($material->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="blog-container mt-5">
            <h4 class="mb-2">{{$material->name}}</h4>
            <div>
                {!! $material->description !!}
            </div>
            
            <div class="my-4 row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><div class="sharethis-inline-share-buttons" ></div></div>
            </div>
            
            @if($material->type == 'file')
                <div class="mt-4">
                    {{-- <object 
                        width="100%"   
                        height="100%" 
                        style="min-height:800px"
                        type="application/pdf" 
                        data="/storage/{{$material->fileurl}}#toolbar=0" 
                        id="pdf_content">
                        <p>Document load was not successful.</p>
                    </object> --}}
                    <iframe src="/storage/{{$material->fileurl}}#toolbar=0" 
                        frameborder="0" 
                        style="width: 100%; min-height:700px" 
                        target="_parent"
                        nodownload>
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
