@extends('front.layouts.app')

@section('page_title', $healthDay->title)
@section('og-title', $healthDay->title)
@section('og-url', url('/health-days/show/'.$healthDay->id))
@section('og-description', strip_tags($healthDay->description) ? strip_tags(str_replace('<', '  <', $healthDay->description)) : $healthDay->title )
@if($healthDay->image)
@section('og-image', asset('/storage/'.$healthDay->image))
@endif



@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$healthDay->title}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/health-days') }}">Health Days</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/health-days/year/'.date('Y', strtotime($healthDay->date))) }}">{{date('Y', strtotime($healthDay->date))}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$healthDay->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-md-5">
        <div class="blog-container ">
            <h3 class="text-primary">{{$healthDay->title}}</h3>
            <div class="px-5">
                <span class="mx-3 h6 text-primary text-nowrap"><i class="fa fa-pen"></i> {{$healthDay->date}}</span>
                <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
            </div>

            <div class="my-4 row align-items-center">
                <div class="col-md-4">
                    @if(trim($healthDay->pdf_file))
                        <a href="/storage/{{$healthDay->pdf_file}}" filename="{{($healthDay->title)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> <i class="fa fa-download"></i>  Download</a>
                    @endif
                </div>
                <div class="col-md-8"><div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div></div>
            </div>
        
            <div class="my-2">
                <span class="mx-3 h6 text-success text-nowrap"><i class="fa fa-user"></i> Author(s): {{$healthDay->author}}</span>
            </div>
            
            @if(trim($healthDay->pdf_file))
                <div class="mt-4">
                    <div class="_df_book" id="pdf_book_df" source="/storage/{{$healthDay->pdf_file}}" ></div>
                </div>
            @endif

            <div class="my-4">
                {!! $healthDay->description !!}
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
            const postData = { type: 'download', page: 'Health Day Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Health Day Show',pageurl: pageURL };
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
