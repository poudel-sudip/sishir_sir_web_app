@extends('front.layouts.app')
@section('title')
  {{ucwords($batch->name)}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$batch->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/courses/{{$batch->course->slug}}">{{$batch->course->name}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$batch->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="course-decs row">
                        <div class="col-md-4 align-self-center">
                            <img src="/storage/{{$batch->course->image}}" alt="">
                        </div>
                        <div class="col-md-8">
                            <h4>Batch Description</h4>
                            <p>{!! $batch->description !!}</p>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-sm-3 col-6 mb-2">
                                <h5>Batch Status</h5>
                                <p>{{$batch->status}}</p>
                            </div>
                            <div class="col-sm-3 col-6 mb-2">
                                <h5>Course Price</h5>
                                <p><s>Rs. {{$batch->fee}}</s></p>
                                <p class="text-success">Rs. {{$batch->fee-$batch->discount}}</p>
                            </div>
                            <div class="col-sm-3 col-6 mb-2">
                                <h5>Duration</h5>
                                <p>{{$batch->duration.' '.$batch->durationType}}</p>
                            </div>
                            <div class="col-sm-3 col-6 mb-2">
                                <h5>Date</h5>
                                <p>Start On: {{date('Y-m-d',strtotime($batch->startDate))}} </p>
                                <p>End On: {{date('Y-m-d',strtotime($batch->endDate))}} </p>
                            </div>
                            <div class="col-12">
                                <a href="/student/courses/enroll" class="btn booking-btn">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3 booking-box">
                        <div class="card-header bg-transparent">
                            <h4 class="text-center">Batch Tutors</h4>
                        </div>
                        @forelse($batch->tutors as $tutor)
                            <div class="card-body border-bottom row">
                                <div class="col-3 align-self-center">
                                    <img src="/storage/{{$tutor->user->photo}}" class="img-fluid">
                                </div>
                                <div class="col-9" style="line-height: 1">
                                    <h5 class="card-title"><a href="/tutor/{{$tutor->slug}}">{{$tutor->name}}</a> </h5>
                                    <p class="card-title">Qualification: {{$tutor->qualification}}</p>
                                    <p class="card-title">Experience: {{$tutor->experience}}</p>
                                </div>
                            </div>
                        @empty
                            <div class="card-body">No Tutors Found in this Batch.</div>
                        @endforelse
{{--                        <div class="card-footer bg-transparent">--}}
{{--                            <a href="" class="btn booking-btn">Book Now</a>--}}
{{--                        </div>--}}

                      </div>
                </div>
            </div>
        </div>
    </section>
@endsection
