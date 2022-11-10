@extends('front.layouts.app')
@section('title')
  Home
@endsection
@section('content')
@include('front.includes.enquiry')
@include('front.includes.call-us')

@if($homepopup)
  <div id="pup-up-container">
    <div id="pop-up">
      <button id='close-btn'>X</button>
      <a href="{{ $homepopup->link }}">
        <img src="/storage/{{$homepopup->image}}" alt="{{ $homepopup->title }}">
      </a>
    </div>
  </div>
@endif

<section class="page-hero">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="main-banner">
          <div class="side-navbar">
            {{-- <ul class="course-nav">
                @foreach($categories as $category)
                  <li><a href="/category/{{$category->slug}}">{{$category->name}}</a></li>
                @endforeach
            </ul> --}}
            <ul class="course-nav">
              @php($i=1)
              @foreach($headercategories as $category)
              @if($category->courses()->where('status','Active')->count())
              <li class="subnav">
                <a href="" class="subnavbtn">{{$category->name}}</a>
                <div class="subnav-content">
                  @foreach($category->courses()->where('status','Active')->take(7)->get() as $course)
                  <a  href="/courses/{{$course->slug}}">{{ $course->name }}</a>
                  @endforeach
                </div>
              </li>
              @if($i>=8)
                @break
              @endif
              @php($i++)
              @endif
            @endforeach
            @php($i=1)
            <li class="sidebar-see-more">
              @if(count($headercategories->where('status','Active')) < 9)
              <span></span>
              @else
              <a href="{{ url('/courses') }}">see more</a>
              @endif
            </li>
          </ul>
          </div>
          <div class="hero-section">
            <div class="main-slider owl-carousel">
                @foreach($sliders as $slider)
                    <div class="single-item">
                        <img src="/storage/{{$slider->image}}" alt="{{$slider->title}}" width="100%">
                    </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@if(count($popularCourses))
<section class="course-section page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center relative">
        {{-- <span class="home-sub-heading">EXPLORE AMAZING FEATURES</span> --}}
        <h2 class="mb-3 wow fadeInUp"> Popular Courses</h2>
        <div class="header-view-more"><a href="{{ url('/popular-courses') }}">View More</a></div>
      </div>
    </div>
    <div class="course-container">
      <div class="owl-carousel course-carousel">
          @foreach($popularCourses as $course)
              <div class="card-course">
                  <div class="header">
                      <div class="post-thumb">
                        <a href="/courses/{{$course->slug}}">
                          <img src="/storage/{{$course->image}}" alt="{{$course->name}}">
                        </a>
                      </div>
                      {{-- <div class="post-category">
                      <a>{{$course->category->name}}</a>
                      </div> --}}
                  </div>
                  <div class="body">
                      <h5 class="post-title text-center">{{$course->name}}</h5>
                     <div class="course-info text-center">
                       <a class="course-price" href="/courses/{{$course->slug}}">View Details</a>
                     </div>
                  </div>
              </div>
          @endforeach
      </div>

    </div>
  </div>
</section>
@endif

@if(count($runningBatches))
<section class="course-section page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center relative">
        {{-- <span class="home-sub-heading">EXPLORE AMAZING FEATURES</span> --}}
        <h2 class="mb-3 wow fadeInUp"> Running Batches</h2>
        <div class="header-view-more"><a href="{{ url('/running-batches') }}">View More</a></div>
      </div>
    </div>
    <div class="course-container">
      <div class="owl-carousel course-carousel">
          @foreach($runningBatches as $batch)
              <div class="card-course">
                  <div class="header">
                      <div class="post-thumb">
                        <a href="/courses/{{$batch->course->slug}}/{{$batch->slug}}">
                          <img src="/storage/{{$batch->course->image}}" alt="{{$batch->name}}">
                        </a>
                      </div>
                      {{-- <div class="post-category">
                      <a>{{$batch->course->name}}</a>
                      </div> --}}
                  </div>
                  <div class="body">
                      <h5 class="post-title text-center">{{$batch->name}}</h5>
                     <div class="course-info text-center">
                       <a class="course-price" href="/courses/{{$batch->course->slug}}/{{$batch->slug}}">View Details</a>
                     </div>
                  </div>
              </div>
          @endforeach
      </div>

    </div>
  </div>
