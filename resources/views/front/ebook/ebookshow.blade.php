@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$book->title}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/ebooks">E-Books</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$book->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page mb-5">
        <div class="container">
            <div class="card p-3">
                <div class="card-title">
                    <div class="h3 text-center">{{$book->title}}</div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="image image-fluid img img-fluid">
                            <img src="/storage/{{$book->thumbnail}}" alt="" class="img img-fluid">
                        </div> 
                        <div class="text-justify my-2">
                            {!! $book->description !!}
                        </div>
                        <div class="my-4 text-justify">
                            <div class="h3">Topics</div>
                            <ol class="h6">
                                @foreach($book->chapters as  $chapter)
                                <li> <strong>{{ucwords($chapter->name)}} :-</strong> {{ucwords($chapter->title)}} </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="h5 my-1">Book Price: {{$book->price}} </div>
                        <div class="h5 my-1">Discounted Price: {{$book->price - $book->discount}} </div>
                        <div>
                            <a href="/student/ebook/enroll" class="btn booking-btn">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
