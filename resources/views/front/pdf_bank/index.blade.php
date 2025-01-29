@extends('front.layouts.app')
@section('page_title', $pdf_category->name ?? 'All PDF Banks')
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
                <h2>{{ $pdf_category->name ?? 'All PDF Banks' }} </h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        @if($pdf_category)
                        <li class="breadcrumb-item"><a href="/pdf-banks">All PDF Banks</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pdf_category->name}}</li>
                        @else
                        <li class="breadcrumb-item active" aria-current="page">All PDF Banks</li>
                        @endif
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
                        <h5><a href="{{ url('/pdf-banks') }}">All PDF Banks</a></h5>
                        <ul class="course-nav" style="height:auto; min-height: 370px; ">
                            @foreach($pdf_bank_categories as $cat)
                                <li><a href="/pdf-banks/category/{{$cat->id}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @if($sidebar_ad)
                        <div class="mt-2 text-center">
                            <img src="/storage/{{$sidebar_ad->banner}}" onerror="this.src='/images/ads/default-200X300.png'" alt="" class="img img-fluid" style="max-height: 300px;">
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="blog-container">
                        <div class="row">
                            @forelse($pdf_banks as $row)
                            <div class="col-md-4 my-3">
                                <a href="/pdf-banks/bank/{{$row->id}}">
                                    <div class="single-blog pt-3 border border-primary border-2">
                                        <div class="blog-image text-center">
                                            <img src="/storage/{{$row->thumbnail}}">
                                        </div>
                                        <div class="blog-details">
                                            <h4 class="text-center"><a href="/pdf-banks/bank/{{$row->id}}">{{$row->title}}</a></h4>
                                            <div class="text-center text-danger" style="margin-top: -0.5rem">(PDF Sets: <span class="text-primary">{{ $row->type == 'set' ? $row->pdf_count : '1' }}</span>)</div>
                                            <div class="mx-2">Price : @if($row->discount > 0) <s class="text-danger">Rs. {{ $row->price }}</s> @endif <strong class="text-success"> Rs. {{ ($row->price - $row->discount) }}</strong></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @empty
                                <div>No PDF Banks Published</div>
                            @endforelse
                        </div>
                        <div class="">
                            {{$pdf_banks->onEachSide(1)->links('paginator.bootstrap')}}
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>

@endsection
