<header class="shishir-header sticky-sm-top">
  <div class="topbar" style="background: #fff;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4">
          
          <div class="mb-1 text-center text-md-start @if(url()->current() != url('/')) d-none d-md-block @endif">
            <a href="/child-nutrition-calculator" class="btn btn-danger mx-1">Child Nutrition Calculator</a>
            <a href="/bmi-calculator" class="btn btn-info mx-1">BMI Calculator</a>
          </div>
          
          <div class="search-area">
            <form action="/search/" method="GET">
              <div class="input-group">
                <input type="text" class="form-control border border-primary" placeholder="Search Here"  name="query" required>
                <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-4 text-center">
          <div class="text-center" >
            <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" class="img img-fluid" style="max-height:85px;"></a>
          </div>
          <span class="fw-bold fs-6 text-danger">धर्मो रक्षति रक्षितः</span>
        </div>
        
        <div class="col-sm-4 col-12 auth-nav">
          <div class="mb-1 d-flex justify-content-center justify-content-lg-end">
            <div class="" id="google_translate_element" ></div>
          </div>

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
                  <a class="nav-link login-user text-nowrap" href="#" role="button" style="color:#0C2B64 !important; " >
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
      <div class="collapse navbar-collapse justify-content-center" id="navbarTogglerDemo01">
        
        <ul class="navbar-nav mb-2 mb-lg-0">
          
          <?php
            $parent_menus = App\Models\Menu\MenuGroup::where('status','=','Active')->orderBy('order')->take(8)->get();
          ?>         

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i> </a>
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
          

          <li class="nav-item">
            <a class="nav-link" href="/courses">eCourses</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/pdf-banks">eBooks</a>
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
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/library">eLibrary</a>
          </li>

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
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">News Hub</a>
            <ul class="dropdown-menu">
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/newsroom">Newsroom</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/vaccancies">Vacancies</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/health-days">Health Days</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/health-dictionary">Dictionary</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/4/64">Notices</a>
              </li>
              <li class="parent-dropdown">
                <a class="dropdown-item" aria-current="page" href="/library/739">Public Holidays</a>
              </li>
            </ul>
          </li>
              
          <li class="nav-item">
            <a class="nav-link" href="/faqs">FAQs</a>
          </li> 
          
        </ul>
      </div>
    </div>
  </nav>
</header>