@extends('front.layouts.app')

@section('page_title', ($menuSubItem->name))
@section('og-title', ($menuSubItem->name))
@section('og-url', url('/'.$mainMenu->id.'/'.$subMenu->id.'/'.$menuCategory->id.'/'.$menuItem->id.'/'.$menuSubItem->id))
@section('og-description', strip_tags($menuSubItem->description) ? strip_tags(str_replace('<', '  <', $menuSubItem->description)) : $menuSubItem->name )
@if($menuSubItem->thumbnail)
@section('og-image', asset('/storage/'.$menuSubItem->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                {{-- <h2>{{($menuSubItem->name)}}</h2> --}}
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item">{{($mainMenu->name)}}</li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->id}}/{{$subMenu->id}}">{{($subMenu->name)}}</a></li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->id}}/{{$subMenu->id}}/{{$menuCategory->id}}">{{($menuCategory->name)}}</a></li>
                        <li class="breadcrumb-item"><a href="/{{$mainMenu->id}}/{{$subMenu->id}}/{{$menuCategory->id}}/{{$menuItem->id}}">{{($menuItem->name)}}</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{($menuSubItem->name)}}</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-md-5">

        <div class="blog-container ">
            <div class="text-center">
                <h3 class="dchl-title fs-3">{{($menuSubItem->name)}}</h3>
            </div>
            <div class="mt-3">
                <span class="mx-2 text-primary"><i class="fa fa-calendar-alt"></i> {{$menuSubItem->created_at->format('d M, Y, h:i A')}}</span>
                <span class="mx-2 text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                <span class="mx-2 text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                <span class="mx-2 text-primary">
                    <span class="text-danger"> {{$counterData->page_download_count ?? '0'}} <i class="fa fa-download"></i>  </span>
                    @if($menuSubItem->type == 'file' && $menuSubItem->download)
                        <a href="/storage/{{$menuSubItem->fileurl}}" filename="{{($menuSubItem->name)}}" onclick="handleDownload(event)" target="_blank" class="text-primary">  Download <i class="fa fa-file-pdf text-danger"></i> ({{ $menuSubItem->size ?? 'undefined' }}) </a>
                    @endif
                </span>
            </div>

            <div class="mb-4 row align-items-center justify-content-end">
                <div class="col-md-6"><div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div></div>
            </div>  
        
            
            @if($menuSubItem->type == 'file')
                <div class="mt-4">

                    <div class="_df_book" id="pdf_book_df" source="/storage/{{$menuSubItem->fileurl}}" ></div>

                    {{-- <div class="pdf-container" id="pdf-container" style="max-height:800px;overflow-y: scroll;"></div> --}}
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

            <div class="mt-3">
                <div><strong>Author(s)/Publisher(s): </strong>  {{$menuSubItem->author ? (html_entity_decode('&copy;')."  ".$menuSubItem->author) : ""}} </div>    
            </div>
            
        </div>

    </div>


    <link href="{{asset('dflip/css/dflip.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dflip/css/themify-icons.min.css')}}" rel="stylesheet" type="text/css">

    <script src="{{asset('dflip/js/dflip.min.js')}}" type="text/javascript"></script>

    <script>
        var option_pdf_book_df = {
            // height:'100%',
            webgl:true,
            soundEnable: true,
            enableDownload: false,
            backgroundColor: "#0C2B64",
            scrollWheel: false,
            pageMode: DFLIP.PAGE_MODE.SINGLE,
            singlePageMode: DFLIP.SINGLE_PAGE_MODE.BOOKLET,
            allControls: "startPage,altPrev,pageNumber,altNext,endPage,thumbnail,zoomIn,zoomOut,fullScreen,pageMode",
            moreControls: "",
            hideControls: "share,download",
        };
    </script>

    {{-- <script src="{{asset('/js/pdf.min.js') }}"></script>
    <script src="{{asset('/js/pdf.worker.min.js') }}"></script>
    <script src="{{asset('/js/pdf_reader.js') }}"></script>
    <script>
        load_pdf_reader("/storage/{{$menuSubItem->fileurl}}");
    </script>  --}}

    <script>
        function handleDownload(event) {
            event.preventDefault(); // Prevent the default behavior of the link

            var downloadUrl = event.target.getAttribute("href");
            var filename = event.target.getAttribute("filename");
            var fileExtension = downloadUrl.split('.').pop().toLowerCase();

            var link = document.createElement("a");
            link.href = downloadUrl;
            // link.download = filename +" || shisiradhikari.com.pdf"; // Set an empty value for the download attribute to preserve the original filename
            link.download = filename +" || shisiradhikari.com."+fileExtension;

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
