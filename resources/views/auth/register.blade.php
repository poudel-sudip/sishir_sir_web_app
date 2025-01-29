@extends('layouts.app')
@section('page_title','Register')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">           
            <div class="auth-container auth-register">
                <div class="user-welcome text-center">
                    <div class="mb-4 justify-content-center">
                        <a href="/"><img class="img-1" src="{{ asset('images/logo-w.png') }}" alt=""></a>
                    </div>
                    <div class="dont-have-account">
                        <p>Already have an account ?</p>
                        <a href="{{ route('login') }}">Log In</a>
                        
                    </div>
                    <div class="mt-4">
                        <div class="text-light"><strong><span class="h4">{{$user_count}}</span> Users Already Registered</strong></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-transparent">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-6 col-form-label">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-6 col-form-label">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-md-6 col-form-label">{{ __('Contact Number') }}</label>

                                <div class="col-md-12">
                                    <input id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact">

                                    @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blood_group" class="col-md-6 col-form-label">{{ __('Blood Group') }}</label>

                                <div class="col-md-12">
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

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="provience" class="col-form-label">{{ __('Provience') }}</label>
                                    <select name="provience" id="provience" class="form-control @error('provience') is-invalid @enderror" required onchange="getCities()">
                                        <option value="">Choose a Provience...</option>
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

                                <div class="col-md-6">
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


                            <div class="form-group row">
                                <label for="password" class="col-md-6 col-form-label col-6">{{ __('Create Password') }}</label>
                                <span class="col-6 text-end" style="font-size: 11px;align-self:center;color:#9b9999;text-align:end">(at least 8 characters)</span>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-6 col-form-label">{{ __('Confirm Password') }}</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="password">
                                </div>
                            </div>

                            <div class="form-group row mb-0 justify-content-center">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary register-btn">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-3 text-right text-primary h6 d-md-none">
                            <a class="text-info" href="{{ route('login') }}"> Already have an account ? <strong> Log In </strong></a> 
                            <div class="text-right text-primary mt-2"><strong><span class="h5">{{$user_count}}</span> Users Already Registered</strong></div>

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

@endsection
