<header class="shishir-header sticky-sm-top">
  <div class="topbar">
    <div class="container-fluid px-md-5">
      <div class="row">
        <div class="col-md-2 text-sm">
          <div class="site-logo">
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
          </div>
        </div>
        <div class="col-md-5">
          <div class="search-area">
            <form action="/search/" method="GET">
              <div class="input-group">
                <input type="text" class="form-control text-light" placeholder="Search Here"  name="query" required>
                <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-sm-5 col-12 auth-nav">
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
      </div> <!-- .row -->
    </div> <!-- .container -->
  </div> <!-- .topbar -->

  {{-- main navbar --}}
  <nav class="navbar navbar-expand-lg main-nav">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars text-white" aria-hidden="true"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <?php
          $parent_menus = App\Models\Menu\MenuGroup::where('status','=','Active')->orderBy('order')->take(8)->get();
        ?>
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i> </a>
          </li>

          @foreach($parent_menus as $parent)
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">{{ucwords($parent->name)}}</a>
              <?php
                $child_menus = $parent->subGroups()->where('status','=','Active')->orderBy('order')->take(10)->get(['id','name','slug','type']);
              ?>
              <ul class="dropdown-menu">
                @foreach($child_menus as $child)
                  <?php 
                    $child_link = "/".$parent->slug."/".$child->slug;
                  ?>
                  
                  <li class="parent-dropdown">
                    <a class="dropdown-item @if($child->type == 'heading') sub-drop-icon @endif" href="{{$child_link}}">{{ucwords($child->name)}}</a>
                    @if($child->type == 'heading')
                      <?php
                        $grandchild_menus = $child->categories()->where('status','=','Active')->orderBy('order')->take(10)->get(['id','name','slug','type']);
                      ?>

                      <div class="child-dropdown">
                        @foreach($grandchild_menus as $grandchild)
                          <a href="/{{$parent->slug}}/{{$child->slug}}/{{$grandchild->slug}}"> {{ucwords($grandchild->name)}} </a>
                        @endforeach
                      </div>
                    @endif
                  </li>
                @endforeach
              </ul>
            </li>
          @endforeach
          
          {{-- <li class="nav-item ">
            <a class="nav-link" href="/books">My Book</a>
          </li> --}}

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="/books" role="button" aria-expanded="false">My Books</a>
            <ul class="dropdown-menu">
              @foreach(App\Models\Categories::where(['status'=>'Active','type'=>'book'])->whereHas('books')->orderBy('order')->take(5)->get() as $b)
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/books-category/{{$b->slug}}">{{ucwords($b->name)}}</a>
              </li>
              @endforeach
            </ul>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Mock Test</a>
            <ul class="dropdown-menu">
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/public-exams">Exams</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/results">Results</a>
              </li>
            </ul>
          </li>
          
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link" href="/public-exams">Mock Test</a>-->
          <!--</li>-->
          
          <li class="nav-item">
            <a class="nav-link" href="/blogs">Blogs</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
</header>