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
        <div class="">

            <div class="accordion" id="faqAccordion">
                @forelse($faqs as $faq)
                    <div class="accordion-item border border-primary">
                        <div class="accordion-header" id="faq-{{ $faq->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false" aria-controls="collapse-{{ $faq->id }}">
                                <strong style="color: #1374ba;">{{ $faq->name }}</strong>
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

@endsection
