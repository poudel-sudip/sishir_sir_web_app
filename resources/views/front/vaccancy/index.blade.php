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
                <h2>All Vaccancies</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Vaccancies</li>
                    </ol>
                </div>
            </div>
        </div>
        
    </div>

    <div class="container-fluid px-md-5">
        <div class="blog-container mt-5">

            @if(session('alert_message'))
                <div class="alert alert-success" role="alert">
                    {{ session('alert_message') }}
                </div>
            @endif

            <div class="text-end">
                <a href="/vaccancies/create" class="btn btn-success">Submit Your New Vacancy <i class="fa fa-paint-brush"></i> </a>
            </div>

            <div class="row">
                @forelse($vaccancies as $vaccancy)
                <div class="col-md-4 mb-2">
                    <div class="single-blog border border-primary rounded">
                        <div class="blog-image">
                            <a href="/vaccancies/{{$vaccancy->slug}}"><img src="/storage/{{$vaccancy->thumbnail}}" class="img img-fluid"></a>
                        </div>
                        <div class="blog-details">
                            <h4 class="text-center"><a href="/vaccancies/{{$vaccancy->slug}}">{{$vaccancy->title}}</a></h4>
                            <div class="blog-footer">
                                <div><i class="fa fa-user text-primary" aria-hidden="true"></i> <span class="text-success">{{$vaccancy->author}}</span></div>
                                <div class="text-end">Posted On: <span class="text-primary"> {{date('Y-m-d',strtotime($vaccancy->created_at))}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>                
                @empty              
                    <div class="text-center">No Vaccancies Published......</div>
                @endforelse
            </div>
            <div class="">
                {{$vaccancies->onEachSide(1)->links('paginator.bootstrap')}}
            </div>
        </div>
    </div>

@endsection
