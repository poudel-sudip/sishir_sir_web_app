@extends('front.layouts.app')
@section('page_title', ($batch->name))

@section('og-title', ($batch->name))
@section('og-url', url('courses/details/'.$batch->id))
@if($batch->image)
@section('og-image', asset('/storage/'.$batch->image))
@endif
@section('og-description',  strip_tags($batch->description) ? trim(strip_tags(str_replace('<', '  <', $batch->description))) : $batch->name )


@section('content')
<style>
    .tab-outline-primary{
        border: 2px solid #0C2B64 !important;
        border-radius: 5px;
        color: #0C2B64 !important;
    }
    .tab-outline-primary.active{
        color: #ffffff !important;
        background: #0C2B64 !important;
    }
</style>
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                {{-- <div class="text-center">
                    <h3 class="dchl-title fs-3">{{ $batch->name}} </h3>
                </div> --}}
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/courses">Online Courses</a></li>
                        <li class="breadcrumb-item"><a href="/courses/category/{{$batch->course->id ?? ''}}">{{$batch->course->name ?? ''}}</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">{{$batch->name}}</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page mb-5">
        <div class="container-fluid px-md-5">
            <div class="card p-3 border-success">
                <div class="text-center card-title">
                    <h3 class="dchl-title fs-3">{{ $batch->name}} </h3>
                </div>
                <div class="row">
                    <div class="col-md-8 seller-item  ">
                        <div class="d-inline-block seller-header p-4 border rounded border-2 border-primary">
                            <img src="/storage/{{$batch->image}}" onerror="this.src='/images/default-post.png'" class="img img-fluid" style="max-height:200px; width:auto;">
                        </div> 
                        <div class="">
                            @if($batch->bookings()->count()>=1)
                            <div class="text- text-danger">{{$batch->bookings()->count()}} Users Already Enrolled This Online Course.</div>
                            @endif
                        </div>                       
                    </div>

                    <div class="col-md-4">
                        <div class="h5 my-1 text-end"> 
                            <span class="mx-2 text-nowrap text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '0'}}</span> 
                            <span class="mx-2 text-nowrap text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                        </div>
                        <div style="font-size:16px !important; font-weight:bold;">
                            <div class="my-1"><span class="text-primary">Price:</span> @if($batch->discount >0)  <s class="text-danger mx-2"> Rs. {{$batch->fee}} </s> @endif <span class="text-success mx-2"> Rs. {{$batch->final_price}} </span> </div>
                            <div class="my-1"><span class="text-primary">Notes:</span> <span class="text-success"> {{ $batch->file_count}} </span></div>
                            <div class="my-1"><span class="text-primary">Videos:</span> <span class="text-success"> {{($batch->video_count)}} </span></div>
                            <div class="my-1"><span class="text-primary">Duration:</span> <span class="text-success"> {{($batch->duration)}} </span></div>
                            {{-- <div class="my-1"><span class="text-primary">Validity:</span><span class="text-success"> 1 Year From The Date of Purchase </span></div> --}}
                            <div class="my-1"><span class="text-danger">* Bookings Are Non-Refundable</span> </div>
                            
                        </div>
                        
                        <div>
                            <form action="/student/online-course-bookings" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="batch_id" value="{{$batch->id}}" class="@error('batch_id') is-invalid @enderror">
                                @error('batch_id')
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

                            {{-- <a href="/student/online-course-bookings/create" class="btn booking-btn">Book Now</a> --}}
                        
                        </div>

                        <div class="mt-1">
                            <a class="btn btn-danger d-block" href="//www.youtube.com/watch?v=5Uo_lHUtoHs" target="_blank">Watch Video To Learn About Booking Process <i class="fa fa-video"></i> </a>
                        </div>
                        
                    </div>
                    <div class="col-12">
                        <div class="d-block text-justify mt-2" >
                            {!! $batch->description !!}
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="tab_buttons">
                            <div class="nav nav-tabs justify-content-start align-items-center gap-1" id="nav-course-tab" role="tablist">
                                <button class="nav-link tab-outline-primary active " data-bs-toggle="tab" type="button" role="tab" aria-selected="true" data-bs-target="#nav-batch-overview"  aria-controls="nav-batch-overview" >Overview</button>
                                <button class="nav-link  tab-outline-primary " data-bs-toggle="tab" type="button" role="tab" aria-selected="false" data-bs-target="#nav-batch-curriculum"  aria-controls="nav-batch-curriculum" >Curriculum</button>
                            </div>
                        </div> 

                        <div class="tab-content p-3  border border-success rounded  " >
                            <div class="tab-pane fade active show" id="nav-batch-overview" role="tabpanel" aria-labelledby="nav-batch-overview-tab" >
                                <div class="text-justify">
                                    {!! optional($batch->course)->detail !!}
                                </div>                                       
                            </div>
        
                            <div class="tab-pane fade" id="nav-batch-curriculum" role="tabpanel" aria-labelledby="nav-batch-curriculum-tab" >
                                <div class="h6">
                                    @foreach ($batch->curriculum_list as $row)
                                        <div class="{{$row->is_heading == 0 ? 'ms-3': ''}} "> 
                                            {{$row->title}}
                                        </div>
                                    @endforeach  
                                </div>                      
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function handleShare(event)
        {
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Course Detail Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>

@endsection
