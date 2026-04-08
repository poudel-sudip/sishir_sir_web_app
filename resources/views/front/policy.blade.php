@extends('front.layouts.app')

@section('page_title', 'Policy')
@section('og-title', 'Policy')
@section('og-url', url('/web-policy'))

@section('content')
    <div class="container-fluid px-md-5 bg-light">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3">Web Policy</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Policy</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container personal-details border border-primary rounded">
            <div class="text-justify">

                {!! $page->description !!}

                {{-- <div class="my-4 text-justify">
                    This website is designed, developed and maintained by <strong>Shisir Adhikari</strong>. The content of this website is for general information purposes only. While we endeavor to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the website or the information, products, services, or related graphics contained on the website for any purpose.

                {{-- <div class="my-4 text-justify">
                    Though all efforts have been made to ensure the accuracy of the content on this website, the same should not be construed as a statement of law or used for any legal purposes. Users are advised to verify/check any information, and to obtain any appropriate professional advice before acting on the information provided on this website.
                </div>
                <div class="my-4 text-justify">
                    Every effort is made to keep the website up and running smoothly. However, <strong>shisiradhikari.com.np</strong> takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.
                    
                </div> --}}
                                
            </div>
        </div>
    </div>

@endsection