</section>
@endif

@if(count($orientations))
<section class="course-section page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center relative">
        <h2 class="mb-3 wow fadeInUp"> Free Live Classes</h2>
        {{-- <div class="header-view-more"><a href="{{ url('/free-live-classes') }}">View More</a></div> --}}
      </div>
    </div>
    <div class="course-container">
      <div class="owl-carousel orientation-slider">
          @foreach($orientations as $class)
              <div class="card-course">
                  <div class="header">
                      <div class="post-thumb">
                        <img src="/storage/{{$class->image}}" alt="">  
                      </div>
                      <div class="post-category" style="right:50%; left:0%; background:rgba(2,88,187,.8) ; color:#fff; font-size:14px;">
                        Starts On: <div data-countdown="{{$class->date.' '.$class->time}}">Upcoming...</div> 
                      </div>
                  </div>
                  <div class="body">
                      <h4 class="post-title text-primary">{{ucwords($class->course)}}</h4>
                     <div class="course-info mt-3">
                       <a class="btn-sm btn-primary live_class_btn" style="background: #3490dc" @if(trim($class->join_link)) href="#live_class_form" class-title="{{ucwords($class->course)}}" class-slug="{{$class->slug}}" data-bs-toggle="modal" data-bs-target="#live_class_form" @endif>Join Class</a>
                     </div>
                  </div>
              </div>
          @endforeach
      </div>

    </div>
  </div>
</section>
@endif

<section class="key-offering-section page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        {{-- <span class="home-sub-heading">EXPLORE AMAZING FEATURES</span> --}}
        <h2 class="mb-3 wow fadeInUp">Our Top-Notch Qualities</h2>
      </div>
    </div>
    <div class="key-offering-container">
      <div class="row wow fadeInUp">
        <div class="col-md-12 key-offering-images">
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/1.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Interactive Classroom</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/4.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Top Ranked Tutor</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/2.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Quiz & Live Test</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/3.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Study Materials</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/5.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Online Offline video Lectures</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/6.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Notification & Alerts</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/7.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Group Chat with Tutors</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/8.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Cutting Edge Curriculum</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/9.png') }}" alt="">
            </div>
            <div class="body">
              <h3>Affordable Fee Structure</h3>
            </div>
          </div>
          <div class="card-key">
            <div class="header">
              <img src="{{ asset('images/qualities/10.png') }}" alt="">
            </div>
            <div class="body">
              <h3>24x7H Supports</h3>
            </div>
          </div>

        </div>
        
        </div>        
      </div>
    </div>
  </div>
</section>

@if(count($videos))
<section class="course-section page-section">
  <div class="container">
      <div class="row">
          <div class="col-md-12 text-center relative">
              {{-- <span class="home-sub-heading">EXPLORE AMAZING FEATURES</span> --}}
              <h2 class="mb-3 wow fadeInUp">Free Learnings</h2>
              <div class="header-view-more"><a href="{{ url('/free-videos') }}">View More</a></div>
          </div>
      </div>
      <div class="course-container">
          <div class="owl-carousel course-carousel">
              @foreach($videos as $video)
                  <div class="card-course">
                      <div class="header">
                          <div class="post-thumb" style="height:118px">
                              <img src="https://img.youtube.com/vi/{{$video->video_id}}/maxresdefault.jpg" alt="" >
                          </div>

                      </div>
                      <div class="body">
                          <h5 class="post-title text-center" style="font-size: 16px">{{$video->title}}</h5>
                          <div class="course-info text-center">
                              <a class="play_video_btn course-price " href="#play_video" video-id="{{$video->video_id}}" data-bs-toggle="modal" data-bs-target="#play_video">View</a>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>

      </div>
  </div>
</section>
@endif


