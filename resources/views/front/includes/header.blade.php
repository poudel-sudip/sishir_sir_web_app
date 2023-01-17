<header class="shishir-header">
  <nav class="navbar navbar-expand-lg main-nav">
    <div class="container-fluid px-5">
      <div class="site-logo">
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" height="60"></a>
      </div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars text-white" aria-hidden="true"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        {{-- <a class="navbar-brand" href="#">Hidden brand</a> --}}
        <?php
          $menus = App\Models\Menu\MenuGroup::where('status','=','Active')->orderBy('order')->get();
        ?>
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
          </li>
          @foreach($menus as $mainmenu)
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">{{ucwords($mainmenu->name)}}</a>
              <?php
                $submenus = $mainmenu->subGroups()->where('status','=','Active')->orderBy('order')->get();
              ?>
              <ul class="dropdown-menu">
                @foreach($submenus as $submenu)
                  <li>
                    <a class="dropdown-item" href="#">{{ucwords($submenu->name)}}</a>
                    <?php
                      $childmenus = $submenu->categories()->where('status','=','Active')->orderBy('order')->get();
                    ?>
                    <ul>
                      @foreach($childmenus as $cmenu)
                        <a href="/{{$mainmenu->slug}}/{{$submenu->slug}}/{{$cmenu->slug}}"> {{ucwords($cmenu->name)}} </a>
                      @endforeach
                    </ul>
                  </li>
                @endforeach
              </ul>
            </li>
          @endforeach
          {{-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Loksewa Aayog</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="">list 1</a></li>
              <li><a class="dropdown-item" href="">list 2</a></li>
              <li><a class="dropdown-item" href="">list 3</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Downloads</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">University Update</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="/books">Shishir's Book</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/public-exams">Mock Test</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/blogs">Blogs</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-4 pt-2">
        <iframe scrolling="no"
          border="0" 
          frameborder="0" 
          marginwidth="0" 
          marginheight="0" 
          allowtransparency="true" 
          style="height:50px; width:100%; overflow:hidden;"
          src="https://www.ashesh.com.np/linknepali-time.php?time_only=yes&font_color=1375b9&aj_time=yes&font_size=24&api=8311z7m197">
        </iframe>
      </div>
      <div class="col-md-8 align-items-center row">
        <div class="col-sm-8 col-12">
          <form action="/search/" method="GET">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search Here"  name="query" required>
              <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
            </div>
          </form>
        </div>
        <div class="col-sm-4 col-12 auth-nav">
          <nav class="navbar navbar-expand justify-content-center justify-content-lg-end" style="float: none;">
            <ul class="navbar-nav">
              @guest
                @if (Route::has('login'))
                  <li class="nav-item">
                    <a class="nav-link btn-login" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                @endif

                @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link btn-register" href="{{ route('register') }}">{{ __('Signup') }}</a>
                  </li>
                @endif
              @else
                <li class="nav-item login-username-home">
                  <a class="nav-link login-user" href="#" role="button">
                    <i class="fa fa-user"></i>
                    {{ Auth::user()->name }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn-login" href="{{route('login')}}">Dashboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn-register" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
              @endguest
            </ul>
          </nav>
        </div>
        
      </div>
    </div>
  </div>
</header>