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
                        <div class="mt-2">
                            @if($exam->bookings()->count()>=1)
                            <div class="text- text-danger">{{$exam->bookings()->count()}} Users Already Enrolled This Exam Set.</div>
                            @endif
                        </div> 
                        <div class="d-block text-justify mt-2">
                            {!! $exam->description !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="h5 my-1 text-end"> <span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span> </div>
                        {{-- <div class="h5 my-1">Exam Price: {{$exam->price}} </div> --}}
                        {{-- <div class="h5 my-1">Discounted Price: {{$exam->price - $exam->discount}} </div> --}}
                        <div class="h5 my-1"><span class="text-primary">Price:</span> @if($exam->discount > 0)  <s class="text-danger mx-2"> Rs. {{$exam->price}} </s> @endif <span class="text-success mx-2"> Rs. {{$exam->price - $exam->discount}} </span> </div>
                        <div class="h5 my-1"><span class="text-primary">Total MCQ Sets:</span><span class="text-success"> {{ $exam->mcq_count}} </span></div>
                        <div class="h5 my-1"><span class="text-primary">Available Videos:</span><span class="text-success"> {{ $exam->video_count}} </span></div>
                        <div class="h5 my-1"><span class="text-primary">Available PDF :</span><span class="text-success"> {{ $exam->pdf_count > 0 ? $exam->pdf_count : 1}} </span></div>
                        <div class="h5 my-1"><span class="text-primary">Validity:</span><span class="text-success"> 1 Year From The Date of Purchase </span></div>

                        <div class="h5 my-1"><span class="text-danger">* Bookings Are Non-Refundable</span> </div>
                        
                        <div>
                            <form action="/student/exam-bookings" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="exam_category" value="{{$exam->id}}" class="@error('exam_category') is-invalid @enderror">
                                @error('exam_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <input type="hidden" name="remarks" value="">
                                <button type="submit" class="btn booking-btn">Book Now</button>

                                @if (session('alreadybooked'))
                                    <div class="alert alert-danger">
                                        {{ session('alreadybooked') }}
                                    </div>
                                @endif
                            </form>
                            {{-- <a href="/student/exam-bookings/create" class="btn booking-btn">Book Now</a> --}}
                        </div>

                        <div class="mt-1">
                            <a class="btn btn-danger d-block" href="//www.youtube.com/watch?v=5Uo_lHUtoHs" target="_blank">Watch Video To Learn About Booking Process <i class="fa fa-video"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
