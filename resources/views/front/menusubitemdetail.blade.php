@extends('front.layouts.app')

@section('page_title', ucwords($menuSubItem->name))
@section('og-title', ucwords($menuSubItem->name))
@section('og-url', url('/'.$mainMenu->slug.'/'.$subMenu->slug.'/'.$menuCategory->slug.'/'.$menuItem->slug.'/'.$menuSubItem->slug))
@section('og-description', strip_tags($menuSubItem->description) ? strip_tags(str_replace('<', '  <', $menuSubItem->description)) : $menuSubItem->name )
@if($menuSubItem->thumbnail)
@section('og-image', asset('/storage/'.$menuSubItem->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
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
    <div class="container-fluid px-md-5">

        <div class="blog-container ">
            <h3 class="text-primary">{{strtoupper($menuSubItem->name)}}</h3>
            <div class="px-5">
                <span class="mx-2"><i class="fa fa-pen"></i> {{date('Y-m-d',strtotime($menuSubItem->created_at))}}</span>
                <span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span>
                <span class="mx-2"><i class="fa fa-download"></i> {{$counterData->page_download_count}}</span>
                <span class="mx-2"><i class="fa fa-share"></i> {{$counterData->page_share_count}}</span>
            </div>

            <div class="my-4 row align-items-center">
                <div class="col-md-4">
                    @if($menuSubItem->type == 'file' && $menuSubItem->download)
                    <a href="/storage/{{$menuSubItem->fileurl}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                    @endif
                </div>
                <div class="col-md-8"><div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div></div>
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

            <div class="my-4">
                {!! $menuSubItem->description !!}
            </div>

            <div class="my-4">
                <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
            </div>
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

            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'download', page: 'Menu Sub Item',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Menu Sub Item',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
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
