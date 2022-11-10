@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Careers / Vaccancies</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Careers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="about-page my-4">
        <div class="container">
            @forelse($vaccancies as $vaccancy)
            <div class="row">
                <div class="col-sm-3"></div>
                <a class="col-sm-6 card shadow-lg rounded py-3 text-center h4 text-primary" href="/careers/{{$vaccancy->slug}}">{{$vaccancy->title}}</a>
                <div class="col-sm-3"></div>
            </div>
            @empty
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 card shadow-lg rounded py-3 text-center h4 text-secondary">No Vaccancies Are Available Now.</div>
                <div class="col-sm-3"></div>
            </div>
            @endforelse
        </div>
    </section>
@endsection