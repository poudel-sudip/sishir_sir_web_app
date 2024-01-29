
@php($important_footer_links = App\Models\Categories::where(['status'=>'Active','type'=>'imp_link'])->whereHas('imp_links')->get())
@if($important_footer_links->count())
<section class="footer-imp-link mt-5 mb-1">
  <div class="container-fluid">
    <h4 class="m-4 text-center">Important Links</h4>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @php($isFirstElement = true)
        @foreach($important_footer_links as $c)
          <button class="border nav-link {{$isFirstElement ? 'active' : ''}}" id="nav-{{ $c->id }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $c->id }}" type="button" role="tab" aria-controls="nav-{{ $c->id }}" aria-selected="true">{{ucwords($c->name)}}</button>
          @php($isFirstElement = false)
        @endforeach
      </div>
    </nav>
    <div class="tab-content border shadow" id="nav-tabContent">
      @php($isFirstElement = true)
      @foreach($important_footer_links as $c)
      <div class="tab-pane fade show {{$isFirstElement ? 'active' : ''}} " id="nav-{{ $c->id }}" role="tabpanel" aria-labelledby="nav-{{ $c->id }}-tab" tabindex="0">
        @php($isFirstElement = false)
        <ul class="row">
        @foreach($c->imp_links->sortBy('order') as $l)
        <li class="col-md-6"><a href="{{$l->link_url}}" target="_blank" style="color:inherit;font:inherit;"><i class="fas fa-link text-danger"></i>{{ucwords($l->link_title)}}</a></li>
        @endforeach
      </ul>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif


<footer class="page-footer">
  <div class="container-fluid px-md-4"> 
    <div class="row">
      <div class="col-md-4">
        <div class="footer-logo text-md-center">
          <img src="{{ asset('images/logo.png') }}" alt="footer-logo" height="80">
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <ul class="footer-menu">
              <li><a href="/about-us">About Us</a></li>
              <li><a href="/bmi-calculator">BMI Calculator</a></li>
              <li><a href="/health-ingos">Health INGOs in Nepal</a></li>
              <li><a href="//gorkhapatraonline.com/categories/loksewa" target="_blank">Gorkhapatra Loksewa</a></li>
              <li><a href="//drive.google.com/drive/folders/1ixtmm2DxJD7vhjCrAmy29-ID3RUxAsBf" target="_blank">IEC Materials</a></li>
              <li><a href="//drive.google.com/drive/folders/1aRMa-Zzow1NTHkrbP218PVQoL7g_lK27" target="_blank">Health Days</a></li>
              <li><a href="/enquiry">Enquiries</a></li>
              <li><a href="/testimonials">Testimonials</a></li>
              <li><a href="/discussion-forum">Discussion Forum</a></li>
            </ul>
            <hr>
          </div>
          <div class="col-md-6">
            <h5 class="mt-3">Info & Support </h5>
            <div class="row">
              <div class="col-12">
                <div class="info-phone"><a href="mailto:info@shisiradhikari.com" style="color:#fff"><span class="icon-mail2"></span>  info@shisiradhikari.com</a></div>
              </div>
              <div class="col-12">
                <div class="info-phone"><a target="_blank" href="https://whatsapp.com/channel/0029VaFMBIfLCoX9GMsJJ03w" style="color:#fff"><span class="icon-whatsapp"></span>  +977 - 981-2417639</a></div>
              </div>    
            </div>
            <hr>
            <h5 class="footer-toggle-section-handeler" style="cursor: pointer;">Connect with us </h5>
            <div class="footer-sosmed d-none d-md-block">
              <a class="facebook" href="https://www.facebook.com/groups/Healthandloksewa" target="_blank"><i class="fab fa-facebook-f"></i></a>
              <a class="whatsapp" href="https://whatsapp.com/channel/0029VaFMBIfLCoX9GMsJJ03w" target="_blank"><i class="icon-whatsapp"></i></a>
              <a class="youtube" href="https://www.youtube.com/channel/UCSFeHpNoMSF-BBgsDtro0zw" target="_blank"><i class="icon-youtube"></i></a>
              <a class="twitter" href="https://twitter.com/ShisirAdhikari" target="_blank"><i class="fab fa-twitter"></i></a>
              <a class="tiktok" href="#" target="_blank"><i class="fab fa-tiktok"></i></a>
              <a class="instagram" href="https://www.instagram.com/shisirkumaradhikari" target="_blank"><i class="fab fa-instagram"></i></a>
              <a class="linkedin" href="https://np.linkedin.com/in/shisirkumaradhikari" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
            <hr>
          </div>
        </div>        
      </div>

      <div class="col-md-5">
        <h5 class="mt-3 footer-toggle-section-handeler" style="cursor: pointer;">Most Popular </h5>
        <div class="row d-none d-md-block">
          @foreach(Helper::mostViewPosts() as $post)
            <div class="col-12 footer-most-viewed">
              <a href="{{$post->url}}">
                <div><i class="fa fa-pen-nib me-1"></i> {{$post->title}}  <small class="ms-2">({{$post->count}} views)</small> </div>
              </a>
            </div>
          @endforeach
        </div>
        
        <hr>
        <div class="visitor-tracker mt-3 wow fadeInUp">
          <h5 class="footer-toggle-section-handeler"  style="cursor: pointer;">Web Counter </h5>
          <?php 
           $web_counter = Helper::websiteCounter();  
          ?> 
          <div class="d-none d-md-block">
            <div><span>Last Updated Date: </span><span id="last_date"></span></div>
            <div><span>Total Blogs: </span><strong class="counter-count"> {{$web_counter->blog ?? '0'}} </strong></div>
            <div><span>Total Books: </span><strong class="counter-count"> {{$web_counter->book ?? '0'}} </strong></div>
            <div><span>Total MCQs: </span><strong class="counter-count"> {{$web_counter->mcq ?? '0'}} </strong></div>
            <div><span>Total PDF: </span><strong class="counter-count"> {{$web_counter->pdf ?? '0'}} </strong></div>
            <div><span>Total Downloads: </span><strong class="counter-count"> {{$web_counter->download ?? '0'}} </strong></div>
            <div><span>Website Visit Counter: </span><strong class="counter-count"> {{$web_counter->website ?? '0'}} </strong></div>
          </div>       
        </div>
        <hr>
      </div>         

      <div class="col-md-3">
        <div class="fb-continer">
          <div class="fb-page" data-href="https://www.facebook.com/Shisirkumaradhikari/" data-tabs="timeline"  data-small-header="false" data-container-width="100%" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/Shisirkumaradhikari/" class="fb-xfbml-parse-ignore">
              <a href="https://www.facebook.com/Shisirkumaradhikari/">Shisir Kumar Adhikari</a>
            </blockquote>
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
        <div id="copyright" style="font-size: 14px">Copyright &copy; <script> document.write(new Date().getFullYear()); </script> All right reserved <a href="#">Shisir Adhikari.</a> By <a target="_blank" href="//etutorclass.com">E-Tutor Class Pvt. Ltd.</a></div>
      </div>
      
    </div>
  </div>
</div>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v15.0" nonce="KN2MLonG"></script>

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