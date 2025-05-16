@extends('front.layouts.app')
{{-- @section('page_title', 'Search: '.($query ?? '')) --}}
@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{($query ?? '')}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Search</li>
                        <li class="breadcrumb-item active" aria-current="page">{{$query ?? ''}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-md-5">
        <div class="search-area-container" style="height: auto !important;">
            <div class="row">
                <div class="col md-12">
                    <h4>Search Results for : {{$query ?? ''}}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6 single-search-area">  
                    <h5>Posts: {{count($menu_posts) >= 20 ? count($menu_posts).'+' : count($menu_posts)}}</h5> 
                    @foreach($menu_posts as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>
    
                <div class="col-6 single-search-area">
                    <h5> Books: {{count($books) >= 20 ? count($books).'+' : count($books)}} </h5>
                    @foreach($books as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    <h5> Library Materials: {{count($library_materials) >= 20 ? count($library_materials).'+' : count($library_materials)}} </h5>
                    @foreach($library_materials as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    <h5> Premium Exams: {{count($premium_exams) >= 20 ? count($premium_exams).'+' : count($premium_exams)}} </h5>
                    @foreach($premium_exams as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    <h5> Blogs: {{count($blogs) >= 20 ? count($blogs).'+' : count($blogs)}} </h5>
                    @foreach($blogs as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>               

                <div class="col-6 single-search-area">
                    <h5> PDF Banks: {{count($pdf_banks) >= 20 ? count($pdf_banks).'+' : count($pdf_banks)}} </h5>
                    @foreach($pdf_banks as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    <h5> Vaccancies: {{count($vaccancies) >= 20 ? count($vaccancies).'+' : count($vaccancies)}} </h5>
                    @foreach($vaccancies as $post)
                        <li><a href="{{$post['link']}}">{{$post['title']}}</a></li>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

@endsection
