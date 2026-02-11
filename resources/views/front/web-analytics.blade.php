@extends('front.layouts.app')

@section('page_title', 'Web Analytics')
@section('og-title', 'Web Analytics')
@section('og-url', url('/web-analytics'))

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Web Analytics</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container ">
            <div class="row">
                <div class="col-md-9 mb-3">
                    <div class="card border-success">
                        <div class="card-body">
                            <h5 class="">Last 10 Days Web Visits </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success" style="background: #1375b9; color:#ffffff;">
                        <div class="card-body visitor-trackers">
                            <h5 class="">Total Web Counter </h5>
                            <div class="">
                                <div><span>Total Blogs: </span><strong class="text-warning"> {{$web_counter->blog ?? '0'}} </strong></div>
                                <div><span>Total Books: </span><strong class="text-warning"> {{$web_counter->book ?? '0'}} </strong></div>
                                <div><span>Total Book Editions: </span><strong class="text-warning"> {{$web_counter->book_edition ?? '0'}} </strong></div>
                                <div><span>Total Exams: </span><strong class="text-warning"> {{$web_counter->exam ?? '0'}} </strong></div>
                                <div><span>Total MCQs: </span><strong class="text-warning"> {{$web_counter->mcq ?? '0'}} </strong></div>
                                <div><span>Total PDF Bank: </span><strong class="text-warning"> {{$web_counter->pdf_bank ?? '0'}} </strong></div>
                                <div><span>Total PDF: </span><strong class="text-warning"> {{$web_counter->pdf ?? '0'}} </strong></div>
                                <div><span>Total Vacancies: </span><strong class="text-warning"> {{$web_counter->vaccancy ?? '0'}} </strong></div>
                                <div><span>Total Downloads: </span><strong class="text-warning"> {{$web_counter->download ?? '0'}} </strong></div>
                                <div><span>Website Visit Counter: </span><strong class="text-warning"> {{$web_counter->website ?? '0'}} </strong></div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection
