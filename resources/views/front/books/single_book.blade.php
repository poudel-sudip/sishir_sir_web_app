@extends('front.layouts.app')

@section('page_title', ucwords($book->title))
@section('og-title', ucwords($book->title))
@section('og-url', url('/books/'.$book->slug))
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
                        @if($book->publisher)
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$book->publisher->slug}}">{{ucwords($book->publisher->name)}}</a></li>
                        @endif
                        @if($book->category)
                        <li class="breadcrumb-item"><a href="/book-publishers/{{$book->publisher->slug}}/category/{{$book->category->slug}}">{{ucwords($book->category->name)}}</a></li>
                        @endif
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
                                <h2 class="mt-3 mt-md-0">{{strtoupper($book->title)}}</h2>
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
                                    <span class="mx-2"><i class="fa fa-eye"></i> {{$counterData->page_view_count}}</span>
                                    <span class="mx-2"><i class="fa fa-share"></i> {{$counterData->page_share_count}}</span>
                                </h6>
                                <h6>
                                    Publisher: <strong class="text-primary"> {{ucwords($book->publisher->name ?? ' ')}} </strong>
                                </h6>
                                <h6>
                                    Category: <strong class="text-primary"> {{ucwords($book->category->name ?? ' ')}} </strong>
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
                                <h6>
                                    Availability: <strong class="text-primary"> {{ucwords($book->availability ?? ' ')}} </strong>
                                </h6>
                               
                                <div class="book-description text-secondary">
                                    {!! $book->description !!}
                                </div>
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        @if(trim($book->purchase_link))
                                        <a href="{{$book->purchase_link}}" target="_blank" class="btn btn-primary">Purchase Online</a>
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
                                                <h4 class="reviewr-name">{{ucwords($review->name)}}</h4>
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
                                <form action="/books/{{$book->slug}}/review/add" method="post" enctype="multipart/form-data">
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

        </div>
    </div>    

    <script>
        function handleShare(event){
            let pageURL = getPageURLWithoutProtocol();
            const postData = { type: 'share', page: 'Single Book Details',pageurl: pageURL };
            postDataWithFetch('/page-counter-increment', postData);
        }
    </script>
@endsection 
