@extends('front.layouts.app')
@section('page_title', 'Library: '.ucwords($library_category->name))
@section('content')
<style>
    .single-blog p, .single-blog .blog-description span {
    overflow: visible !important;
    text-overflow: unset !important;
    -webkit-line-clamp: unset !important;
}
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($library_category->name)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ ('/library') }}">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($library_category->name)}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-container mt-5">
            <div class="row">
                @forelse($library_materials as $material)
                <div class="col-md-4 mb-2">
                    <div class="single-blog text-center py-3">
                        <div class="">
                            <a href="/library/{{$library_category->slug}}/{{$material->slug}}"><img src="/storage/{{$material->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid" style="max-height:150px"></a>
                        </div>
                        <div class="blog-details">
                            <h4><a href="/library/{{$library_category->slug}}/{{$material->slug}}">{{ucwords($material->name)}}</a></h4>
                        </div>
                    </div>
                </div>
                @empty
              
                    <div>No Materials Published</div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
