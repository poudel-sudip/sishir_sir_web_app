@extends('front.layouts.app')
@section('page_title', 'Vaccancies')
@section('content')

    <style>
        .hidden{
            display: none
        }
    </style>

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>All Vacancies</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Vacancies</li>
                    </ol>
                </div>
            </div>
        </div>
        
    </div>

    <div class="container-fluid px-md-5">
        <div class="blog-container mt-3">

            @if(session('alert_message'))
                <div class="alert alert-success" role="alert">
                    {{ session('alert_message') }}
                </div>
            @endif

            <div class="text-end mb-2">
                <a href="/vaccancies/create" class="btn btn-success">Submit Your New Vacancy <i class="fa fa-paint-brush"></i> </a>
            </div>
            
            {{-- <div class="my-2">
                <div class="lib-filter-alphabets justify-content-center">
                    <a href="/vaccancies" class="lib-filter-character active" > All </a>
                    @foreach ($tag_categories as $tag)
                        <a href="/vaccancies-tag/{{$tag->id}}" class="lib-filter-character" > {{$tag->name}} </a>
                    @endforeach                    
                </div>                  
            </div> --}}

            <nav class="my-2">
                <div class="d-flex align-items-center justify-content-center footer-imp-link">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper category-swiper nav nav-tabs">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="/vaccancies"> <button class="nav-link border active">All</button> </a>
                            </div>
                            @foreach($tag_categories as $tag)
                                <div class="swiper-slide">
                                    <a href="/vaccancies-tag/{{$tag->id}}"> <button class="nav-link border">{{$tag->name}}</button> </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                </div>
            </nav>

            <div class="row">
                @forelse($vaccancies as $vaccancy)
                <div class="col-md-4 mb-2">
                    <div class="single-blog border border-primary rounded">
                        <div class="blog-image">
                            <a href="/vaccancies/{{$vaccancy->id}}"><img src="/storage/{{$vaccancy->thumbnail}}" class="img img-fluid"></a>
                        </div>
                        <div class="blog-details" style="background: transparent;">
                            <h4 class="text-center"><a href="/vaccancies/{{$vaccancy->id}}" style="color: #1374ba;">{{$vaccancy->title}}</a></h4>
                            <div class="blog-footer">
                                <div><i class="fa fa-user text-danger" aria-hidden="true"></i> <span class="text-danger">{{$vaccancy->author}}</span></div>
                                <div class="text-end">Posted On: <span class="text-primary"> {{$vaccancy->created_at->format('d M, Y')}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>                
                @empty              
                    <div class="text-center">No Vacancies Published......</div>
                @endforelse
            </div>
            <div class="">
                {{$vaccancies->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
        </div>
    </div>

@endsection