<section class="how-does-work">
  <div class="work-overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="mb-3 wow fadeInUp">How Does This Work</h2>
        </div>
      </div>

      <div class="work-container">
        <div class="row wow fadeInUp">
          <div class="col-md-3 col-3">
            <div class="card-work">
              <img src="{{ asset('images/work-1.png') }}" alt="">
              <div class="does-work-text"><h3>Get Registerd</h3></div>
            </div>
          </div>
          <div class="col-md-3 col-3">
            <div class="card-work">
              <img src="{{ asset('images/work-2.png') }}" alt="">
              <div class="does-work-text"><h3>Book Class</h3></div>
            </div>
          </div>
          <div class="col-md-3 col-3">
            <div class="card-work">
              <img src="{{ asset('images/work-3.png') }}" alt="">
              <div class="does-work-text"><h3>Verify Booking</h3></div>
            </div>
          </div>
          <div class="col-md-3 col-3">
            <div class="card-work">
              <img src="{{ asset('images/work-4.png') }}" alt="" style="width:87%">
              <div class="does-work-text"><h3>Access Classroom</h3></div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

{{-- top tutors --}}
@if(count($tutors))
<section class="top-tutors-section page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center pb-2">
        {{-- <span class="home-sub-heading">EXPLORE AMAZING FEATURES</span> --}}
        <h2 class="mb-3 wow fadeInUp"> Our Tutors</h2>
      </div>
    </div>
    <div class="top-tutors-container">
      <div class="row">
        <div class="owl-carousel" id="top-tutors-slider">
            @foreach($tutors as $tutor)
                <div class="slider-item">
            <div class="tutor-image">
              <img src="/storage/{{$tutor->user->photo}}" alt="{{$tutor->name}}">
            </div>
            <div class="tutor-details">
                <h5><a href="/tutor/{{$tutor->slug}}">{{$tutor->name}}</a></h5>
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
          </div>
            @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif

{{-- review section start --}}
@if(count($testimonials))
<section class="review-section page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        {{-- <span class="home-sub-heading">EXPLORE AMAZING FEATURES</span> --}}
        <h2 class="mb-3 wow fadeInUp">Why Students Love Us</h2>
      </div>
    </div>
    <div class="review-container">
      <div class="row">
        <div class="review-slider owl-carousel">
            @foreach($testimonials as $testimonial)
                <div class="reviw-item">
                    <div class="review-content">
                        <div class="image-center">
                            <img src="{{asset('images/quote.png')}}" alt="{{$testimonial->name}}">
                        </div>
                        <div class="review">
                            <p>{{$testimonial->message}}</p>
                        </div>
                    </div>
                    <div class="reviewer">
                        <div class="profile-image">
                            <img src="/storage/{{$testimonial->image}}" alt="Feedback Review">
                        </div>
                        <div class="profile-details">
                            <h5>{{$testimonial->name}}</h5>
                            <p>{{$testimonial->role}}</p>
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

<!-- Free Video View Modal HTML -->
<div class="modal fade" id="play_video" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
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
</div>

