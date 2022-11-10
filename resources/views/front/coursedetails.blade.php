@extends('front.layouts.app')
@section('title')
  Course Details
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$course->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/category/{{$course->category->slug}}">{{$course->category->name}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$course->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="course-details-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="course-decs row">
                        <div class="col-md-4 align-self-center">
                            <img src="/storage/{{$course->image}}" alt="">
                        </div>
                        <div class="col-md-8">
                            <h4>Course Description</h4>
                            <p> {!! $course->description !!} </p>
                        </div>
                    </div>


                </div>
                <div class="col-md-4">
                    <div class="card mb-3 booking-box">
                        <div class="card-header bg-transparent">
                            <h4 class="text-center">Current Batches</h4>
                        </div>
{{--                        <div class="card-body">--}}
{{--                            <p>Online Classses</p>--}}
{{--                            <h5 class="card-title">Rs. 5000.00/-</h5>--}}
{{--                            <p class="card-text">Price: <s>Rs. 6000.00/-</s></p>--}}
{{--                        </div>--}}
{{--                        <div class="card-footer bg-transparent">--}}
{{--                            <a href="" class="btn booking-btn">Book Now</a>--}}
{{--                        </div>--}}
                        
                        @forelse($course->batches as $batch)
                        @if ($batch->status == 'Active'| $batch->status == 'Running')
                        <div class="card-body border-bottom row">
                            <div class="col-1">
                                <span class="icon-point-right text-primary"></span>
                            </div>
                            <div class="col-11" style="line-height: 0.8">
                                <h5 class="card-title" style="display: inline"><a href="/courses/{{$course->slug}}/{{$batch->slug}}" class="card-title">{{$batch->name}}</a></h5><a href="/student/courses/enroll" class="course_book_btn">Book Now</a>
                                <p class="card-title mt-2"><s>Rs. {{$batch->fee}}</s> <b class="text-danger">Rs. {{$batch->fee-$batch->discount}}/-</b></p>
                                <div class="card-footer-details">
                                    <span class="card-date">Duration: {{$batch->duration.' '.$batch->durationType}}</span>
                                    <span class="card-date" style="float: right">Start On: {{date('Y-m-d',strtotime($batch->startDate))}}</span>
                                </div>
                            </div>
                            
                        </div>
                        @endif
                        @empty
                            <div class="card-body">No Current Batches Found.</div>
                        @endforelse
    
                      </div>
                </div>
            </div>
        </div>
        <div class="more-decs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs tab-course-description" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-details-tab" data-bs-toggle="tab" data-bs-target="#nav-details" type="button" role="tab" aria-controls="nav-details" aria-selected="true">Course Details</button>
                              <button class="nav-link" id="nav-features-tab" data-bs-toggle="tab" data-bs-target="#nav-features" type="button" role="tab" aria-controls="nav-features" aria-selected="false">What We Offer ?</button>
                              <button class="nav-link" id="nav-unique-features-tab" data-bs-toggle="tab" data-bs-target="#nav-unique-features" type="button" role="tab" aria-controls="nav-unique-features" aria-selected="false">Unique Features</button>
                            </div>
                          </nav>
                          <div class="tab-content mt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
                               {!! $course->detail !!}
                            </div>
                            <div class="tab-pane fade" id="nav-features" role="tabpanel" aria-labelledby="nav-features-tab">
                                <div class="course-all-feature">
                                    @forelse($course->normalFeatures as $feature)
                                        <div class="feature-detail-card">
                                            <div class="nav-feature-icon">
                                                <img src="{{ asset('/storage').'/'.$feature->image }}" alt="" width="30">
                                                <h5>{{$feature->title}}</h5>
                                            </div>
                                            <div>{!! $feature->description !!}</div>
                                        </div>
                                    @empty
                                        <div> No Features Found.</div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-unique-features" role="tabpanel" aria-labelledby="nav-unique-features-tab">
                                <div class="course-all-feature">
                                    @forelse($course->uniqueFeatures as $feature)
                                        <div class="feature-detail-card">
                                            <div class="nav-feature-icon">
                                                <img src="{{ asset('/storage').'/'.$feature->image }}" alt="" width="30">
                                                <h5>{{$feature->title}}</h5>
                                            </div>
                                            <div>{!! $feature->description !!}</div>
                                        </div>
                                    @empty
                                        <div> No Unique Features Found.</div>
                                    @endforelse
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
