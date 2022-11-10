@extends('front.layouts.app')
@section('title')
  Tutor Details
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$tutor->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$tutor->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="course-details-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="course-decs p-4">
                        <div class="row">
                            <div class="col-md-4 align-self-center">
                                <img src="/storage/{{$tutor->user->photo}}" alt="">
                            </div>
                            <div class="col-md-8">
                                <h4>Description</h4>
                                <p>{!! $tutor->description !!}</p>
                            </div>
                            <div class="col-md-12 mt-3 row">
                                <div class="col-sm-4 col-6 mb-2">
                                    <h5>Ratings</h5>
                                    {{-- <p>{{ $tutor->rating }}</p> --}}
                                    <div>
                                        @for ($i=1;$i<=5;$i++)
                                            @if ($i<=$tutor->rating)
                                                <i class="fa fa-star color-review"></i>
                                            @else
                                            <i class="fa fa-star color-empty"></i>
                                            @endif
                                        @endfor
                                        <span class="text-13"> 
                                            @if ($tutor->rating > 0)
                                            ({{round($tutor->rating,2)}} Ratings)
                                            @else
                                            (No Ratings)
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6 mb-2">
                                    <h5>Qualification</h5>
                                    <p>{{$tutor->qualification}}</p>
                                </div>
                                <div class="col-sm-4 col-6 mb-2">
                                    <h5>Experience</h5>
                                    <p>{{$tutor->experience}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row m-4">
                        <div class="h4">Tutor Special Courses</div>
                        <ol>
                            @foreach($tutor->specialCourses as $course)
                            <li> {{$course->course}} </li>
                            @endforeach
                        </ol>
                    </div>
                    {{-- <div class="row m-4">
                        <div class="h4">Tutor Posts</div>
                        <ol>
                            @foreach($tutor->posts as $post)
                            <li> <a href="/tutor-posts/{{$post->slug}}"> {{$post->title}} </a></li>
                            @endforeach
                        </ol>
                    </div> --}}
                    
                </div>
                <div class="col-md-4">
                    <div class="card mb-3 booking-box">
                        <div class="card-header bg-transparent">
                            <h4 class="text-center">Tutor Courses</h4>
                        </div>
                        @php($c=[])
                        @forelse($tutor->batches as $batch)
                            @if(in_array($batch->course->name,$c))
                                @continue
                            @endif

                            <div class="card-body border-bottom row">
                                <div class="col-3 align-self-center">
                                    <img src="/storage/{{$batch->course->image}}" class="img-fluid">
                                </div>
                                <div class="col-9" style="line-height: 1">
                                    <h5 class="card-title"><a href="/courses/{{$batch->course->slug}}">{{$batch->course->name}}</a> </h5>
                                </div>
                            </div>

                            @php(array_push($c,$batch->course->name))
                        @empty
                            <div class="card-body">No Courses Found in this Tutor.</div>
                        @endforelse

                      </div>
                </div>
                
            </div>

            <div class="tutor-review-container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 style="display: inline">Reviews</h3> 
                        <button type="button" class="review-add-btn" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            Write a Review
                          </button>
                        @if ($tutor->reviews->where('status','Published')->count()>0)
                        <div class="tutor-rev-whole-container">
                            @foreach($tutor->reviews->where('status','Published') as $review)
                            <div class="t-single-review row">
                                <div class="col-md-6 t-review-header">
                                    <div class="pt-2"><span class="icon-user-tie reviewer-icon align-baseline"></span></div>
                                    <div>
                                        <h4 class="reviewr-name">{{$review->name}}</h4>
                                        <span class="reviewr-email">{{$review->email}}</span>
                                        <p>{{$review->created_at}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    {{-- <p>{{$review->rating}}</p> --}}
                                    <span>
                                        @for ($i=1;$i<=5;$i++)
                                        @if ($i<=$review->rating)
                                            <i class="fa fa-star color-review"></i>
                                        @else
                                        <i class="fa fa-star color-empty"></i>
                                        @endif
                                    @endfor
                                    </span>
                                    <span class="text-13"> 
                                        @if ($review->rating > 0)
                                        ({{$review->rating}} Ratings)
                                        @else
                                        (No Ratings)
                                        @endif
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <div class="t-review">{{$review->review}}</div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        @else
                        <p>No Reviews</p>
                        @endif
                        
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
            <h6 class="modal-title" id="reviewModalLabel">Write a Review</h6>
            </div>
            <div class="modal-body">
                <div class="leave-review">
                    <form action="/tutor/{{$tutor->id}}/review/add" method="post" enctype="multipart/form-data">
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

@endsection
