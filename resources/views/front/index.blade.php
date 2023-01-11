@extends('front.layouts.app')
@section('content')
    <section class="home-slider">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="main-slider owl-carousel">
                        @foreach($sliders as $slider)
                            <div class="single-item">
                                <img src="/storage/{{$slider->image}}" alt="{{$slider->title}}" width="100%">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="homepage-side-update">
                        <div class="update-header"><h5><i class="fas fa-clock"></i> अपडेट</h5></div>
                        <div class="update-body">
                            <ul>
                                <li><a href="#"><i class="far fa-check-circle"></i> The photo taken at the Balkot-based residence of Oli</a></li>
                                <li><a href="#"><i class="far fa-check-circle"></i> The photo taken at the Balkot-based residence of Oli</a></li>
                                <li><a href="#"><i class="far fa-check-circle"></i> The photo taken at the Balkot-based residence of Oli, speaks a lot as Ganga, according to leaders of both parties, had played the role of a key interlocutor and helped thaw the relations between the two leaders— arch-rivals until just a few days before.</a></li>
                                <li><a href="#"><i class="far fa-check-circle"></i> The photo taken at the Balkot-based residence of Oli</a></li>
                                <li><a href="#"><i class="far fa-check-circle"></i> The photo taken at the Balkot-based residence of Oli speaks a lot as Ganga, according to leaders of both parties,</a></li>
                                <li><a href="#"><i class="far fa-check-circle"></i> The photo taken at the Balkot-based residence of Oli</a></li>
                                <li><a href="#"><i class="far fa-check-circle"></i> The photo taken at the Balkot-based residence of Oli speaks a lot as Ganga, according to leaders of both parties,</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <section class="video-course mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3 wow fadeInUp">Videos Courses</h2>
                </div>
            </div>
            <div class="course-container position-relative">
                <div class="elfsight-app-f553e3a0-98b2-48e2-906a-70b290b09fe1"></div>
                {{-- <div class="owl-carousel course-carousel">
                    <div class="post-thumb">
                        <a class="play_video_btn course-price " href="#play_video" video-id="" data-bs-toggle="modal" data-bs-target="#play_video"><img src="images/course1.jpg" alt="" ></a>
                    </div>
                </div> --}}
                <div class="video-gallery-hide"></div>
            </div>
        </div>
    </section>
    <section class="home-banner">
        <div class="container">
            <div class="row">
                @foreach ($ads as $ads)
                <div class="col-md-12 mb-2">
                    <img class="w-100" src="/storage/{{$ads->banner}}" alt="">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="mock-test mb-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3 wow fadeInUp">Mock Tests</h2>
                </div>
            </div>
            <div class="mocktest-container">
                <nav>
                    <div class="nav nav-tabs mock-premium" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Premium</button>
                      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Free</button>
                    </div>
                  </nav>
                  <div class="tab-content pt-4" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="row">
                            @foreach ($premiumExams as $exam)
                            <div class="col-md-6 mb-5">
                                <h3 class="mb-3 mock-heading">{{$exam->title}}</h3>
                                <a href="/exam-hall/premium/{{$exam->slug}}" class="mock-btn mock-btn1">Book Now</a>
                                {{-- <a href="" class="mock-btn mock-btn2">Book Now</a> --}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        <div class="row">
                            @foreach ($exams as $exam)
                            <div class="col-md-6 mb-5">
                                <h3 class="mb-3 mock-heading">{{$exam->name}}</h3>
                                <a href="/public-exams/{{$exam->slug}}" class="mock-btn mock-btn1">Exam</a>
                                {{-- <a href="" class="mock-btn mock-btn2">Book Now</a> --}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 text-end">
                        <a href="/public-exams" class="btn" style="background:#1375b9; color:#fff;">View all...</a>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <section class="home-blog mt-3 mb-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3 wow fadeInUp">Blogs</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="blog-section">
                        <div class="blog-header">
                            <a href="/blogs/{{$last_blog->slug}}"><img src="/storage/{{$last_blog->image}}" alt=""></a>
                        </div>
                        <div class="blog-footer">
                            <h3>{{$last_blog->title}}</h3>
                            <div class="blog-footer-details">{!! $last_blog->description !!}</div>
                            <div class="mb-3 mt-2"><small class="text-primary">Published: {{date('Y-m-d',strtotime($last_blog->created_at))}}</small> <small class="text-success" style="float: right">By: {{$last_blog->author}}</small></div>
                            <div class="blog-details"><a href="/blogs/{{$last_blog->slug}}">View Details</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 position-relative">
                    <div class="home-blog-list">
                        @foreach ($blogs as $blog)
                        <div class="row mb-2 @if ($loop->first) hidden @endif">
                            <div class="col-4">
                                <img src="/storage/{{$blog->image}}">
                            </div>
                            <div class="col-8">
                                <h4 class="blog-list-title"><a href="/blogs/{{$blog->slug}}">{{$blog->title}}</a></h4>
                                <div>Published: <span class="text-primary"> {{date('Y-m-d',strtotime($blog->created_at))}}</span></div>
                                <div>By: <span class="text-success"> {{$blog->author}}</span></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="home-blog-btn">
                        <a href="/blogs" class="btn">View all...</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <section class="home-ebook mt-3 mb-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12 text-center relative">
                    <h2 class="home-section-heading mb-3 wow fadeInUp">My Books</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($books as $book)
                <div class="col-md-3">
                    <div class="ebook-section">
                        <div class="ebook-header">
                            <img src="/storage/{{$book->thumbnail}}" alt="">
                        </div>
                        <div class="ebook-footer">
                            <a href=""><h4 title="{{ $book->title }}">{{ $book->title }}</h4></a>
                            <p>Price: <s class="text-danger">Rs. {{ $book->price }}</s> <strong class="text-success"> Rs. {{ $book->price - $book->discount }}</strong></p>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-12 text-end mt-2">
                    <a href="/books" class="btn" style="background:#1375b9;color:#fff">View all...</a>
                </div>
            </div>
        </div>
    </section>

    {{-- review section start --}}
@if(count($testimonials))
<section class="review-section">
  <div class="container">
    <div class="row mb-3">
        <div class="col-md-12 text-center relative">
            <h2 class="home-section-heading mb-3 wow fadeInUp">Testimonial</h2>
        </div>
    </div>
    <div class="review-container">
      <div class="row">
        <div class="review-slider owl-carousel">
            @foreach($testimonials as $testimonial)
                <div class="reviw-item">
                    <div class="reviewer">
                        <div class="profile-image">
                            <img src="/storage/{{$testimonial->image}}" alt="Feedback Review">
                        </div>
                        <div class="profile-details">
                            <h5>{{$testimonial->name}}</h5>
                            <p>{{$testimonial->role}}</p>
                        </div>
                    </div>
                    <div class="review-content">
                        <div class="review">
                            <p>{{$testimonial->message}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif

    {{-- <section class="loksewa-today mt-3 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 loksewa-selector mb-2">
                    <h2>आ. ब </h2>   
                        <select name="" id="">
                            <option value="">079-80</option>
                        </select>   
                    <h2> का.</h2>
                </div>
                <div class="col-md-8"><h2 class="loksewa-title">लोकसेवा आयोगमा आज </h2></div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center mb-5">
                    <h3 class="loksewa-content"><span class="span-left">कुल विज्ञापन</span>  |  <span class="span-right">150</span></h3>
                </div> 
                <div class="col-md-12 text-center mb-3">
                    <h3 class="loksewa-content"><span class="span-left">विज्ञापित कुल पद</span>  |  <span class="span-right">150</span></h3>
                </div> 
            </div>
        </div>
    </section> --}}


<!-- Modal HTML -->
{{-- <div class="modal fade" id="play_video" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Free Video</h5>
                <button type="button" class="close border-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe
                    id="video_iframe"
                    class="embed-responsive-item"
                    src=""
                    frameborder="0"
                    width="100%"
                    allowfullscreen
                    style="min-height: 400px;">

                </iframe>
            </div>
        </div>
    </div>
</div> --}}

<div class="enquiry-popup">
    <a href="/enquiry"><i class="fas fa-comment-alt"></i><span>Enquiry</span></a> 
</div>
{{-- youtube video palylist --}}
<script src="https://apps.elfsight.com/p/platform.js" defer></script>
{{-- <script>
    $(document).ready(function(){
        $('.play_video_btn').click(function(){
            console.log('hello');
            $('#video_iframe').attr('src','');
            let videoID = $(this).attr('video-id');
            let src= "https://www.youtube.com/embed/HvfVgnEipDw?autohide=1&controls=1&showinfo=1";
            $('#video_iframe').attr('src',src);
        });
    });
    
  </script> --}}

@endsection

