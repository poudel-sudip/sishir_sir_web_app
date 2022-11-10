@extends('front.layouts.app')
@section('title')
  Course Batches
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Batch Archives</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{$course->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="course-page">
        <div class="container">
            {{-- <div class="row">
                <div class="col-md-12 text-center about-heading">
                  <span class="page-sub-heading">E-TUTORS A GLORIOUS JOURNEY</span>
                  <h2 class="mb-3">"A Journey of thousand miles begins with a single step"</h2>
                </div>
            </div> --}}
            <div class="row courses-details">
                <div class="col-md-3">
                    <div class="side-navbar">
                        <h5>All Categories</h5>
                        <ul class="course-nav">
                          <li><a href="">IT and Engineering</a></li>
                          <li><a href="">Public Service Comission</a></li>
                          <li><a href="">Math and Science</a></li>
                          <li><a href="">Languages</a></li>
                          <li><a href="">IT and Engineering</a></li>
                          <li><a href="">Public Service Comission</a></li>
                          <li><a href="">Math and Science</a></li>
                          <li><a href="">Languages</a></li>
                          <li><a href="">IT and Engineering</a></li>
                          <li><a href="">Public Service Comission</a></li>
                          <li><a href="">Math and Science</a></li>
                          <li><a href="">Languages</a></li>
                        </ul>
                      </div>
                </div>
                <div class="col-md-9">
                    <div class="all-course-list">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-course">
                                    <div class="header">
                                      <a href="{{ url('/course-details') }}" class="post-thumb">
                                        <img src="{{ asset('images/demo.jpg') }}" alt="">
                                      </a>
                                    </div>
                                    <div class="body">
                                      <h5 class="post-title"><a href="">Ban Rakshyak Class</a></h5>
                                      <div class="course-info">
                                        <div>
                                          <span class="course-price">Rs 3999</span>
                                          <span class="course-duration">45 days</span>
                                        </div>
                                        <div class="start-course">Start On:<span>2021-09-20</span></div>
                                      </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-course">
                                    <div class="header">
                                      <a href="" class="post-thumb">
                                        <img src="{{ asset('images/demo.jpg') }}" alt="">
                                      </a>
                                    </div>
                                    <div class="body">
                                      <h5 class="post-title"><a href="">Ban Rakshyak Class</a></h5>
                                      <div class="course-info">
                                        <div>
                                          <span class="course-price">Rs 3999</span>
                                          <span class="course-duration">45 days</span>
                                        </div>
                                        <div class="start-course">Start On:<span>2021-09-20</span></div>
                                      </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-course">
                                    <div class="header">
                                      <a href="{{ url('/course-details') }}" class="post-thumb">
                                        <img src="{{ asset('images/demo.jpg') }}" alt="">
                                      </a>
                                    </div>
                                    <div class="body">
                                      <h5 class="post-title"><a href="">Ban Rakshyak Class</a></h5>
                                      <div class="course-info">
                                        <div>
                                          <span class="course-price">Rs 3999</span>
                                          <span class="course-duration">45 days</span>
                                        </div>
                                        <div class="start-course">Start On:<span>2021-09-20</span></div>
                                      </div>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
