@extends('front.layouts.app')

@section('page_title', 'Health INGOs in Nepal')
@section('og-title', 'Health INGOs in Nepal')
@section('og-url', url('/health-ingos'))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Digital Mapping of Health INGOs in Nepal</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Health INGOS</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container bg-white">
            <div class="text-justify">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="//ain.k8s.yipl.com.np/" 
                        id="myIframe"
                        frameborder="0" 
                        style="width: 100% !important;"
                        class="embed-responsive embed-responsive-16by9"
                        height="2000"
                        allowfullscreen>
                    </iframe>
                </div>             
                
            </div>
        </div>
    </div>

    
@endsection
