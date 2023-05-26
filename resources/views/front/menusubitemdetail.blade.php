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
                @if($menuSubItem->type == 'file' && $menuSubItem->download)
                <div class="col-md-4">
                    <a href="/storage/{{$menuSubItem->fileurl}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                </div>
                @endif
                <div class="col-md-8">
                    <div class="sharethis-inline-share-buttons"></div>
                </div>
            </div>
            
            @if($menuSubItem->type == 'file')
                <div class="mt-4">
                    <div class="pdf-container" id="pdf-container" style="max-height:800px;overflow-y: scroll;"></div>
                    {{-- <iframe src="/storage/{{$menuSubItem->fileurl}}" 
                        frameborder="0" 
                        style="width: 100%; min-height:700px" 
                        target="_parent">
                    </iframe> --}}
                </div>
            @endif
        </div>

    </div>

    <script src="{{asset('/js/pdf.min.js') }}"></script>
    <script src="{{asset('/js/pdf.worker.min.js') }}"></script>
    <script src="{{asset('/js/pdf_reader.js') }}"></script>
    <script>
        load_pdf_reader("/storage/{{$menuSubItem->fileurl}}");

        function handleDownload(event) {
            event.preventDefault(); // Prevent the default behavior of the link

            var downloadUrl = event.target.getAttribute("href");

            var link = document.createElement("a");
            link.href = downloadUrl;
            link.download = ""; // Set an empty value for the download attribute to preserve the original filename

            document.body.appendChild(link);

            link.click(); // Simulate a click event to initiate the download

            document.body.removeChild(link); // Remove the dynamically created link element
        }
    </script>

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
