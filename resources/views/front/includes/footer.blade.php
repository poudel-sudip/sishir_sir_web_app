
@php($content_ad = App\Models\Advertisement::where(['status'=>'Active','position'=>'page_content_ad'])->first())
@if ($content_ad)
<section class="my-3 text-center">
  <div class="container-fluid">
    <img src="/storage/{{$content_ad->banner}}" onerror="this.src='/images/ads/default-1600X100.png'" alt="" class="img img-fluid" style="max-height: 100px;">
  </div>
</section>  
@endif


@php($important_footer_links = App\Models\Categories::where(['status'=>'Active','type'=>'imp_link'])->whereHas('imp_links')->get())
@if($important_footer_links->count())
<section class="footer-imp-link mt-5 mb-1">
  <div class="container-fluid">
    <h4 class="m-4 text-center">Important Links</h4>
    {{-- <nav>
      <div class="nav nav-tabs justify-content-center align-items-center" id="nav-tab" role="tablist">
        @php($isFirstElement = true)
        @foreach($important_footer_links as $c)
          <button class="border nav-link {{$isFirstElement ? 'active' : ''}}" id="nav-{{ $c->id }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $c->id }}" type="button" role="tab" aria-controls="nav-{{ $c->id }}" aria-selected="true">{{($c->name)}}</button>
          @php($isFirstElement = false)
        @endforeach
      </div>
    </nav> --}}
    <nav>
      <div class="d-flex align-items-center justify-content-center">
        <div class="swiper-button-prev"></div>
          <div class="swiper category-swiper nav nav-tabs" role="tablist">
            <div class="swiper-wrapper">
              @php($isFirstElement = true)

              @foreach($important_footer_links as $cat)
                <div class="swiper-slide">
                  <button 
                    class="nav-link border {{$isFirstElement ? 'active' : ''}}" 
                    id="nav-{{ $cat->id }}-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#nav-{{ $cat->id }}"
                    type="button"
                    role="tab"
                    aria-controls="nav-{{ $cat->id }}"
                    aria-selected="true"
                    >
                      {{$cat->name}}
                  </button>
                </div>
                @php($isFirstElement = false)
              @endforeach

            </div>
          </div>
          <div class="swiper-button-next"></div>
      </div>
    </nav>

    <div class="tab-content border shadow" id="nav-tabContent">
      @php($isFirstElement = true)
      @foreach($important_footer_links as $c)
      <div class="tab-pane fade show {{$isFirstElement ? 'active' : ''}} " id="nav-{{ $c->id }}" role="tabpanel" aria-labelledby="nav-{{ $c->id }}-tab" tabindex="0">
        @php($isFirstElement = false)
        <ul class="row">
        @foreach($c->imp_links->sortBy('order') as $l)
        <li class="col-md-6"><a href="{{$l->link_url}}" target="_blank" style="color:inherit;font:inherit;"><i class="fas fa-link text-danger"></i>{{($l->link_title)}}</a></li>
        @endforeach
      </ul>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="">
  <div class="row">
    <div class="col-12">
      <div class="d-flex align-items-center " style="background: #ffced2; font-weight:bold;">
          <div class=" bg-danger text-light p-2" style="align-self: stretch;">Trendings</div>
          <marquee direction="left" >
            @foreach(Helper::mostViewPosts() as $row)
            <a @if(trim($row->url)) href="{{$row->url}}" target="_blank" @endif class="highlight-text"> {{strtoupper($row->title)}} <small class=" text-primary text-nowrap">({{$row->count}} views)</small> </a>
            @endforeach
          </marquee>
      </div>                    
    </div>
  </div>
</section>

