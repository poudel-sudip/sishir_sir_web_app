@extends('front.layouts.app')
@section('page_title', 'Available Online Courses')
@section('og-title', 'Available Online Courses')
@section('og-url', url('/courses'))

@section('content')
    <style>
        .single-blog p, .single-blog .blog-description span {
        overflow: visible !important;
        text-overflow: unset !important;
        -webkit-line-clamp: unset !important;
    }
    </style>   

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3">Available Online Courses </h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Courses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-page">
        <div class="container-fluid px-md-5">
            <div class="row course-details">
                <div class="col-md-3">
                    <div class="side-navbar border border-2 border-primary">
                        <h5><a class="d-block active" href="{{ url('/courses') }}">All Courses</a></h5>
                        <ul class="course-nav" style="height:auto; min-height: 370px; ">
                            @foreach($courses as $cat)
                                <li class=""><a class="d-block" href="/courses/category/{{$cat->id}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                   
                </div>
                <div class="col-md-9">
                    <div class="blog-container">
                        <div class="row">
                            @forelse($batches as $row)
                            <div class="col-md-4 my-3">
                                <a href="/courses/details/{{$row->id}}">
                                    <div class="single-blog pt-3 border border-primary border-2">
                                        <div class="blog-image text-center">
                                            <img src="/storage/{{$row->image}}">
                                        </div>
                                        <div class="blog-details">
                                            <h4 class="text-center"><a href="/courses/details/{{$row->id}}">{{$row->name}}</a></h4>
                                            <div class="text-center text-danger" style="margin-top: -0.5rem">(Duration: <span class="text-primary">{{ $row->duration }}</span>)</div>
                                            <div class="mx-2">Price : @if($row->discount > 0) <s class="text-danger">Rs. {{ $row->fee }}</s> @endif <strong class="text-success"> Rs. {{ ($row->final_price) }}</strong></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @empty
                                <div>No Online Course Published</div>
                            @endforelse
                        </div>
                        <div class="">
                            {{$batches->onEachSide(1)->links('paginator.bootstrap')}}
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>

@endsection