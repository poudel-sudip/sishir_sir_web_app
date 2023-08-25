@extends('front.layouts.app')
@section('page_title', 'Library')
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
                <h2>Library</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Library</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-container mt-5">
            <div class="row">
                @forelse($library_categories as $cat)
                <div class="col-md-3 mb-3">
                    <div class="single-blog text-center py-3 library-item border border-primary">
                        <div class="">
                            <a href="/library/{{$cat->slug}}"><i class="h1 fa fa-folder"></i></a>
                        </div>
                        <h5><a href="/library/{{$cat->slug}}">{{$cat->name}}</a></h5>
                    </div>
                </div>
                @empty
              
                    <div>No Library Published</div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
