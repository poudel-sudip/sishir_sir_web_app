@extends('front.layouts.app')

@section('page_title', ($material->name))
@section('og-title', ($material->name))
@section('og-url', url('/library/'.$library_category->slug.'/'.$material->slug))
@section('og-description', strip_tags($material->description) ? strip_tags(str_replace('<', '  <', $material->description)) : $material->name )
@if($material->thumbnail)
@section('og-image', asset('/storage/'.$material->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{($material->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/library') }}">Library</a></li>
                        <li class="breadcrumb-item"><a href="/library/{{$library_category->slug}}">{{($library_category->name)}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{($material->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-md-5">

        <div class="blog-container ">
            <h3 class="text-primary">{{($material->name)}}</h3>
            <div class="px-5 text-primary">
                <span class="mx-2 text-nowrap text-primary"><i class="fa fa-pen"></i> {{date('Y-m-d',strtotime($material->created_at))}}</span>
                <span class="mx-2 text-nowrap text-primary"><i class="fa fa-calendar"></i> {{$material->published_year}}</span>
                <span class="mx-2 text-nowrap text-success"><i class="fa fa-users"></i> {{$material->author}}</span>
                <span class="mx-2 text-nowrap text-danger"><i class="fa fa-file"></i> {{$material->pages}}</span>
                <span class="mx-2 text-nowrap text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                <span class="mx-2 text-nowrap text-primary"><i class="fa fa-download"></i> {{$counterData->page_download_count ?? '0'}}</span>
                <span class="mx-2 text-nowrap text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
            </div>
            <div class="my-4 row align-items-center">
                <div class="col-md-4">
                    @if($material->type == 'file' && $material->download)
                        {{-- @if(auth()->check())
                            <a href="/storage/{{$material->fileurl}}" onclick="handleDownload(event)" class="text-primary">
                                <i class="fa fa-download"></i>  Download
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-primary">
                                <i class="fa fa-download"></i> Login to Download
                            </a>
                        @endif --}}
                    <a href="{{url('/storage/'.$material->fileurl)}}" filename="{{($material->name)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                    @endif
                </div>
                <div class="col-md-8"><div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div></div>
            </div>          

            @if($material->type == 'file')
                <div class="mt-4">  

                    <div class="_df_book" id="pdf_book_df" source="/storage/{{$material->fileurl}}" ></div>

                    
                    {{-- <div class="pdf-container" id="pdf-container" style="max-height:800px;overflow-y: scroll;"></div> --}}
                    
                    {{-- <iframe src="/storage/{{$material->fileurl}}#toolbar=0" 
                        oncontextmenu="return false" 
                        onselectstart="return false" 
                        ondragstart="return false"
                        frameborder="0" 
                        style="width: 100%; min-height:700px" 
                        target="_parent"
                        nodownload>
                    </iframe>  --}}
                </div>
            @endif

            <div class="mt-5 text-justify">
                {!! $material->description !!}
            </div>

            <div class="mt-3">
                <div><strong>Published On: </strong> {{$material->published_year}} </div>
                <div><strong>Author(s)/Publisher(s): </strong>  {{$material->author ? (html_entity_decode('&copy;')."  ".$material->author) : ""}} </div>
                <div><strong>No of Pages: </strong> {{$material->pages}} </div>

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
            backgroundColor: "#1375b9",
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
        load_pdf_reader("/storage/{{$material->fileurl}}");
    </script> --}}

    <script>

        function handleDownload(event) {
            event.preventDefault(); // Prevent the default behavior of the link

            var downloadUrl = event.target.getAttribute("href");
            var filename = event.target.getAttribute("filename");
            var fileExtension = downloadUrl.split('.').pop().toLowerCase();

            var link = document.createElement("a");
            link.href = downloadUrl;
            link.download = filename +" || shisiradhikari.com."+fileExtension; // Set an empty value for the download attribute to preserve the original filename

            document.body.appendChild(link);

            link.click(); // Simulate a click event to initiate the download

            document.body.removeChild(link); // Remove the dynamically created link element
            
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'download', page: 'Library Material',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Library Material',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>

    <script>
        // document.addEventListener('contextmenu', e => e.preventDefault());
        function createPopupWin(url) {
            let height = 400;
            let width = 800;
            var left = ( screen.width - width ) / 2;
            var top = ( screen.height - height ) / 2;
            var newWindow = window.open( url, "Center Window", 'resizable = yes, width=' + width + ', height=' + height + ', top='+ top + ', left=' + left);
        }
    </script>

@endsection
