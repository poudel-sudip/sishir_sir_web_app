@extends('front.layouts.app')

@section('page_title', 'Gallery')
@section('og-title', 'Gallery')
@section('og-url', url('/image-gallery'))

@section('content')
    <div class="container-fluid px-md-5 bg-light">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <div class="text-center">
                    <h3 class="dchl-title fs-3">Image Gallery</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container bg-light">
            <div class="d-flex justify-content-center align-items-center flex-wrap">

                @foreach($images as $row)
                  <div class="m-2 text-center border border-primary rounded p-2" style="max-width: 300px;">
                    <a target="_blank" href="/storage/{{$row->image}}"><img src="/storage/{{$row->image}}" class="img img-fluid" alt="img_error" style="max-height: 200px;"></a>
                    <div class="mt-2 h6 text-wrap">{{$row->caption}}</div>
                    
                  </div>
                @endforeach
            </div>
                
            <div>
                {{$images->onEachSide(1)->links('paginator.bootstrap')}}
            </div>

        </div>
    </div>

@endsection
