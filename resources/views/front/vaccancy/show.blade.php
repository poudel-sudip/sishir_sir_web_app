@extends('front.layouts.app')
@section('page_title', ucwords($vaccancy->title))
@section('og-title', ucwords($vaccancy->title))
@section('og-url', url('vaccancies/'.$vaccancy->slug))
@if($vaccancy->thumbnail)
@section('og-image', asset('/storage/'.$vaccancy->thumbnail))
@endif
@section('og-description', strip_tags(str_replace('<', '  <', $vaccancy->description)))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Vaccancy Details</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/vaccancies') }}">Vaccancies</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($vaccancy->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container bg-white">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-primary text-center">{{strtoupper($vaccancy->title)}}</h3>
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
                    <div class="col-md-6">
                        <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="blog-full-description">{!! $vaccancy->description !!}</div>
                    @if(trim($vaccancy->pdf_file))
                    <div>
                        <iframe src="/storage/{{$vaccancy->pdf_file}}#toolbar=1" 
                            oncontextmenu="return false" 
                            onselectstart="return false" 
                            ondragstart="return false"
                            frameborder="0" 
                            style="width: 100%; min-height:700px" 
                            target="_parent"
                            nodownload>
                        </iframe> 
                    </div>
                    @endif
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
    </script>
 
@endsection
