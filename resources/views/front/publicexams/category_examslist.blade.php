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
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Exam Hall</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
  
    <section class="course-page">
        <div class="container-fluid px-md-5">
            <div class="row course-details">

                @if($exam_categories->count() || $free_exams->count())
                <div class="col-md-3" >

                    @if($exam_categories->count())
                    <div class="side-navbar border border-2 border-primary">
                        <h5 class="text-center text-light"> <a href="/public-exams" class="d-block">All Groups</a> </h5>
                        <ul class="course-nav" style="height:auto; min-height: 370px; ">
                            @foreach($exam_categories as $row)
                                <li>
                                    <a href="/exam-hall/category/{{$row->id}}" class="d-block">
                                        <i class="fas fa-star pr-2 text-light"></i>
                                        {{$row->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($free_exams->count())
                    <div class="mt-4" id="free-exam">
                        <div class="side-navbar border border-2 border-primary">
                            <h5 class="text-center text-light">Free Exams</h5>
                            <ul class="course-nav" style="height:auto; min-height: 370px; ">
                                @foreach($free_exams as $row)
                                    <li>
                                        <a href="/public-exams/{{$row->id}}" class="d-block">
                                            <i class="fas fa-star pr-2 text-light"></i>
                                            {{$row->name}}
                                            ({{ $row->exam ? ($row->exam->questions ? $row->exam->questions->count() : '-') : '-' }} Questions)
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    
                </div>
                @endif

                <div class="@if($exam_categories->count() || $free_exams->count()) col-md-9 @else col-md-12 @endif">
                    <div class="all-course-list">
                        <h2 class="my-4 text-center" style="color: #0C2B64;"><u>{{($exam_group->name)}} Premium Exams</u></h2>
                        {{-- <div class="free-exam-btn"><a href="#free-exam" class="btn btn-success btn-sm"><i class="fas fa-tag"></i> Free Exams</a></div> --}}
                        <div class="blog-container">
                            <div class="row">
                                @forelse($premium_exams as $exam)
                                    <div class="col-md-4 mb-3">
                                        <div class="seller-item border border-primary rounded border-2">
                                            <div class="seller-header text-center">
                                                <a href="/exam-hall/premium/{{$exam->id}}">
                                                    <img src="/storage/{{$exam->image}}" alt="" onerror="this.src='/images/default-post.png'" style="max-height:200px; width:auto;" class="img img-fluid" draggable="false">
                                                </a>
                                                <h5 class="mt-3"><a href="/exam-hall/premium/{{$exam->id}}">{{($exam->title)}}</a></h5>
                                                <h6>{{$exam->category_exams->count()}} Sets </h6>

                                            </div>
                                        </div>
                                    </div>
                                @empty                  
                                    <div>No Exam Published in Given Group</div>
                                @endforelse
                            </div>
                            <div class="">
                                {{$premium_exams->onEachSide(1)->links('paginator.bootstrap')}}
                            </div>
                        </div>                        
                    </div>
                </div>
                
                {{-- <div class="col-md-3" id="free-exam">
                    <div class="side-navbar border border-2 border-primary">
                        <h5 class="text-center text-light">Free Exams</h5>
                        <ul class="course-nav" style="height:auto; min-height: 370px; ">
                            @foreach($exams as $row)
                                <li>
                                    <a href="/public-exams/{{$row->id}}">
                                        <i class="fas fa-star pr-2 text-light"></i>
                                        {{$row->name}}
                                        ({{ $row->exam ? ($row->exam->questions ? $row->exam->questions->count() : '-') : '-' }} Questions)
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>                  
                </div> --}}

            </div>
        </div>
    </section>

@endsection