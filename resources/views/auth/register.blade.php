@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="auth-container auth-register">
                <div class="text-center" style="margin: auto;">
                    <div class=" justify-content-center"><img class="img-1" src="{{ asset('images/logo-w.png') }}" alt=""></div>
                    <div class="dont-have-account">
                        <p>Already have an account ?</p>
                        <a href="{{ route('login') }}">Log In</a>
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

                            {{-- <div class="form-group row">
                                <div class="col-md-6">
                                <label for="district" class="col-form-label">{{ __('District') }}</label>
                                    <select name="district" id="district" class="form-control @error('district') is-invalid @enderror" required>
                                        <option value='Bhojpur'>Bhojpur</option>
                                        <option value='Dhankuta'>Dhankuta</option>
                                        <option value='Ilam'>Ilam</option>
                                        <option value='Jhapa'>Jhapa</option>
                                        <option value='Khotang'>Khotang</option>
                                        <option value='Morang'>Morang</option>
                                        <option value='Okhaldhunga'>Okhaldhunga</option>
                                        <option value='Panchthar'>Panchthar</option>
                                        <option value='Sankhuwasabha'>Sankhuwasabha</option>
                                        <option value='Solukhumbu'>Solukhumbu</option>
                                        <option value='Sunsari'>Sunsari</option>
                                        <option value='Taplejung'>Taplejung</option>
                                        <option value='Terhathum'>Terhathum</option>
                                        <option value='Udayapur'>Udayapur</option>
                                        <option value='Bara'>Bara</option>
                                        <option value='Dhanusa'>Dhanusa</option>
                                        <option value='Mahottari'>Mahottari</option>
                                        <option value='Parsa'>Parsa</option>
                                        <option value='Rautahat'>Rautahat</option>
                                        <option value='Saptari'>Saptari</option>
                                        <option value='Sarlahi'>Sarlahi</option>
                                        <option value='Siraha'>Siraha</option>
                                        <option value='Bhaktapur'>Bhaktapur</option>
                                        <option value='Chitwan'>Chitwan</option>
                                        <option value='Dhading'>Dhading</option>
                                        <option value='Dolakha'>Dolakha</option>
                                        <option value='Kathmandu'>Kathmandu</option>
                                        <option value='Kavrepalanchok'>Kavrepalanchok</option>
                                        <option value='Lalitpur'>Lalitpur</option>
                                        <option value='Makawanpur'>Makawanpur</option>
                                        <option value='Nuwakot'>Nuwakot</option>
                                        <option value='Ramechhap'>Ramechhap</option>
                                        <option value='Rasuwa'>Rasuwa</option>
                                        <option value='Sindhuli'>Sindhuli</option>
                                        <option value='Sindhupalchok'>Sindhupalchok</option>
                                        <option value='Baglung'>Baglung</option>
                                        <option value='Gorkha'>Gorkha</option>
                                        <option value='Kaski'>Kaski</option>
                                        <option value='Lamjung'>Lamjung</option>
                                        <option value='Manang'>Manang</option>
                                        <option value='Mustang'>Mustang</option>
                                        <option value='Myagdi'>Myagdi</option>
                                        <option value='Nawalpur'>Nawalpur</option>
                                        <option value='Parbat'>Parbat</option>
                                        <option value='Syangja'>Syangja</option>
                                        <option value='Tanahu'>Tanahu</option>
                                        <option value='Arghakhanchi'>Arghakhanchi</option>
                                        <option value='Banke'>Banke</option>
                                        <option value='Bardiya'>Bardiya</option>
                                        <option value='Dang'>Dang</option>
                                        <option value='Gulmi'>Gulmi</option>
                                        <option value='Kapilvastu'>Kapilvastu</option>
                                        <option value='Parasi'>Parasi</option>
                                        <option value='Palpa'>Palpa</option>
                                        <option value='Pyuthan'>Pyuthan</option>
                                        <option value='Rolpa'>Rolpa</option>
                                        <option value='Rukum'>Rukum</option>
                                        <option value='Rupandehi'>Rupandehi</option>
                                        <option value='Dailekh'>Dailekh</option>
                                        <option value='Dolpa'>Dolpa</option>
                                        <option value='Humla'>Humla</option>
                                        <option value='Jajarkot'>Jajarkot</option>
                                        <option value='Jumla'>Jumla</option>
                                        <option value='Kalikot'>Kalikot</option>
                                        <option value='Mugu '>Mugu </option>
                                        <option value='Rukum Paschim'>Rukum Paschim</option>
                                        <option value='Salyan'>Salyan</option>
                                        <option value='Surkhet'>Surkhet</option>
                                        <option value='Achham'>Achham</option>
                                        <option value='Baitadi'>Baitadi</option>
                                        <option value='Bajhang'>Bajhang</option>
                                        <option value='Bajura'>Bajura</option>
                                        <option value='Dadeldhura'>Dadeldhura</option>
                                        <option value='Darchula'>Darchula</option>
                                        <option value='Doti'>Doti</option>
                                        <option value='Kailali'>Kailali</option>
                                        <option value='Kanchanpur'>Kanchanpur</option>
                                    </select>

                                    @error('district')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                <label for="city" class="col-md-6 col-form-label">{{ __('City') }}</label>
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="form-group row">
                                <label for="interests" class="col-md-6 col-form-label">{{ __('Select your Courses') }}</label>

                                <div class="col-md-12">
                                    <input id="interests" type="text" class="col-12 form-control @error('interests') is-invalid @enderror" name="interests" value=" " readonly>
                                    <div class="interest-form-group">
                                        <select class="form-control" id="courses">

                                            @foreach($courses as $course)
                                                <option value="{{$course->name}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                        <button class="ml-3 btn btn-primary btn-sm" onclick="javascript:courseadd()" ><span class="icon-plus"></span></button>
                                    </div>
                                    @error('interests')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}


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
                    </div>
                </div>
            </div>
        </div>
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
