@extends('front.layouts.app')

@section('page_title', $faq->name)
@section('og-title', $faq->name)
@section('og-url', url('/faqs/'.$faq->id))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                {{-- <h2>{{$faq->name}}</h2> --}}
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/faqs') }}">FAQs</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{$faq->name}}</li> --}}
                    </ol>
                </div>
            </div>
        </div>
        <div class="">

            <div class="border border-primary rounded p-3">
                <div class="text-center">
                    <h3 class="dchl-title fs-3"> {{$faq->name}} </h3>
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <span class="mx-3 h6 text-primary text-nowrap"><i class="fa fa-pen"></i> {{$faq->created_at}}</span>
                    <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                    <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                </div>
                <div class="mt-3">
                    {!! $faq->description !!}
                </div>
                <div class="mt-4 offset-md-6 ">
                    <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                </div>
            </div>
                        
        </div>
    </div>

    <script>
        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'FAQ Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>

@endsection
