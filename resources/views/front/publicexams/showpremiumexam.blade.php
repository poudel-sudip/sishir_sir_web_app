@extends('front.layouts.app')
@section('page_title', ucwords($exam->title))

@section('og-title', ucwords($exam->title))
@section('og-url', url('exam-hall/premium/'.$exam->slug))
@if($exam->image)
@section('og-image', asset('/storage/'.$exam->image))
@endif
@section('og-description', strip_tags(str_replace('<', '  <', $exam->description)))


@section('content')
    <div class="container-fluid px-md-5">
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
        <div class="container-fluid px-md-5">
            <div class="card p-3 border-success">
                <div class="card-title">
                    <div class="h3 text-center">{{$exam->title}}</div>
                </div>
                <div class="row">
                    <div class="col-md-8 seller-item  ">
                        <div class="d-inline-block seller-header p-4 border rounded border-2 border-primary">
                            <img src="/storage/{{$exam->image}}" onerror="this.src='/images/default-post.png'" class="img img-fluid" style="max-height:200px; width:auto;">
                        </div> 
                        <div class="d-block text-justify mt-2">
                            {!! $exam->description !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="h5 my-1 text-end"> <span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span> </div>
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
