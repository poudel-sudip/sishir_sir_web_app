@extends('front.layouts.app')
@section('page_title', ($pdf_bank->title))

@section('og-title', ($pdf_bank->title))
@section('og-url', url('pdf-banks/bank/'.$pdf_bank->id))
@if($pdf_bank->thumbnail)
@section('og-image', asset('/storage/'.$pdf_bank->thumbnail))
@endif
@section('og-description',  strip_tags($pdf_bank->description) ? trim(strip_tags(str_replace('<', '  <', $pdf_bank->description))) : $pdf_bank->title )


@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$pdf_bank->title}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/pdf-banks">eBooks</a></li>
                        <li class="breadcrumb-item"><a href="/pdf-banks/category/{{$pdf_bank->category->id ?? ''}}">{{$pdf_bank->category->name ?? ''}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pdf_bank->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page mb-5">
        <div class="container-fluid px-md-5">
            <div class="card p-3 border-success">
                <div class="card-title">
                    <div class="h3 text-center" style="color:#0C2B64 !important; letter-spacing: -1px;">{{$pdf_bank->title}}</div>
                </div>
                <div class="row">
                    <div class="col-md-8 seller-item  ">
                        <div class="d-inline-block seller-header p-4 border rounded border-2 border-primary">
                            <img src="/storage/{{$pdf_bank->thumbnail}}" onerror="this.src='/images/default-post.png'" class="img img-fluid" style="max-height:200px; width:auto;">
                        </div> 
                        <div class="">
                            @if($pdf_bank->bookings()->count()>=1)
                            <div class="text- text-danger">{{$pdf_bank->bookings()->count()}} Users Already Enrolled This eBook.</div>
                            @endif
                        </div>                       
                    </div>

                    <div class="col-md-4">
                        <div class="h5 my-1 text-end"> 
                            <span class="mx-2 text-nowrap text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '0'}}</span> 
                            <span class="mx-2 text-nowrap text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                        </div>
                        <div style="font-size:16px !important; font-weight:bold;">
                            <div class="my-1"><span class="text-primary">Author(s):</span> <span class="text-success">{{$pdf_bank->author}}</span> </div>
                            <div class="my-1"><span class="text-primary">Price:</span> @if($pdf_bank->discount >0)  <s class="text-danger mx-2"> Rs. {{$pdf_bank->price}} </s> @endif <span class="text-success mx-2"> Rs. {{$pdf_bank->price - $pdf_bank->discount}} </span> </div>
                            <div class="my-1"><span class="text-primary">No of PDF Sets:</span> <span class="text-success"> {{$pdf_bank->type == 'set' ? $pdf_bank->pdf_count : '1'}} </span></div>
                            <div class="my-1"><span class="text-primary">Paper:</span> <span class="text-success"> {{($pdf_bank->paper)}} </span></div>
                            <div class="my-1"><span class="text-primary">No of Pages:</span><span class="text-success"> {{($pdf_bank->pages)}} </span></div>
                            <div class="my-1"><span class="text-primary">Available Videos:</span><span class="text-success"> {{$pdf_bank->type == 'set' ? $pdf_bank->video_count : (trim($pdf_bank->video_file) ? '1' : '0') }} </span></div>
                            <div class="my-1"><span class="text-primary">Validity:</span><span class="text-success"> 1 Year From The Date of Purchase </span></div>
                            <div class="my-1"><span class="text-danger">* Bookings Are Non-Refundable</span> </div>
                            
                        </div>
                        
                        <div>
                            <form action="/student/pdf-bank-bookings" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="pdf_bank" value="{{$pdf_bank->id}}" class="@error('pdf_bank') is-invalid @enderror">
                                @error('pdf_bank')
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

                            {{-- <a href="/student/pdf-bank-bookings/create" class="btn booking-btn">Book Now</a> --}}
                        
                        </div>

                        <div class="mt-1">
                            <a class="btn btn-danger d-block" href="//www.youtube.com/watch?v=5Uo_lHUtoHs" target="_blank">Watch Video To Learn About Booking Process <i class="fa fa-video"></i> </a>
                        </div>
                        
                    </div>
                    <div class="col-12">
                        <div class="d-block text-justify mt-2" >
                            {!! $pdf_bank->description !!}
                        </div>
                        <div class="row">
                            <div class="col-md-8" style="color:#0C2B64 !important;">
                                @if($pdf_bank->pdf_count)
                                <h5>Available PDF Sets:</h5>
                                <ol>
                                    @foreach($pdf_bank->pdf_sets as $row)
                                    <li>{{$row->title}}</li>
                                    @endforeach
                                </ol>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="sharethis-inline-share-buttons" onclick="handleShare(event)"></div>
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
            const postData = { type: 'share', page: 'PDF Bank Detail Show',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>

@endsection
