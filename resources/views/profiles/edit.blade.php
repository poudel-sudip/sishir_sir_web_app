@extends($header)

@section('student-title')
    Edit Profile
@endsection

@section('student-title-icon')
    <i class="far fa-edit"></i>
@endsection
@section('tutor-title')
    Edit Profile
@endsection
@section('tutor-title-icon')
    <i class="far fa-edit"></i>
@endsection

@section('content')
    <div class="student-content-wrapper content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card student_verify_card">
                    <div class="card-header">{{ __('Edit Profile : ') }}</div>

                    <div class="card-body enroll_form">
                        <form method="POST" action="/profile" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? auth()->user()->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? auth()->user()->email }}" required autocomplete="email" >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('Contact No.') }} </label>

                                <div class="col-md-8">
                                    <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') ?? auth()->user()->contact }}" required>

                                    @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="district" class="col-md-4 col-form-label text-md-right">{{ __('District ') }} </label>

                                <div class="col-md-8">
                                    <select name="district" id="district" value="{{ old('district') ?? auth()->user()->district }}" class="form-control @error('district') is-invalid @enderror" required>
                                        <option value="{{ auth()->user()->district }}">{{ auth()->user()->district }}</option>
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
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }} </label>

                                <div class="col-md-8">
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') ?? auth()->user()->city }}" required>

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="provience" class="col-md-4 col-form-label text-md-right">{{ __('Provience') }} </label>

                                <div class="col-md-8">
                                    <select name="provience" id="provience" class="form-control @error('provience') is-invalid @enderror" required onchange="getCities()">
                                        <option value="{{auth()->user()->provience}}">{{auth()->user()->provience}}</option>
                                        <option value="">--------------</option>
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

                            <div class="form-group row">
                                <label for="district_city" class="col-md-4 col-form-label text-md-right">{{ __('District/City') }} </label>

                                <div class="col-md-8">
                                    <select name="district_city" id="district_city" class="form-control @error('district_city') is-invalid @enderror" required>
                                        <option value="{{auth()->user()->district_city}}">{{auth()->user()->district_city}}</option>                                       
                                    </select>
                                    @error('district_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interests" class="col-md-4 col-form-label text-md-right">{{ __('Interests') }} </label>

                                <div class="col-md-8">
                                    <input id="interests" type="text" class="form-control @error('interests') is-invalid @enderror" name="interests" value="{{ old('interests') ?? auth()->user()->interests }}" >

                                    @error('interests')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }} </label>

                                <div class="col-md-8">
                                    <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo">
                                    <input type="hidden" name="old-photo" value="{{auth()->user()->photo}}">
                                    @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>

                        </form>
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
