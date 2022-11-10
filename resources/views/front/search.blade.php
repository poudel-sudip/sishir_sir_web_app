@extends('front.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
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

    <div class="container">
        <div class="search-area-container">
            <div class="row">
                <div class="col md-12">
                    <h4>Search Results for : {{$query ?? ''}}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6 single-search-area">  
                    <div class="my-2">
                        Categories: {{$categories->count()}} <br>
                        @foreach($categories as $cat)
                            <li><a href="/category/{{$cat->slug}}">{{$cat->name}}</a></li>
                        @endforeach
                    </div>
                </div>
    
                <div class="col-6 single-search-area">
                    Courses : {{$courses->count()}} <br>
                    @foreach($courses as $cat)
                        <li><a href="/courses/{{$cat->slug}}">{{$cat->name}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    Batches : {{$batches->count()}} <br>
                    @foreach($batches as $cat)
                        <li><a href="/courses/{{$cat->course->slug}}/{{$cat->slug}}">{{$cat->course->name.' '.$cat->name}}</a></li>
                    @endforeach
                </div>

                <div class="col-6 single-search-area">
                    Tutors : {{$tutors->count()}} <br>
                    @foreach($tutors as $cat)
                        <li><a href="/tutor/{{$cat->slug}}">{{$cat->name}}</a></li>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

@endsection
