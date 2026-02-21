@extends('front.layouts.app')
@section('page_title', $healthDay->title)
@section('og-title', $healthDay->title)
@section('og-url', url('/health-days/show/'.$healthDay->id))
@section('og-description', strip_tags($healthDay->description) ? strip_tags(str_replace('<', '  <', $healthDay->description)) : $healthDay->title )
@if($healthDay->thumbnail_image)
@section('og-image', asset('/storage/'.$healthDay->thumbnail_image))
@endif


@section('content')

    <style>
        .health-day-slogan .year{
            background: #fff;
            padding: 2px 5px;
            border-radius: 5px;
            border: 1px solid #9b3e00;
            border-bottom: 3px solid #db3545;
        }
    </style>

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                {{-- <h2>{{$healthDay->title}}</h2> --}}
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/health-days') }}">Health Days</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{($healthDay->title)}}</li> --}}
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container my-3  border border-primary rounded bg-white">
            <div class="row">
                <div class="col-md-12 text-center">
                    {{-- <h3 class="text-primary">{{($healthDay->title)}}</h3> --}}
                    <div class="">
                        <h3 class="text-primary">{{($healthDay->title)}}</h3>
                    </div>
                    <div class="mx-3 h6 text-primary text-nowrap"><i class="fas fa-calendar"></i> {{$healthDay->date}}</div>
                    <div class="mx-3 h6 text-danger text-nowrap border-bottom border-danger pb-2"><i class="fa fa-tag"></i> {{optional($healthDay->category)->name}}</div>
                </div>
                <div class="col-12">
                    <div class="lib-filter-alphabets ">
                        <span class="year-filter lib-filter-character active" charfil="all" style="margin: 5px 0;"> All </span>
                        @foreach($healthDay->slogan_list as $sl)
                            <span class="year-filter lib-filter-character" style="margin: 5px 0;" charfil='{{$sl->year}}'> {{ $sl->year }} </span>
                        @endforeach
                    </div> 
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <span class="mx-3 h6 text-success text-nowrap"> <img src="/storage/{{$healthDay->author_image }}" onerror="this.src='/images/student.jpg'" style="height:35px; width:35px; border-radius:50%; border:1px solid #198754;"> {{$healthDay->author_name}}</span>
                    <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                    {{-- <span class="mx-3 h6 text-primary text-nowrap"><i class="fas fa-calendar"></i> {{$healthDay->date}}</span> --}}
                    {{-- <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-tag"></i> {{optional($healthDay->category)->name}}</span> --}}
                    <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-2 h6 text-nowrap text-primary">
                        <span class="text-danger"> {{$counterData->page_download_count ?? '0'}} <i class="fa fa-download"></i> </span> 
                        @if($healthDay->pdf_file)
                            <a href="{{url('/storage/'.$healthDay->pdf_file)}}" filename="{{($healthDay->title)}}" onclick="handleDownload(event)" target="_blank" class="text-primary"> Download <i class="fa fa-file-pdf text-danger"></i> ({{ $healthDay->pdf_size ?? 'undefined' }}) </a>
                        @endif
                    </span>
                    <span class="mx-3 h6 text-primary text-nowrap" id="read-time"></span>
                    
                </div>
            </div>
            <div class="mt-3">  

                <div class="mt-3">
                    <div class="book-wrapper">
                        @php
                            $hasImage3d = $healthDay->thumbnail_image && Storage::disk('public')->exists($healthDay->thumbnail_image);          
                        @endphp

                        @if($hasImage3d)
                            <div class="text-center">
                                <img
                                    src="/storage/{{$healthDay->thumbnail_image}}"
                                    alt=""
                                    class="img-fluid border p-1 mb-2 mx-auto me-md-5 float-none float-md-start"
                                    style="border-radius:10px; max-height:350px;"
                                >
                            </div>
                            
                        @endif

                        <div class="book-description">
                            {!! $healthDay->description !!}
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    
                    {{-- <div class="blog-full-description" style="color:#000 !important;">{!! $healthDay->description !!}</div> --}}

                    {{-- @if($healthDay->pdf_file)
                        <div class="my-2">
                            <div class="_df_book" id="pdf_book_df" source="/storage/{{$healthDay->pdf_file}}" ></div>
                        </div>
                    @endif --}}

                    @if($healthDay->slogan_list->count())
                        <div class="mt-4 px-md-5">
                            <h5 class="text-danger">Themes/Slogans of {{$healthDay->title}}</h5>
                            <div class="my-2 d-flex align-items-center">
                                <div class="me-3"><strong>Year</strong></div>
                                <div class="ms-3" style=""><strong>Theme/Slogan</strong></div>
                            </div>
                            @foreach ($healthDay->slogan_list as $sl)
                                <div class="my-2 d-flex align-items-center health-day-slogan" id="slogan-{{$sl->year}}">
                                    <div class="me-3 year">{{$sl->year}}</div>
                                    <div class="text-justify"><a href="javascript:void();">{{$sl->title}}</a></div>
                                </div>
                            @endforeach   
                        </div>
                    @endif
                </div>
                <div class="mt-4 row justify-content-end">
                    <div class="col-md-6">
                        <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                    </div>
                </div>
            </div>            
        </div>
    </div>

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
            const postData = { type: 'download', page: 'Health Day Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Health Day Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        $('.year-filter').on('click',function(e){
            filchar = $(this).attr('charfil');
            $('.year-filter').removeClass('active');
            $(this).addClass('active');
            
            if(filchar == 'all')
            {
                $('.health-day-slogan').removeClass('hidden');
            }
            else
            {
                var sl = 'slogan-'+filchar;
                $('.health-day-slogan').addClass('hidden');
                $('#'+sl).removeClass('hidden');
            }
        });

        const lastSloganYear = '{{ optional($healthDay->slogan_list->first())->year ?? "all"}}';
        if(lastSloganYear){
            $('.year-filter').removeClass('active');
            $(`.year-filter[charfil='${lastSloganYear}']`).addClass('active');
            $('.health-day-slogan').addClass('hidden');
            $('#slogan-'+lastSloganYear).removeClass('hidden');
        }

    </script>
  
    {{-- @if($healthDay->pdf_file)
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

    @endif --}}


    
    <script>
        $(document).ready(function () {
            $('table').each(function () {
            $(this).wrap('<div style="overflow-x: auto; display: block; max-width: 100%;"></div>');
            });

            let readTime = calculateReadingTime();
            $('#read-time').html('<i class="fa fa-book-reader"></i> ' + readTime.estimatedMinutes + ' Mins Read');

        });
    </script>
    
@endsection
