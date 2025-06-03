@extends('front.layouts.app')

@section('page_title', $faq->name)
@section('og-title', $faq->name)
@section('og-url', url('/faqs/'.$faq->id))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$faq->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/faqs') }}">FAQs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$faq->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="">

            <div class="border border-primary rounded p-3">
                <div class="h4 text-center">{{$faq->name}}</div>
                <div class="mt-3">
                    {!! $faq->description !!}
            </div>
                        
        </div>
    </div>

@endsection
