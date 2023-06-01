<style>
  .footer-branch{
    display: grid;
    grid-template-columns: 1fr 1fr;
  }
</style>
<footer class="page-footer">
  
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @foreach(App\Models\Categories::where(['status'=>'Active','type'=>'imp_link'])->whereHas('imp_links')->get() as $c)
            <button class="nav-link {{ $c->id == 1 ? 'active' : '' }}" id="nav-{{ $c->id }}" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-{{ $c->id }}" aria-selected="true">{{ucwords($c->name)}}</button>
            @endforeach
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          @foreach(App\Models\Categories::where(['status'=>'Active','type'=>'imp_link'])->whereHas('imp_links')->get() as $c)
          <div class="tab-pane fade show {{ $c->id == 1 ? 'active' : '' }}" id="nav-{{ $c->id }}" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            @foreach($c->imp_links->sortBy('order') as $l)
            <a href="{{$l->link_url}}" target="_blank" style="color:inherit;font:inherit;">{{ucwords($l->link_title)}}</a>
            @endforeach
          </div>
          @endforeach
        </div>
      </div>
      
      </div>

      
    <div class="row px-md-3 mb-3">
      @foreach(App\Models\Categories::where(['status'=>'Active','type'=>'imp_link'])->whereHas('imp_links')->get() as $c)
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <h6>{{ucwords($c->name)}}</h6>
        <hr>
        <ul>
          @foreach($c->imp_links->sortBy('order') as $l)
          <li><a href="{{$l->link_url}}" target="_blank" style="color:inherit;font:inherit;">{{ucwords($l->link_title)}}</a></li>
          @endforeach
        </ul>
      </div>
      @endforeach
    </div>
    <div class="row px-md-3">
      <div class="col-sm-8 col-lg-8 py-3">        
        <div class="row">
          <div class="col-md-4 py-3">
            <div class="footer-logo">
              <img src="{{ asset('images/logo.png') }}" alt="footer-logo" height="80">
            </div>
            <hr>
            <ul class="footer-menu">
              <li><a href="/about-us">About Us</a></li>
              <li><a href="/blogs">Blogs</a></li>
              <li><a href="/results">Results</a></li>
              <li><a href="/privacy">Terms & Condition</a></li>
              <li><a href="/privacy">Privacy</a></li>
              <li><a href="/contact">Contact Us</a></li>
              <li><a href="/enquiry">Enquiries</a></li>
              <li><a href="/testimonials">Testimonials</a></li>
              {{-- <li><a href="/careers">Careers</a></li> --}}
            </ul>
          </div>
          <div class="col-md-8">
            <h3 class="mt-3">Info & Support :</h3>
            <div class="row">
              <div class="col-6">
                <div class="info-mobile"><span class="icon-mail2"></span>  info@shisiradhikari.com</div>
              </div>
              <div class="col-6">
                <div class="info-mobile"><span class="icon-phone"></span> +977- 981-2417639</div>
              </div>
            </div>
            <h3 class="mt-5">Connect with us :</h3>
            <div class="footer-sosmed">
              <a href="https://www.facebook.com/groups/Healthandloksewa" target="_blank"><i class="fab fa-facebook-f"></i></a>
              {{-- <a href="https://wa.me/9779857084806" target="_blank"><i class="icon-whatsapp"></i></a> --}}
              <a href="https://chat.whatsapp.com/FF97kXQ75RwAz8gP5MYGja" target="_blank"><i class="icon-whatsapp"></i></a>
              <a href="https://www.youtube.com/channel/UCSFeHpNoMSF-BBgsDtro0zw" target="_blank"><i class="icon-youtube"></i></a>
              <a href="https://twitter.com/ShisirAdhikari" target="_blank"><i class="fab fa-twitter"></i></a>
              <a href="#" target="_blank"><i class="fab fa-tiktok"></i></a>
              <a href="https://www.instagram.com/shisirkumaradhikari" target="_blank"><i class="fab fa-instagram"></i></a>
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
          
        </div>
    </div>
    <div class="col-sm-4 col-lg-4">
      <div class="fb-page" data-href="https://www.facebook.com/Shisirkumaradhikari/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Shisirkumaradhikari/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Shisirkumaradhikari/">Shisir Kumar Adhikari</a></blockquote></div>
    </div>
    
  </div>
</footer>

<div class="lower-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <p id="copyright">Copyright &copy; <script> document.write(new Date().getFullYear()); </script> All right reserved <a href="">Shisir Adhikari.</a> By <a href="">ODD Experts Pvt. Ltd.</a></p>
      </div>
      <div class="col-md-6">
       
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