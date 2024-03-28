@extends('front.layouts.app')

@section('page_title', 'Policy')
@section('og-title', 'Policy')
@section('og-url', url('/web-policy'))

@section('content')
    <div class="container-fluid px-md-5 bg-light">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Web Policy</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Policy</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container bg-light">
            <div class="text-justify">
                <div class="my-4 text-justify">
                    Though all efforts have been made to ensure the accuracy of the content on this website, the same should not be construed as a statement of law or used for any legal purposes. Users are advised to verify/check any information, and to obtain any appropriate professional advice before acting on the information provided on this website.
                </div>
                <div class="my-4 text-justify">
                    Every effort is made to keep the website up and running smoothly. However, <strong>shisiradhikari.com</strong> takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.
                    
                </div>
                                
            </div>
        </div>
    </div>

@endsection
