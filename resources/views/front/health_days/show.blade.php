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
                        <li class="breadcrumb-item active" aria-current="page">{{($healthDay->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container my-3  border border-primary rounded">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="text-primary">{{($healthDay->title)}}</h3>
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <span class="mx-3 h6 text-success text-nowrap"> <img src="/storage/{{$healthDay->author_image }}" onerror="this.src='/images/student.jpg'" style="height:35px; width:35px; border-radius:50%; border:1px solid #198754;"> {{$healthDay->author_name}}</span>
                    <span class="mx-3 h6 text-primary text-nowrap"><i class="fas fa-calendar"></i> {{$healthDay->date}}</span>
                    <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-tag"></i> {{optional($healthDay->category)->name}}</span>
                    <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                </div>
            </div>
            <div class="mt-3">                
                <div class="mt-3">
                    <div class="blog-full-description">{!! $healthDay->description !!}</div>

                    @if($healthDay->slogan_list->count())
                        <div class="mt-4 px-md-5">
                            <h5>Themes of {{$healthDay->title}}</h5>
                            @foreach ($healthDay->slogan_list as $sl)
                                <div class="my-2 d-flex align-items-center">
                                    <div class="me-3">{{$sl->year}}</div>
                                    <div class="text-justify">{{$sl->title}}</div>
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
        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Health Day Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>
 
@endsection
