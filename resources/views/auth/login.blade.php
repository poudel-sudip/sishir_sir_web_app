@extends('layouts.app')
@section('page_title','Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-container">
                <div class="user-welcome text-center">
                    <div class="mb-4 justify-content-center">
                        <a href="/"><img class="img-1" src="{{ asset('images/logo-w.png') }}" alt=""></a>
                    </div>
                    <div class="dont-have-account">
                        <p>Don't have an account ? <br> </p>
                        <a href="{{ route('register') }}">Register Now</a>
                    </div>
                    <div class="mt-4">
                        <div class="text-light"><strong><span class="h4">{{$user_count}}</span> Users Already Registered</strong></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-transparent">{{ __('Login') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="form-group row">
                                <label for="email" class="col-md-6 col-form-label">{{ __('E-Mail Address') }}</label>
    
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password" class="col-md-6 col-form-label">{{ __('Password') }}</label>
    
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
    
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif


                                </div>
                            </div>
                        </form>

                        <div class="mt-3 text-right text-primary h6 d-md-none">
                            <a class="text-info" href="{{ route('register') }}"> Don't have an account ? <strong> Register Now </strong></a> 
                            <div class="text-right text-primary mt-2"><strong><span class="h5">{{$user_count}}</span> Users Already Registered</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
