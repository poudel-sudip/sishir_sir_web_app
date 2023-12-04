@extends('front.layouts.app')

@section('page_title', ucwords($book->title))
@section('og-title', ucwords($book->title))
@section('og-url', url('/qr-book-scans/'.$book->slug))
@section('og-description', strip_tags($book->description) ? strip_tags(str_replace('<', '  <', $book->description)) : $book->title )
@if($book->thumbnail)
@section('og-image', asset('/storage/'.$book->thumbnail))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($book->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        <li class="breadcrumb-item">QR Book Scan</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucwords($book->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container ebook-section" style="background:transparent">            
            <div class="ebook-page-details">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 book-details">
                                <h2 class="text-center">{{strtoupper($book->title)}}</h2>
                                <div class="text-center">
                                    <img src="/storage/{{$book->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid">                                
                                </div>     
                                <hr>
                                {{-- <h6 class="text-end">
                                    <span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span>
                                    <span class="mx-2"><i class="fa fa-share"></i> {{$counterData->page_share_count}}</span>
                                </h6> --}}
                                <h6>
                                    Publisher: <strong class="text-primary"> {{ucwords($book->publisher ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Category: <strong class="text-primary"> {{ucwords($book->category ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Author(s): <strong class="text-primary"> {{ucwords($book->author ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Edition: <strong class="text-primary"> {{ucwords($book->edition ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    ISBN: <strong class="text-primary"> {{$book->isbn ?? ' '}} </strong>
                                </h6>
                                <h6>
                                    Published On: <strong class="text-primary"> {{ucwords($book->published_year ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Pages: <strong class="text-primary"> {{ucwords($book->pages ?? ' ')}} </strong>
                                </h6>
                                @if($book->discount  > 0)
                                <h6>
                                    Book Price: <strong class="text-primary"> Rs. {{ucwords($book->price)}}/- </strong>
                                </h6>
                                <h6>
                                    Book Discount: <strong class="text-primary">{{ucwords($book->discount)}}% </strong>
                                </h6>
                                @endif
                                <h6>
                                    Final Price: <strong class="text-success"> Rs. {{($book->price - (($book->price*$book->discount)/100))}}/- </strong>
                                </h6>                                
                                {{-- <h6>
                                    Availability: <strong class="text-primary"> {{ucwords($book->availability ?? ' ')}} </strong>
                                </h6> --}}
                               
                                <div class="book-description text-secondary">
                                    {!! $book->description !!}
                                </div>
                                {{-- <div class="row">                                    
                                    <div class="col-md-6 my-2">
                                        <div class="sharethis-inline-share-buttons" onclick="handleShare(event)" ></div>
                                    </div>
                                </div> --}}                           
                            </div>
                            <div class="col-md-6 border border-2 rounded p-3">
                                @if (Session::has('successMessage'))
                                    <div class="form-group row">
                                        <div class="alert alert-success">{!! Session::get('successMessage') !!}</div>
                                    </div>
                                @endif

                                @if($formshow)
                                    <h3 class="text-center">{{strtoupper('Fill your form')}}</h3>
                                    <div class="enroll-form">
                                        <form action="/qr-book-scans/{{$book->id}}/{{$qrbook->id}}" method="post" enctype="multipart/form-data">
                                            
                                            @csrf()

                                            <div class="form-group row">
                                                <label for="full_name" class="col-12 col-form-label text-md-right">{{ __('Full Name') }}</label>
                        
                                                <div class="col-12">
                                                    <input id="full_name"  name="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" placeholder="Enter Your Full Name" value="{{ old('full_name') }}" required>
            
                                                    @error('full_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="email" class="col-12 col-form-label text-md-right">{{ __('Email') }}</label>
                        
                                                <div class="col-12">
                                                    <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror"  placeholder="Enter Your Email" value="{{ old('email') }}" >
            
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="contact" class="col-12 col-form-label text-md-right">{{ __('Contact Number') }}</label>
                        
                                                <div class="col-12">
                                                    <input id="contact" name="contact" type="text" class="form-control @error('contact') is-invalid @enderror"  placeholder="Enter Your Contact Number" value="{{ old('contact') }}" required>
            
                                                    @error('contact')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="provience" class="col-12 col-form-label text-md-right">{{ __('Provience') }}</label>
                        
                                                <div class="col-12">
                                                    <select name="provience" id="provience" class="form-control @error('provience') is-invalid @enderror" onchange="getCities()">
                                                        <option value="">Select your Provience</option>
                                                        @foreach($proviences as $pro)
                                                            <option value="{{$pro->name}}">{{$pro->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('provience')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="district" class="col-12 col-form-label text-md-right">{{ __('District') }}</label>
                        
                                                <div class="col-12">
                                                    <select name="district" id="district" class="form-control @error('district') is-invalid @enderror">
                                                        <option value="">Select an District</option>
                                                    </select>
                                                    @error('course')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row mt-3">
                                                <div class="col-12 text-end">
                                                    <button type="submit" class="btn btn-primary">Submit Your Details</button>
                                                </div>
                                            </div>


                                        </form>
                                    </div>                               
                                @else 
                                    <h3 class="text-center text-primary">This Book Has Been Reserved By {{$qrbook->name}}.</h3>
                                    <div class="mt-3 text-center text-success h5">
                                        Thank You for Joining.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>                    
                </div>      
            </div>     
            

        </div>
    </div>    

    <script>
        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Single Book Details',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>

    <script>
        var proviences = {
            @foreach($proviences as $pro)
            '{{$pro->name}}' : [
                @foreach($pro->cities as $city)
                "{{$city->name}}",
                @endforeach
            ],
            @endforeach
        };

        function getCities()
        {
            var provience = $('#provience').find(":selected").val();
            $("#district").html("");
            if(provience)
            {
                var cities = proviences[provience];
                var op='';
                cities.forEach((city) => {
                    op += '<option value="' + city + '">' + city + '</option>';
                });
                // console.log(op);
                $("#district").append(op);
            }
        }
    </script>

@endsection 
