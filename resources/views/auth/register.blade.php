@extends('layouts.app')
@section('page_title','Register')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">           
            <div class="auth-container auth-register">
                <div class="inner-container"></div>
                <div class="outer-container">
                    <div class="left-content">
                        <div class="logo-container mx-auto">
                            <a href="/"><img class="w-100" src="{{ asset('images/logo-w.png') }}" alt=""></a>
                        </div>
                        <div class="hidden-xs">
                            <h6 class="text-center">Already have an account ?</h6>
                            <a class="btn reg-btn" href="{{ route('login') }}">Log In</a>
                            <div class="user-count"><strong>{{$user_count}} + </strong> <span>Users Already Registered</span></div>
                        </div>
                    </div>
                    <div class="right-content">
                        <h2>Register</h2>
                        <div class="register-form">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group text-left">
                                            <label for="name" >{{ __('Name') }}</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-left">
                                            <label for="email">{{ __('E-Mail Address') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group text-left">
                                            <label for="contact">{{ __('Contact Number') }}</label>
                                            <input id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact">

                                                @error('contact')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-left">
                                            <label for="blood_group">{{ __('Blood Group') }}</label>
                                            <select name="blood_group" id="blood_group" class="form-control @error('blood_group') is-invalid @enderror" value="{{ old('blood_group') }}" required autocomplete="blood_group">
                                                    <option value="AB Positive">AB Positive (AB+)</option>
                                                    <option value="AB Negative">AB Negative (AB-)</option>
                                                    <option value="A Positive">A Positive (A+)</option>
                                                    <option value="A Negative">A Negative (A-)</option>
                                                    <option value="B Positive">B Positive (B+)</option>
                                                    <option value="B Negative">B Negative (B-)</option>
                                                    <option value="O Positive">O Positive (O+)</option>
                                                    <option value="O Negative">O Negative (O-)</option>
                                                </select>
                                                @error('blood_group')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group text-left">
                                            <label for="donate_blood">{{ __('Can you be contacted in the future as a blood donor?') }}</label>
                                            
                                            <div class="d-flex align-items-center">
                                                <div class="mr-4">
                                                    <div class="form-check">
                                                        <label class="col-form-label form-check-label">
                                                        <input id="donate_blood_1" type="radio" class="form-check-input" name="donate_blood" value="1"  >Yes</label>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="form-check">
                                                        <label class="col-form-label form-check-label">
                                                        <input id="donate_blood_0" type="radio" class="form-check-input" name="donate_blood" value="0" checked >No</label>
                                                    </div>
                                                </div>
                                                @error('donate_blood')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>                                            

                                            @error('donate_blood')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group text-left">
                                            <label for="provience" class="col-form-label">{{ __('Province') }}</label>
                                            <select name="provience" id="provience" class="form-control @error('provience') is-invalid @enderror" required onchange="getCities()">
                                                <option value="">Choose a Province...</option>
                                                @foreach($proviences as $pro)
                                                <option value="{{ucwords($pro->name)}}">{{ucwords($pro->name)}}</option>
                                                @endforeach
                                            </select>

                                            @error('provience')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-left">
                                            <label for="district_city" class="col-form-label">{{ __('District/City') }}</label>
                                            <select name="district_city" id="district_city" class="form-control @error('district_city') is-invalid @enderror" required>
                                            </select>

                                            @error('district_city')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                  
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group text-left position-relative">
                                            <label for="password">{{ __('Create Password') }}</label>
                                            <span class="col-6 text-end" style="font-size: 11px;align-self:center;color:#9b9999;text-align:end">(at least 8 characters)</span>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            <i id="icon_click" class="fas fa-eye"></i>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group text-left position-relative">
                                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="password">
                                            <i id="icon_click_confirm" class="fas fa-eye"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0 justify-content-center">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary register-btn">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="hidden-md">
                                <h6 class="text-center">Already have an account ?</h6>
                                <a class="btn reg-btn" href="{{ route('login') }}">Log In</a>
                                <div class="user-count"><strong>{{$user_count}} + </strong> <span>Users Already Registered</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if(isset($bottom_ad) && $bottom_ad)
            <div class="mt-4 col-12 text-center">
                <img src="/storage/{{$bottom_ad->banner}}" onerror="this.src='/images/ads/default-1000X100.png'" alt="" class="img img-fluid" style="max-height: 100px;">
            </div>
        @endif
    </div>
</div>

    <script>
                
        var proviences = {
            @foreach($proviences as $pro)
            '{{$pro->name}}' : [
                @foreach($pro->cities as $city)
                "{{$city->name}}",
                @endforeach
            ],
            @endforeach
        };

        function getCities()
        {
            var provience = $('#provience').find(":selected").val();
            $("#district_city").html("");
            if(provience)
            {
                var cities = proviences[provience];
                var op='';
                cities.forEach((city) => {
                    op += '<option value="' + city + '">' + city + '</option>';
                });
                // console.log(op);
                $("#district_city").append(op);
            }
        }

    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $("#icon_click").click(function() 
            {
                $(this).toggleClass("fas fa-eye fas fa-eye-slash");
                var type = $(this).hasClass("fas fa-eye-slash") ? "text" : "password";
                $("#password").attr("type", type);
            });

            $("#icon_click_confirm").click(function() 
            {
                $(this).toggleClass("fas fa-eye fas fa-eye-slash");
                var type = $(this).hasClass("fas fa-eye-slash") ? "text" : "password";
                $("#password-confirm").attr("type", type);
            });
        });
    </script>

@endsection
