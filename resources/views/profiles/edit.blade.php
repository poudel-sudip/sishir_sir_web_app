@extends($header)

@section('student-title')
    Edit Profile
@endsection

@section('student-title-icon')
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
