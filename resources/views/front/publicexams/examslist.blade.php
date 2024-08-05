@extends('front.layouts.app')
@section('page_title', 'Exams')
@section('content')
<style>
    #free-exam ul{
        list-style-type: none;
    }
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
    <div class="container-fluid px-md-5">
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
        <div class="container-fluid px-md-5">
            <div class="row course-details">
                <div class="col-md-9">
                    <div class="all-course-list">
                        <h3 class="mb-4">Premium Exams</h3>
                        <div class="free-exam-btn"><a href="#free-exam" class="btn btn-success btn-sm"><i class="fas fa-tag"></i> Free Exams</a></div>
                        <div class="blog-container">
                            <div class="row">
                                @forelse($premiumExams as $exam)
                                    <div class="col-md-4 mb-3">
                                        <div class="seller-item border border-primary rounded border-2">
                                            <div class="seller-header text-center">
                                                <a href="/exam-hall/premium/{{$exam->slug}}">
                                                    <img src="/storage/{{$exam->image}}" alt="" onerror="this.src='/images/default-post.png'" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                                                </a>
                                                <h5 class="mt-3"><a href="/exam-hall/premium/{{$exam->slug}}">{{ucwords($exam->title)}}</a></h5>
                                                <h6>{{$exam->category_exams->count()}} Sets </h6>

                                            </div>
                                        </div>
                                    </div>
                                @empty                  
                                    <div>No Exam Published</div>
                                @endforelse
                            </div>
                            <div class="">
                                {{$premiumExams->onEachSide(1)->links('paginator.bootstrap')}}
                            </div>
                        </div>                        
                    </div>
                </div>
                
                <div class="col-md-3" id="free-exam">
                    <div class="side-navbar border border-2 border-primary">
                        <h5 class="text-center text-light">Free Exams</h5>
                        <ul class="course-nav" style="height:auto; min-height: 370px; ">
                            @foreach($exams as $row)
                                <li>
                                    <a href="/public-exams/{{$row->slug}}">
                                        <i class="fas fa-star pr-2 text-light"></i>
                                        {{$row->name}}
                                        ({{ $row->exam ? ($row->exam->questions ? $row->exam->questions->count() : '-') : '-' }} Questions)
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- <div class="">
                        <h5 class="text-center"><u>Free Exams</u></h5>
                        <ul class="course-nav">
                            @foreach($exams as $exam)
                                <li><a href="/public-exams/{{$exam->slug}}"><i class="fas fa-star pr-2 text-success"></i> {{$exam->name}} ({{ $exam->exam ? ($exam->exam->questions ? $exam->exam->questions->count() : '-') : '-' }} Questions)</a></li>
                            @endforeach
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

@endsection