@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($vaccancy->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/careers">Careers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vaccancy Post</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="about-page my-4">
        <div class="container card p-4">
            <div class="h3 text-primary text-center mb-4">{{$vaccancy->title}}</div>
            <div class="text-justify mb-2">{!! $vaccancy->description !!}</div>
            <div><a class="btn btn-outline-info" href="/careers/apply/{{$vaccancy->slug}}">Apply Now</a></div>
        </div>
    </section>
@endsection