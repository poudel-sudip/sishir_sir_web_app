<header class="shishir-header sticky-sm-top">
  <div class="topbar" style="background: #fff;">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="search-area">
            <form action="/search/" method="GET">
              <div class="input-group">
                <input type="text" class="form-control border border-primary" placeholder="Search Here"  name="query" required>
                <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-6 ">
          <div class="text-center" >
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" class="img img-fluid" style="max-height:55px;"></a>
          </div>
        </div>
        
        <div class="col-sm-3 col-12 auth-nav">
          <nav class="navbar navbar-expand justify-content-center justify-content-lg-end" style="float: none;">
            <ul class="navbar-nav align-items-center">
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
                  <a class="nav-link login-user text-nowrap" href="#" role="button" style="color:#1375b9 !important; " >
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
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars text-white" aria-hidden="true"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        
        <ul class="navbar-nav mb-2 mb-lg-0">
          
          <?php
            $parent_menus = App\Models\Menu\MenuGroup::where('status','=','Active')->orderBy('order')->take(8)->get();
          ?>         

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i> </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/library">Library</a>
          </li>

          @foreach($parent_menus as $parent)
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">{{($parent->name)}}</a>
              <?php
                $child_menus = $parent->subGroups()->where('status','=','Active')->orderBy('order')->take(15)->get(['id','name','slug','type']);
              ?>
              <ul class="dropdown-menu">
                @foreach($child_menus as $child)
                  <?php 
                    $child_link = "/".$parent->id."/".$child->id;
                  ?>
                  
                  <li class="parent-dropdown">
                    <a class="dropdown-item @if($child->type == 'heading') sub-drop-icon @endif" href="{{$child_link}}">{{($child->name)}}</a>
                    @if($child->type == 'heading')
                      <?php
                        $grandchild_menus = $child->categories()->where('status','=','Active')->orderBy('order')->take(10)->get(['id','name','slug','type']);
                      ?>

                      <div class="child-dropdown">
                        @foreach($grandchild_menus as $grandchild)
                          <a href="/{{$parent->id}}/{{$child->id}}/{{$grandchild->id}}"> {{($grandchild->name)}} </a>
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
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="/books" role="button" aria-expanded="false">Books</a>
            <ul class="dropdown-menu">
              @foreach(App\Models\Categories::where(['status'=>'Active','type'=>'book_publisher'])->whereHas('pub_categories')->orderBy('order')->take(5)->get() as $b)
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/book-publishers/{{$b->id}}">{{($b->name)}}</a>
              </li>
              @endforeach
            </ul>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Mock Test</a>
            <ul class="dropdown-menu">
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/public-exams">Exams</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/results">Results</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/pdf-banks">PDF Banks</a>
              </li>
            </ul>
          </li>
          
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link" href="/public-exams">Mock Test</a>-->
          <!--</li>-->
          
          <li class="nav-item">
            <a class="nav-link" href="/blogs">Blogs</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/vaccancies">Vacancies</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
</header>