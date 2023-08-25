
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
{{-- 
<div class="col-sm-5 col-lg-5 footer-imp-link">
  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      @foreach(App\Models\Categories::where(['status'=>'Active','type'=>'imp_link'])->whereHas('imp_links')->take(3)->get() as $c)
      <button class="nav-link {{ $c->id == 4 ? 'active' : '' }}" id="nav-{{ $c->id }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $c->id }}" type="button" role="tab" aria-controls="nav-{{ $c->id }}" aria-selected="true">{{ucwords($c->name)}}</button>
      @endforeach
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    @foreach(App\Models\Categories::where(['status'=>'Active','type'=>'imp_link'])->whereHas('imp_links')->take(3)->get() as $c)
    <div class="tab-pane fade show {{ $c->id == 4 ? 'active' : '' }}" id="nav-{{ $c->id }}" role="tabpanel" aria-labelledby="nav-{{ $c->id }}-tab" tabindex="0">
      <ul>
      @foreach($c->imp_links->sortBy('order') as $l)
      <li><a href="{{$l->link_url}}" target="_blank" style="color:inherit;font:inherit;"><i class="fas fa-link text-danger"></i>{{ucwords($l->link_title)}}</a></li>
      @endforeach
    </ul>
    </div>
    @endforeach
  </div>
</div> --}}

<footer class="page-footer">
  <div class="container-fluid px-md-4"> 
    <div class="row">
      <div class="col-md-4">
        <div class="footer-logo">
          <img src="{{ asset('images/logo.png') }}" alt="footer-logo" height="80">
        </div>
        <hr>
        <ul class="footer-menu">
          <li><a href="/about-us">About Us</a></li>
          <li><a href="/blogs">Blogs</a></li>
          <li><a href="/results">Results</a></li>
          {{-- <li><a href="/privacy">Terms & Condition</a></li> --}}
          {{-- <li><a href="/privacy">Privacy</a></li> --}}
          {{-- <li><a href="/contact">Contact Us</a></li> --}}
          <li><a href="/enquiry">Enquiries</a></li>
          <li><a href="/testimonials">Testimonials</a></li>
          {{-- <li><a href="/careers">Careers</a></li> --}}
        </ul>
      </div>
      <div class="col-md-4">
        <h5 class="mt-3">Info & Support :</h5>
        <div class="row">
          <div class="col-12">
            <div class="info-phone"><span class="icon-mail2"></span>  info@shisiradhikari.com</div>
          </div>
          <div class="col-12">
            <div class="info-phone"><span class="icon-whatsapp"></span>  +977 - 981-2417639</div>
          </div>
        </div>
        <h5 class="mt-5">Connect with us :</h5>
        <div class="footer-sosmed">
          <a class="facebook" href="https://www.facebook.com/groups/Healthandloksewa" target="_blank"><i class="fab fa-facebook-f"></i></a>
          {{-- <a class="whatsapp" href="https://wa.me/9779857084806" target="_blank"><i class="icon-whatsapp"></i></a> --}}
          <a class="whatsapp" href="https://chat.whatsapp.com/FF97kXQ75RwAz8gP5MYGja" target="_blank"><i class="icon-whatsapp"></i></a>
          <a class="youtube" href="https://www.youtube.com/channel/UCSFeHpNoMSF-BBgsDtro0zw" target="_blank"><i class="icon-youtube"></i></a>
          <a class="twitter" href="https://twitter.com/ShisirAdhikari" target="_blank"><i class="fab fa-twitter"></i></a>
          <a class="tiktok" href="#" target="_blank"><i class="fab fa-tiktok"></i></a>
          <a class="instagram" href="https://www.instagram.com/shisirkumaradhikari" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
        <hr>
        <div class="visitor-tracker mt-3">
          <?php 
            $page = View::getSection('page_title', '');
            $view_count = Helper::viewCount($page);
          ?>
          <div><span>Last Updated Date: </span><span id="last_date"></span></div>
          <div><span>Website Visit Counter: </span><strong> {{$view_count->web_view_count}} </strong></div>
        </div>
      </div>         

      <div class="col-md-4">
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