<footer class="page-footer">
  <div class="container-fluid px-md-4"> 
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4">
        {{-- <div class="footer-logo text-md-center">
          <img src="{{ asset('images/logo.png') }}" alt="footer-logo" height="80">
        </div> --}}
        {{-- <hr> --}}
        <div class="row">
          <div class="col-md-6">
            <ul class="footer-menu">
              <li><a href="/about-us">About Us</a></li>
              <li><a href="/bmi-calculator">BMI Calculator</a></li>
              <li><a href="/child-nutrition-calculator">Child Nutrition Calculator</a></li>
              <li><a href="/health-ingos">Health INGOs in Nepal</a></li>
              <li><a href="/palika-bibaran">Palika Bibaran in Nepal</a></li>
              <li><a href="//drive.google.com/drive/u/2/folders/1XP8xzmVw51RiRfooHMZf1vAdyydnvmY4"> Barambar Chahine Dastavej</a></li>
              <li><a href="//gorkhapatraonline.com/categories/loksewa" target="_blank">Gorkhapatra Loksewa</a></li>
              <li><a href="//drive.google.com/drive/folders/1ixtmm2DxJD7vhjCrAmy29-ID3RUxAsBf" target="_blank">IEC Materials</a></li>
              <li><a href="/health-days">Health Days</a></li>
              <li><a href="/enquiry">Enquiries</a></li>
              <li><a href="/testimonials">Testimonials</a></li>
              <li><a href="/question-of-the-day-quiz">Play Quiz</a></li>
              <li><a href="/play-puzzle">Play Puzzle</a></li>
              <li><a href="/know-the-picture">Know the Picture</a></li>
              <li><a href="/discussion-forum">Discussion Forum</a></li>
              <li><a href="/faqs">FAQs</a></li>
              <li><a href="/web-policy">Web Policy</a></li>
            </ul>
            <hr>
          </div>
          <div class="col-md-6">
            <h5 class="mt-3">Info & Support </h5>
            <ul class="footer-menu">
              {{-- <li><a>ई. हेल्थ नेटवर्क (प्रा. लि.)</a></li> --}}
              <li><a>E. Health Network (Pvt. Ltd.)</a></li>
              <li><a>Reg. No. 334903</a></li>
              <li><div class="info-phone"><a href="javascript:void(0);" style="color:#fff"><span class="fa fa-map-marker-alt"></span>  Birendranagar - 3 Surkhet, Nepal </a></div></li>
              <li><div class="info-phone"><a href="mailto:info@shisiradhikari.com" style="color:#fff"><span class="icon-mail2"></span>  info@shisiradhikari.com</a></div></li>
              <li><div class="info-phone"><a href="mailto: ehealthehn@gmail.com" style="color:#fff"><span class="icon-mail2"></span> ehealthehn@gmail.com</a></div></li>
              <li><div class="info-phone"><a target="_blank" href="https://whatsapp.com/channel/0029VaFMBIfLCoX9GMsJJ03w" style="color:#fff"><span class="icon-whatsapp"></span>  +977 - 970-2844270</a></div></li>
            </ul>           
            <hr>
            <h5 class="footer-toggle-section-handeler" style="cursor: pointer;">Connect with us </h5>
            <div class="footer-sosmed d-none d-md-block">
              <a class="facebook" href="https://www.facebook.com/groups/Healthandloksewa" target="_blank"><i class="fab fa-facebook-f"></i></a>
              <a class="whatsapp" href="https://wa.me/9779702844270" target="_blank"><i class="icon-whatsapp"></i></a>
              <a class="youtube" href="https://www.youtube.com/channel/UCSFeHpNoMSF-BBgsDtro0zw" target="_blank"><i class="icon-youtube"></i></a>
              <a class="twitter" href="https://twitter.com/ShisirAdhikari" target="_blank"><i class="icon-twitter"></i></a>
              <a class="tiktok" href="https://www.tiktok.com/@shisiradhikarig?_t=8p68TinKlfj&_r=1" target="_blank"><i class="fab fa-tiktok"></i></a>
              <a class="instagram" href="https://www.instagram.com/shisirkumaradhikari" target="_blank"><i class="fab fa-instagram"></i></a>
              <a class="linkedin" href="https://np.linkedin.com/in/shisirkumaradhikari" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
            <hr>
            
          </div>
        </div>        
      </div>

      <div class="col-12 col-md-6 col-lg-5">
        {{-- <h5 class="mt-3 footer-toggle-section-handeler" style="cursor: pointer;">Most Popular </h5>
        <div class="row d-none d-md-block">
          @foreach(Helper::mostViewPosts() as $post)
            <div class="col-12 footer-most-viewed">
              <a href="{{$post->url}}">
                <div><i class="fa fa-pen-nib me-1"></i> {{$post->title}}  <small class="ms-2">({{$post->count}} views)</small> </div>
              </a>
            </div>
          @endforeach
        </div>
        
        <hr> --}}
        <div class="visitor-tracker mt-3">
          <h5 class="footer-toggle-section-handeler"  style="cursor: pointer;">Web Counter </h5>
          <?php 
           $web_counter = Helper::websiteCounter();  
          ?> 
          <div class="d-none d-md-block">
            <div class="row">
              <div class="col">
                <div><span>Last Updated Date: </span><span id="last_date"></span></div>
                <div><span>Total Blogs: </span><strong class="counter-count-"> {{$web_counter->blog ?? '0'}} </strong></div>
                <div><span>Total Books: </span><strong class="counter-count-"> {{$web_counter->book ?? '0'}} </strong></div>
                <div><span>Total Book Editions: </span><strong class="counter-count-"> {{$web_counter->book_edition ?? '0'}} </strong></div>
                <div><span>Total Exams: </span><strong class="counter-count-"> {{$web_counter->exam ?? '0'}} </strong></div>
                <div><span>Total MCQs: </span><strong class="counter-count-"> {{$web_counter->mcq ?? '0'}} </strong></div>
                <div><span>Total PDF Bank: </span><strong class="counter-count-"> {{$web_counter->pdf_bank ?? '0'}} </strong></div>
                <div><span>Total PDF: </span><strong class="counter-count-"> {{$web_counter->pdf ?? '0'}} </strong></div>
                <div><span>Total Vacancies: </span><strong class="counter-count-"> {{$web_counter->vaccancy ?? '0'}} </strong></div>
                <div><span>Total Downloads: </span><strong class="counter-count-"> {{$web_counter->download ?? '0'}} </strong></div>
                <div><span>Website Visit Counter: </span><strong class="counter-count-"> {{$web_counter->website ?? '0'}} </strong></div>
              </div>
              <div class="col">
                <div id="youtube-channel-details" class="">                  
                  <a target="_blank" href="https://www.youtube.com/channel/UCSFeHpNoMSF-BBgsDtro0zw" style="color: inherit"><img id="youtube-channel-thumbnail" src="/images/youtube_thumb.png" alt="" class="img img-fluid mb-1" style="width: 120px"></a>
                  <a target="_blank" href="https://www.youtube.com/channel/UCSFeHpNoMSF-BBgsDtro0zw" style="color: inherit"><h5 id="youtube-channel-title"></h5></a>
                  <div><span id="youtube-subscriber-count"></span></div>
                  <div><span id="youtube-video-count"></span></div>
                  <div><span id="youtube-view-count"></span></div>
                </div>
              </div>
            </div>           
          </div>
         

        </div>
        <hr>
        <h5 class="footer-toggle-section-handeler"  style="cursor: pointer;">Payment Partners </h5>
        <ul class="footer-card-list d-none d-md-block">
          <li class="my-1"><a href="//esewa.com.np" target="_blank"><img src="{{ asset('images/card1.jpg') }}" alt="card esewa"></a></li>
          <li class="my-1"><a href="//fonepay.com" target="_blank"><img src="{{ asset('images/card5.jpg') }}" alt="card fone pay"></a></li>
          <li class="my-1"><a href="//nchl.com.np/" target="_blank"><img src="{{ asset('images/card8.jpg') }}" alt="card nepal pay"></a></li>
        </ul>
        <hr>
      </div>         

      <div class="col-12 col-md-12 col-lg-3">
        <div class="fb-continer">
          <div class="fb-page" data-href="https://www.facebook.com/Shisirkumaradhikari" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/Shisirkumaradhikari" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Shisirkumaradhikari">Shisir Kumar Adhikari</a></blockquote>
          </div>          
        </div>
        
      </div>
    </div>
  </div>
</footer>



<div class="lower-footer">
  <div class="container">
    <div class="row">
      
      <div class="col-12 text-center">
        <div id="copyright" style="font-size: 14px">Copyright &copy; 2023 - <script> document.write(new Date().getFullYear()); </script>. All right reserved <a href="/">E. Health Network Pvt. Ltd.</a> </div>
      </div>
      
    </div>
  </div>
</div>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0" nonce="Onct6Opa"></script>

<script>
  const d = new Date();
  d.setMinutes(d.getMinutes() - 10);
  document.getElementById("last_date").innerHTML = d;
</script>

<script>
  $('.footer-toggle-section-handeler').on('click',function(){
    $(this).next().toggleClass("d-none");
  });
</script>