<!-- Free Live Class Form Modal HTML -->
<div class="modal fade" id="live_class_form" tabindex="-1" role="dialog" aria-labelledby="LiveClassFormModel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="">
          <div class="modal-header">
              <h5 class="modal-title" id="LiveClassFormModel">Enter Your Details To Join The Free Class</h5>
              <button type="button" class="close border-danger" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="text-danger">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="/free-live-classes/join" enctype="multipart/form-data">
              @csrf

              <div class="form-group row my-2">
                <label for="std_class" class="col-md-3 col-form-label">{{ __(' Live Class') }}</label>

                <div class="col-md-9">
                    <input id="std_class" type="text" class="form-control @error('std_class') is-invalid @enderror" name="std_class" value="{{ old('std_class') }}" readonly>

                    @error('std_class')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>

              <div class="form-group row my-2">
                <label for="std_name" class="col-md-3 col-form-label">{{ __(' Name') }}</label>

                <div class="col-md-9">
                    <input id="std_name" type="text" class="form-control @error('std_name') is-invalid @enderror" name="std_name" value="{{ old('std_name') }}" required autofocus>

                    @error('std_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>

              <div class="form-group row my-2">
                <label for="std_contact" class="col-md-3 col-form-label">{{ __(' Contact No') }}</label>

                <div class="col-md-9">
                    <input id="std_contact" type="number" class="form-control @error('std_contact') is-invalid @enderror" name="std_contact" value="{{ old('std_contact') }}" required >

                    @error('std_contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>

              <div class="form-group row my-2">
                <label for="std_email" class="col-md-3 col-form-label">{{ __(' Email') }}</label>

                <div class="col-md-9">
                    <input id="std_email" type="email" class="form-control @error('std_email') is-invalid @enderror" name="std_email" value="{{ old('std_email') }}" >

                    @error('std_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>

              <div class="form-group row my-2">
                <div class="col-md-6 offset-md-4">
                    <input type="hidden" name="class_slug" id="class_slug" value="">
                    <button type="submit" class="btn btn-primary" style="background: #3490dc;">
                        {{ __('Join Now') }}
                    </button>
                </div>
              </div>

            </form>
          </div>
      </div>
  </div>
</div>


<!-- Messenger Chat Plugin Code -->
<div id="fb-root"> </div>
<div id="fb-customer-chat" class="fb-customerchat"> </div>
<script>
  var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "101376381373732");
    chatbox.setAttribute("attribution", "biz_inbox");

    window.fbAsyncInit = function() {
      FB.init({
        xfbml            : true,
        version          : 'v12.0'
      });
    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
  {{-- facebook messenger plugin add --}}

<script>
  //home page player
  $(document).ready(function(){
      $('.play_video_btn').click(function(){
          console.log('hello');
          $('#video_iframe').attr('src','');
          let videoID = $(this).attr('video-id');
          let src= "https://www.youtube.com/embed/"+videoID+"?autohide=1&controls=1&showinfo=1";
          $('#video_iframe').attr('src',src);
      });
  });
  
</script>

@if($homepopup)
  <script>
    //homepage popup
    $(document).ready(function(){

    var stopAutohide;

    function showWindow(){
      $('#pup-up-container').show();
      // stop scroll
      $('html body').css('overflow','hidden');
      // auto hide fter 5s
      stopAutohide = setTimeout(hideWindow,8000);

    }
    //showWindow()

    function hideWindow(){
      $('#pup-up-container').hide();
      // on scroll
      $('html body').css('overflow','scroll');
    }
    //hideWindow()

    // now call function automatically after some time 


    // auto open after 2s
    setTimeout(showWindow,2000);

    // close after click 

    $("#close-btn").click(function(){

      hideWindow();
      celarTimeout(stopAutohide);

    })

    })
  </script>
@endif

<script src="{{ asset('js/libraries/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/libraries/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/libraries/wow.min.js') }}"></script>
<script src="{{ asset('js/libraries/jquery.countdown.min.js') }}"></script>
<script>
  $('[data-countdown]').each(function() {
      var $this = $(this), finalDate = $(this).data('countdown');
      $this.countdown(finalDate, function(event) {
          $this.html(event.strftime('%D Days %H:%M:%S'));
      }).on('finish.countdown',function(){
          $this.html('Already Started');
      });
  });
</script>

<script>
  //orientation class slider control

  $('.orientation-slider').owlCarousel({
    items: 3,
    smartSpeed: 400,
    loop: false,
    nav: true,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: false
        },
        600: {
            items: 2
        },
        1000: {
            items: 3
        }
    }
  });
</script>

<script>
  // this script is used to prompt live class form model

    //home page player
  $(document).ready(function(){
      $('.live_class_btn').click(function(){
          
          //clear previous data
          $('#std_class').attr('value','');
          $('#class_slug').attr('value','');

          //fetch current data
          let cslug = $(this).attr('class-slug');
          let ctitle = $(this).attr('class-title');

          //set the value to the model
          $('#std_class').attr('value',ctitle);
          $('#class_slug').attr('value',cslug);

      });
  });
</script>

@endsection
