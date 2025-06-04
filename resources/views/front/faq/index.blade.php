@extends('front.layouts.app')

@section('page_title', 'FAQ - Frequently Asked Questions')
@section('og-title', 'FAQ - Frequently Asked Questions')
@section('og-url', url('/faqs'))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>FAQ - Frequently Asked Questions</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-md-6 align-self-center">
                    <div class="d-flex align-items-center flex-wrap">
                        <span class="mx-3 h6 text-info text-nowrap"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                        <span class="mx-3 h6 text-danger text-nowrap"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                </div>
            </div>
        </div>

        <div class="">

            <div class="accordion" id="faqAccordion">
                @forelse($faqs as $key=>$faq)
                    <div class="accordion-item border border-primary">
                        <div class="accordion-header text-justify" id="faq-{{ $faq->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false" aria-controls="collapse-{{ $faq->id }}">
                                <strong style="color: #1374ba;">{{ $key + 1 }}. {{ $faq->name }}</strong>
                            </button>
                        </div>
                        <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="faq-{{ $faq->id }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {!! $faq->description !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <h4 class="p-3 text-center ">No FAQs found.</h4>
                @endforelse
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
