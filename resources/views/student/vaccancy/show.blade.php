@extends('student.layouts.app')
@section('student-title', ucwords($vaccancy->title))

@section('student-title-icon')
    <i class="fas fa-graduation-cap "></i>
@endsection

@section('og-title', ucwords($vaccancy->title))
@section('og-url', url('vaccancies/'.$vaccancy->id))
@if($vaccancy->thumbnail)
@section('og-image', asset('/storage/'.$vaccancy->thumbnail))
@endif
@section('og-description', strip_tags(str_replace('<', '  <', $vaccancy->description)))

@section('content')

    <?php 
        $view_count = Helper::addViewCount(ucwords($vaccancy->title),'/vaccancies/'.$vaccancy->id);
    ?>

    <div class="container-fluid">
        
        <div class="blogs-details-container bg-white pt-4">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3 class="text-primary text-center">{{$vaccancy->title}}</h3>
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <span class="mx-3 h6 text-success text-nowrap"><i class="fa fa-user"></i> {{$vaccancy->author}}</span>
                    <span class="mx-3 h6 text-primary text-nowrap"><i class="fa fa-pen"></i> {{$vaccancy->created_at}}</span>
                    <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                </div>
            </div>
            <div class="row mt-3">
                {{-- <div class="col-md-12">
                    <img src="/storage/{{$vaccancy->image}}" style="width: 100%">
                </div> --}}
                <div class="row justify-content-end">
                    <div class="col-md-8">
                        <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="my-2">
                        <span class="mx-2">Tags:  {{implode(', ',$vaccancy->related_tag_names)}} </span>
                        {{-- @foreach ($vaccancy->related_tag_names as $tag)
                            <span class="mx-2">{{$tag}}</span>
                        @endforeach --}}
                    </div>
                    <div class="blog-full-description">{!! $vaccancy->description !!}</div>
                    @if(trim($vaccancy->pdf_file))
                    <div>
                        <div class="_df_book" id="pdf_book_df" source="/storage/{{$vaccancy->pdf_file}}" ></div>
                    </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=63ce36b638862e00198c0bcc&product=inline-share-buttons&source=platform" async="async"></script> 
    <script src="{{asset('js/misc.js')}}" type="text/javascript"></script>

    <script>
        function handleShare(event)
        {
            let pageURL = '/vaccancies/{{$vaccancy->id}}';
            const postData = { type: 'share', page: 'Vaccancy Details Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
            // alert(pageURL);
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
            enableDownload: true,
            backgroundColor: "#1375b9",
            scrollWheel: false,
            pageMode: DFLIP.PAGE_MODE.SINGLE,
            singlePageMode: DFLIP.SINGLE_PAGE_MODE.BOOKLET,
            allControls: "startPage,altPrev,pageNumber,altNext,endPage,thumbnail,zoomIn,zoomOut,fullScreen,pageMode,download",
            moreControls: "",
            hideControls: "share",
        };
    </script>

@endsection
