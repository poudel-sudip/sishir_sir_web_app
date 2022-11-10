@extends('front.layouts.app')

@section('content')
<style>
    @media (min-width:768px){
        .free-exam-btn{
            display: none
        }
    }
    @media (max-width: 767px){
        .all-course-list{
            position: relative;
        }
        .free-exam-btn{
            display: block;
            position: absolute;
            top: 0;
            right: 0;
        }
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>Exam Hall</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Exam Hall</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
  
    <section class="course-page">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="all-course-list">
                        <h3 class="mb-4">Premium Exams</h3>
                        <div class="free-exam-btn"><a href="#free-exam" class="btn btn-success btn-sm"><i class="fas fa-tag"></i> Free Exams</a></div>
                        <div class="row">
                            @foreach($premiumExams as $exam)
                                <div class="col-md-4 col-6">
                                    <div class="card-course">
                                        <div class="header">
                                            <a href="/exam-hall/premium/{{$exam->slug}}" class="post-thumb">
                                                <img src="/storage/{{$exam->image}}" alt="">
                                            </a>
                                        </div>
                                        <div class="body">
                                            <h4><a href="/exam-hall/premium/{{$exam->slug}}">{{$exam->title}}</a></h4>
                                            <h6>{{$exam->category_exams->count()}} Sets </h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
    
                <div class="col-md-3" id="free-exam">
                    <div class="side-navbar">
                        <h5 class="text-center">Free Exams</h5>
                        <ul class="course-nav">
                            @foreach($exams as $exam)
                                <li><a href="/public-exams/{{$exam->slug}}"> {{$exam->name}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <div class="container">
        <div class="public-exam-section">
            <h4 class="text-center">Free Exams</h4>
            <div class="row">
                @foreach($exams as $exam)
                <div class="col-md-6">
                    <div class="public-result-list"><span class="icon-point-right text-primary"></span> <a href="/public-exams/{{$exam->slug}}"> {{$exam->name}} </a></div>
                </div>
                @endforeach
            </div>
        </div>
    </div> --}}

@endsection