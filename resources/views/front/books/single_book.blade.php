@extends('front.layouts.app')

@section('page_title', ($book->title))
@section('og-title', ($book->title))
@section('og-url', url('/books/'.$book->id))
@section('og-description', strip_tags($book->description) ? strip_tags(str_replace('<', '  <', $book->description)) : $book->title )
@if($book->thumbnail)
@section('og-image', asset('/storage/'.$book->thumbnail))
@endif

@section('content')
    <style>
        .book-description img{
            padding: 1rem 2rem !important;
        }
    </style>

    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{($book->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ ('/') }}">Home</a></li>
                        @if($book->publisher)
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$book->publisher->id}}">{{($book->publisher->name)}}</a></li>
                        @endif
                        @if($book->category)
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$book->publisher->id}}/category/{{$book->category->id}}">{{($book->category->name)}}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{($book->title)}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="blogs-details-container ebook-section mt-2" style="background:transparent">            
            <div class="ebook-page-details m-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <div>
                                    <img src="/storage/{{$book->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid">                                
                                </div>
                                @if(($book->reviews()->avg('rating')) > 0)
                                    <div class="mt-4 d-none d-md-block text-md-center">
                                        <h5>
                                            Rating: 
                                            <strong class="text-warning">
                                                @for($i = 0 ; $i < round($book->reviews()->avg('rating')) ; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                <span class="text-primary">({{number_format($book->reviews()->avg('rating'), 2)}}/5.00)</span>
                                            </strong>
                                        </h5>
                                    </div>
                                @endif
                                
                            </div>
                            <div class="col-md-7 book-details">
                                {{-- <div class="addto-ebook-favorite">
                                    <button onclick="" title="Add to favorite"><i class="fas fa-heart"></i></button>
                                </div> --}}
                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-2">
                                    <div class="text-orange fs-5 fw-bold text-nowrap"><i class="fas fa-pen-nib me-1"></i> Available Editions:</div>
                                    <select name="edition" id="edition" class="form-select w-auto">
                                        @foreach($book_editions as $edition)
                                            <option value="{{$edition->id}}" @if($edition->id == $book->id) selected @endif >{{$edition->edition}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <h2 class="mt-3 mt-md-0">{{($book->title)}}</h2>
                                @if(($book->reviews()->avg('rating')) > 0)
                                    <h5 class="text-end d-md-none">
                                        Rating: 
                                        <strong class="text-warning">
                                            @for($i = 0 ; $i < round($book->reviews()->avg('rating')) ; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            <span class="text-primary">({{number_format($book->reviews()->avg('rating'), 2)}}/5.00)</span>
                                        </strong>
                                    </h5>
                                @endif
                                
                                <h6 class="text-end">
                                    <span class="mx-2 text-info"><i class="fa fa-eye"></i> {{$counterData->page_view_count ?? '1'}}</span>
                                    <span class="mx-2 text-danger"><i class="fa fa-share"></i> {{$counterData->page_share_count ?? '0'}}</span>
                                </h6>
                                <h6>
                                    Publisher: <strong class="text-primary"> {{($book->publisher->name ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Category: <strong class="text-primary"> {{($book->category->name ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Author(s): <strong class="text-primary"> {{($book->author ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Edition: <strong class="text-primary"> {{($book->edition ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    ISBN: <strong class="text-primary"> {{$book->isbn ?? ' '}} </strong>
                                </h6>
                                <h6>
                                    Published On: <strong class="text-primary"> {{($book->published_year ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Pages: <strong class="text-primary"> {{($book->pages ?? ' ')}} </strong>
                                </h6>
                                @if($book->discount  > 0)
                                <h6>
                                    Book Price: <strong class="text-primary"> Rs. {{($book->price)}}/- </strong>
                                </h6>
                                <h6>
                                    Book Discount: <strong class="text-primary">{{($book->discount)}}% </strong>
                                </h6>
                                @endif
                                <h6>
                                    Final Price: <strong class="text-success"> Rs. {{($book->price - (($book->price*$book->discount)/100))}}/- </strong>
                                </h6>                                
                                <h6>
                                    Availability: <strong class="text-primary"> {{($book->availability ?? ' ')}} </strong>
                                </h6>                              
                                
                            </div>
                            <div class="col-12 book-details">
                                <div class="book-description text-secondary">
                                    {!! $book->description !!}
                                </div>
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        {{-- @if(trim($book->purchase_link))
                                        <a href="{{$book->purchase_link}}" target="_blank" class="btn btn-primary">Purchase Online</a>
                                        @endif --}}

                                        @if(session('success_message'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('success_message') }}
                                            </div>
                                        @endif

                                        <a href="javascript:void(0)"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookOrderModal">Purchase Online</a>
                                        @if($book->content_pdf)
                                            <div class="_df_button border-danger" id="pdf_book_df" source="/storage/{{$book->content_pdf}}" style="background: #dc143c;"> <i class="fa fa-file-pdf"></i> View PDF</div>

                                            {{-- <a href="javascript:void(0)"  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bookOrderModal"> <i class="fa fa-file-pdf"></i> View PDF</a> --}}
                                        @endif

                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="sharethis-inline-share-buttons" onclick="handleShare(event)" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>      
            </div>     
            
            <div class="ebook-page-details">
                <div class="row">
                    <div class="col-6">
                        <h4>Book Reviews</h4>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            Write a Review
                        </button>
                    </div>
                </div>
                
                <div class="tutor-review-container">                    
                    @if($book_reviews->count())
                        <div class="tutor-rev-whole-container" id="content">
                            @foreach($book_reviews as $review)
                                <div class="t-single-review item">
                                    <div class="row">
                                        <div class="col-md-6 t-review-header">
                                            <div class="pt-2">
                                                <i class="far fa-user reviewer-icon align-baseline"></i>
                                            </div>
                                            <div>
                                                <h4 class="reviewr-name">{{($review->name)}}</h4>
                                                <p>{{date('Y-m-d G:i',strtotime($review->created_at))}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            @for($i=0;$i<intval($review->rating);$i++)
                                                <i class="fas fa-star text-warning"></i>
                                            @endfor
                                        </div>
                                        <div class="col-md-12">
                                            <div class="t-review">
                                                {!! $review->message !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach                                
                        </div>                        
                    @endif                    
                </div>
            </div>

            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h6 class="modal-title" id="reviewModalLabel">Write a Review</h6>
                        </div>
                        <div class="modal-body">
                            <div class="leave-review">
                                <form action="/books/{{$book->id}}/review/add" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="star star-5" value="5" id="star-5" type="radio" name="rating"/>
                                            <label class="star star-5" for="star-5"></label>
                                            <input class="star star-4" value="4" id="star-4" type="radio" name="rating"/>
                                            <label class="star star-4" for="star-4"></label>
                                            <input class="star star-3" value="3" id="star-3" type="radio" name="rating"/>
                                            <label class="star star-3" for="star-3"></label>
                                            <input class="star star-2" value="2" id="star-2" type="radio" name="rating"/>
                                            <label class="star star-2" for="star-2"></label>
                                            <input class="star star-1" value="1" id="star-1" type="radio" name="rating"/>
                                            <label class="star star-1" for="star-1"></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="name" placeholder="Full Name" class="comment-input" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="email" placeholder="email@gmail.com" class="comment-input" required>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="contents" class="comment-input" rows="4" placeholder="write your review"></textarea>
                                        </div>
                                        <div class="col-md-12 mt-3 text-end">
                                            <button type="button" class="review-submit btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <input type="submit" name="submit" value="Post" id="review-post" class="review-submit btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="bookOrderModal" tabindex="-1" aria-labelledby="bookOrderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h6 class="modal-title" id="bookOrderModalLabel">Raise Book Order Request</h6>
                        </div>
                        <div class="modal-body">
                            <div class="leave-review">
                                <form action="/books/{{$book->id}}/physical-order/add" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <input type="text" name="name" placeholder="Full Name" class="comment-input" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <input type="text" name="contact" placeholder="+977 9876543210" class="comment-input" required>
                                        </div>

                                        <div class="col-md-12">
                                            <input type="text" name="location" placeholder="Your Delivery Location" class="comment-input" >
                                        </div>

                                        <div class="col-md-6">
                                            <input type="number" name="quantity" placeholder="Book Order Quantity" class="comment-input"  >
                                        </div>

                                        <div class="col-md-6">
                                            <input type="number" name="unit_price" placeholder="Affordable Book Unit Price" class="comment-input"  >
                                        </div>

                                        <div class="col-md-12">
                                            <textarea name="message" class="comment-input" rows="2" placeholder="write your message"></textarea>
                                        </div>
                                        <div class="col-md-12 mt-3 text-end">
                                            <button type="button" class="order-submit btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <input type="submit" name="submit" value="Post" id="order-post" class="order-submit btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>    

    <link href="{{asset('dflip/css/dflip.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dflip/css/themify-icons.min.css')}}" rel="stylesheet" type="text/css">

    <script src="{{asset('dflip/js/dflip.min.js')}}" type="text/javascript"></script>

    <script>
        var option_pdf_book_df = {
            // height:'100%',
            webgl:true,
            soundEnable: true,
            enableDownload: false,
            transparent: false,
            backgroundColor: "#1375b9",
            scrollWheel: false,
            pageMode: DFLIP.PAGE_MODE.SINGLE,
            singlePageMode: DFLIP.SINGLE_PAGE_MODE.BOOKLET,
            allControls: "startPage,altPrev,pageNumber,altNext,endPage,thumbnail,zoomIn,zoomOut,fullScreen,pageMode",
            moreControls: "",
            hideControls: "share,download",
        };
    </script>


    <script>
        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Single Book Details',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }

        document.getElementById('edition').addEventListener('change', function() {
            var selectedEditionId = this.value;
            window.location.href = '/books/' + selectedEditionId;
        });
    </script>
@endsection 
