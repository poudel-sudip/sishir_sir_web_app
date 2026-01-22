@extends('front.layouts.app')
@section('page_title', ($vaccancy->title))
@section('og-title', ($vaccancy->title))
@section('og-url', url('vaccancies/'.$vaccancy->id))
@if($vaccancy->thumbnail)
@section('og-image', asset('/storage/'.$vaccancy->thumbnail))
@endif
@section('og-description', strip_tags(str_replace('<', '  <', $vaccancy->description)))

@section('content')
    <div class="container-fluid px-md-5">
        {{-- <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Vacancy Details</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/vaccancies') }}">Vacancies</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{($vaccancy->title)}}</li>
                    </ol>
                </div>
            </div>
        </div> --}}
        <div class="mt-3 blogs-details-container bg-white border border-success rounded">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-primary text-center">{{($vaccancy->title)}}</h3>
                </div>
                <div class="mt-2 d-flex align-items-center flex-wrap">
                    <span class="mx-3 h6 text-success text-nowrap"><i class="fa fa-user"></i> {{$vaccancy->author}}</span>
                    <span class="mx-3 h6 text-primary text-nowrap"><i class="fa fa-pen"></i> {{$vaccancy->created_at->format('Y-m-d H:i')}}</span>
                    <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                    <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-2 h6 text-nowrap text-primary"> 
                        <span class="text-danger"> {{$counterData->page_download_count ?? '0'}} <i class="fa fa-download"></i> </span> 

                        @if(trim($vaccancy->pdf_file))
                        <a href="{{url('/storage/'.$vaccancy->pdf_file)}}" filename="{{($vaccancy->title)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> Download <i class="fa fa-file-pdf text-danger"></i> ({{$vaccancy->pdf_size}})</a>
                        @endif
                        @if(trim($vaccancy->img_file))
                        <a href="{{url('/storage/'.$vaccancy->img_file)}}" filename="{{($vaccancy->title)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> Download <i class="fa fa-file-image text-danger"></i> ({{$vaccancy->img_size}})</a>
                        @endif
                    </span>

                </div>
            </div>
            <div class="row mt-3">                
                
                <div class="col-md-12 mt-3">
                    <div class="text-center">
                        <img src="/storage/{{$vaccancy->img_file}}" class="img img-fluid" alt="">
                    </div>
                    @if(trim($vaccancy->pdf_file))
                    <div>
                        <div class="_df_book" id="pdf_book_df" source="/storage/{{$vaccancy->pdf_file}}" ></div>
                    </div>
                    @endif

                    <div class="mt-2 blog-full-description">{!! $vaccancy->description !!}</div>
                    <div class="my-2">
                        <div><strong class="me-2">Tags:  </strong> {{implode(', ',$vaccancy->related_tag_names)}} </div>
                        <div><strong>Source/Reference: </strong> <a @if(trim($vaccancy->source)) href="{{$vaccancy->source}}" target="_blank" @endif> {{$vaccancy->source}} </a> </div>
                    </div>

                    <div class="row align-items-center justify-content-end">
                        <div class="col-md-8">
                            <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Vaccancy Details Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

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
            const postData = { type: 'download', page: 'Vaccancy Details Show', pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>
 
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
            hideControls: "share",
        };
    </script>

@endsection
