@extends('front.layouts.app')

@section('page_title', 'स्थानीय तहको वेवसाईटको विवरण')
@section('og-title', 'स्थानीय तहको वेवसाईटको विवरण')
@section('og-url', url('/palika-bibaran'))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>स्थानीय तहको वेवसाईटको विवरण</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Palika Bibaran</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container " style="background:#1375b9;">
            <div class="text-justify">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="//sthaniya.gov.np/gis/website/" 
                        id="myIframe"
                        frameborder="0" 
                        style="width: 100% !important;"
                        class="embed-responsive embed-responsive-16by9"
                        height="1150"
                        allowfullscreen>
                    </iframe>
                </div>             
                
            </div>
        </div>
    </div>

    
@endsection
