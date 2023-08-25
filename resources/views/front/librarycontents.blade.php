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
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{ucwords($library_category->name)}}</li> --}}

                        @if($library_category)
                            @php 
                            $cur = $library_category;
                            $bcm = [];
                            while($cur)
                            {
                            $c = (object)[
                                'name' => $cur->name,
                                'link' => '/library/'.$cur->slug,
                            ];
                            array_push($bcm,$c);
                            $cur = $cur->parent;
                            } 
                            $bcm = array_reverse($bcm);
                            @endphp

                            @foreach($bcm as $b)
                            <li class="breadcrumb-item"><a href="{{$b->link}}">{{ucwords($b->name)}}</a></li>
                            @endforeach

                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-container mt-5">
            <div class="row">
                @foreach($directories as $dir)
                <div class="col-md-3 mb-3">
                    <div class="single-blog text-center py-3 library-item border border-primary">
                        <div class="">
                            <a href="/library/{{$dir->slug}}"><i class="h1 fa fa-folder"></i></a>
                        </div>
                        <h5><a href="/library/{{$dir->slug}}">{{ucwords($dir->name)}}</a></h5>
                    </div>
                </div>
                @endforeach

                @foreach($library_materials as $material)
                <div class="col-md-4 mb-2">
                    <div class="single-blog text-center py-3 border border-primary border-2">
                        <div class="">
                            <a href="/library/{{$library_category->slug}}/{{$material->slug}}"><img src="/storage/{{$material->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid" style="max-height:150px"></a>
                        </div>
                        <div class="blog-details">
                            <h4><a href="/library/{{$library_category->slug}}/{{$material->slug}}">{{ucwords($material->name)}}</a></h4>
                        </div>
                    </div>
                </div>
                @endforeach

                @if(!$directories->count() && !$library_materials->count())
                    <div>No Materials Published</div>
                @endif

            </div>
        </div>
    </div>

@endsection
