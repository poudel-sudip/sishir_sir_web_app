@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$exam->title}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/public-exams">Exam Hall</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$exam->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page mb-5">
        <div class="container">
            <div class="card p-3">
                <div class="card-title">
                    <div class="h3 text-center">{{$exam->title}}</div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="image image-fluid img img-fluid">
                            <img src="/storage/{{$exam->image}}" alt="">
                        </div> 
                        <div class="text-justify mt-2">
                            {!! $exam->description !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="h5 my-1">Exam Price: {{$exam->price}} </div>
                        <div class="h5 my-1">Discounted Price: {{$exam->price - $exam->discount}} </div>
                        <div class="h5 my-1">No of Sets: {{$exam->category_exams->count()}} </div>
                        <div>
                            <a href="/student/exam-hall/enroll" class="btn booking-btn">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
