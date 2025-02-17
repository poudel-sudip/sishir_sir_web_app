@extends('layouts.app')
@section('page_title','Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">        
        <div class="col-md-10">
            @if(isset($top_ad) && $top_ad)
                <div class="mb-4">
                    <img src="/storage/{{$top_ad->banner}}" onerror="this.src='/images/ads/default-750X50.png'" alt="" class="img img-fluid w-100">
                </div>
            @endif

            <div class="auth-container w-100">
                <div class="inner-container"></div>
                <div class="outer-container">
                    <div class="left-content">
                        <div class="logo-container mx-auto">
                            <a href="/"><img class="w-100" src="{{ asset('images/logo-w.png') }}" alt=""></a>
                        </div>
                        <div class="hidden-xs">
                            <h6 class="text-center">Don't have an account ?</h6>
                            <a class="btn reg-btn" href="{{ route('register') }}">Register Now</a>
                            <div class="user-count"><strong>{{$user_count}} + </strong> <span>Users Already Registered</span></div>
                        </div>
                    </div>
                    <div class="right-content">
                        <h2>Login</h2>
                        <div class="login-form">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
        
                                <div class="form-group text-left">
                                    <label for="email">{{ __('E-Mail Address') }}</label>                              
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group text-left position-relative">
                                    <label for="pass">{{ __('Password') }}</label>
                                    <input id="pass" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <i id="icon_click" class="fas fa-eye"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
        
                                <div class="form-group text-left">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="forget-password" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
        
                                <div class="form-group">
                                    <button type="submit" class="btn login-btn">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                            <div>OR</div>
                            <div class="login-with-social">
                                <a href="{{ url('auth/google') }}" class="btn">
                                    <img src="{{ asset('images/social-icons/google.png') }}" alt="Google Logo" style="width: 24px; height: 24px;"> 
                                    Login with Google</a>
                                {{-- <a href="{{ url('auth/facebook') }}" class="btn">
                                    <img src="{{ asset('images/social-icons/facebook.png') }}" alt="Facebook Logo" style="width: 24px; height: 24px;"> 
                                    Login with Facebook
                                </a>                                                        --}}
                            </div>

                            <div class="hidden-md">
                                <h6 class="text-center">Don't have an account ?</h6>
                                <a class="btn reg-btn" href="{{ route('register') }}">Register Now</a>
                                <div class="user-count"><strong>{{$user_count}} + </strong> <span>Users Already Registered</span></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @if(isset($bottom_ad) && $bottom_ad)
    <div class="row justify-content-center">
        <div class="mt-4 col-md-9">
            <img src="/storage/{{$bottom_ad->banner}}" onerror="this.src='/images/ads/default-1000X100.png'" alt="" class="img img-fluid w-100">
        </div>
    </div>
    @endif
</div>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 personal-details position-relative">
            <h1 class="text-danger">Shisir Kumar Adhikari</h1>
            <span>&#40;Aadharbhut Nagar Hospital Madhuban - Bardiya&#41;
                <br>
                CMA, HA &#40;CTEVT&#41; , BPH &#40;PU&#41; , M.Ed. 
                <br>
                Health & Promotion &#40;MU&#41;
            </span>
            <div class="social-media-links mt-4">
                <ul>
                    <li>
                        <img src="{{ asset('images/social-icons/youtube.png') }}" alt="youtube">
                        <a href="https://www.youtube.com/@HealthLoksewa">https://www.youtube.com/@HealthLoksewa</a>
                    </li>
                    <li>
                        <img src="{{ asset('images/social-icons/facebook.png') }}" alt="facebook">
                        <a href="https://www.facebook.com/Shisirkumaradhikari">https://www.facebook.com/Shisirkumaradhikari</a>
                    </li>
                    <li>
                        <img src="{{ asset('images/social-icons/twitter.png') }}" alt="twitter">
                        <a href="https://twitter.com/shisiradhikari">https://twitter.com/shisiradhikari</a>
                    </li>
                    <li>
                        <img src="{{ asset('images/social-icons/instagram.png') }}" alt="instagram">
                        <a href="https://www.instagram.com/shisirkumaradhikari/">https://www.instagram.com/shisirkumaradhikari/</a>
                    </li>
                    <li>
                        <img src="{{ asset('images/social-icons/viber.png') }}" alt="Viber">
                        <a href="">Health Loksewa Preparation</a>
                    </li>
                    <li>
                        <img src="{{ asset('images/social-icons/mail.png') }}" alt="Mail">
                        <a href="">info@shisiradhikari.com</a>
                    </li>
                </ul>
            </div>
            <div class="person-image">
                <img class="w-100" src="{{ asset('images/shisiradhikari.png') }}" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="vision-container">
                <h1>Vision</h1>
                <p>Shisiradhikari.com is a Nepalese education website that was created in 2022 
                    by Shisir Kumar Adhikari, who is also the author of the Mentor Series Books 
                    for Health Loksewa. The primary objective of this website is to provide a 
                    comprehensive set of online tools aimed at educating 
                    students studying school health science, public health, 
                    and medical disciplines.
                </p>
                <p>
                    The core focus of shisiradhikari.com is to deliver educational content through 
                    short video lessons. These videos serve as a means of imparting knowledge 
                    and facilitating understanding in an easily digestible format. By utilizing 
                    videos, the website aims to make the learning process 
                    engaging, interactive, and accessible to a wide range of students.
                </p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() 
    {
        $("#icon_click").click(function() 
        {
            console.log("click icon");
       		$(this).toggleClass("fas fa-eye fas fa-eye-slash");
         	var type = $(this).hasClass("fas fa-eye-slash") ? "text" : "password";
            $("#pass").attr("type", type);
        });
    });
</script>
@endsection
