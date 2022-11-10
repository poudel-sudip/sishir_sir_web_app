@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{ucwords($vform->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item">Vendor Forms</li>
                        <li class="breadcrumb-item active" aria-current="page">Fill Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-5">
                        <div class="card-header text-center">
                            {{ucwords($vform->title)}}
                        </div>
                        <div class="card-body enroll_form">
                            <form action="/vendor-forms/{{$vform->slug}}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if (Session::has('successMessage'))
                                <div class="form-group row">
                                    <div class="alert alert-success">{!! Session::get('successMessage') !!}</div>
                                </div>
                                @endif

                                <div class="form-group text-center">
                                    @if($vform->banner)
                                    <img src="/storage/{{$vform->banner}}" alt="" class="img img-fluid" style="max-height: 250px">
                                    <hr>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label for="sub_course" class="col-md-4 col-form-label">{{ __('Sub Course') }}</label>
            
                                    <div class="col-md-8">
                                        <select name="sub_course" id="sub_course" class="form-control @error('sub_course') is-invalid @enderror">
                                            {{-- <option value="">Choose One Sub Course</option> --}}
                                            @php($subs = array_map('trim', explode(',', $vform->sub_categories)))
                                            @foreach($subs as $cat)
                                                <option value="{{ucwords($cat)}}">{{ucwords($cat)}}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_course')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                @if(isset($vform->name) && $vform->name)
                                    <div class="form-group row">
                                        <label for="element_name" class="col-md-4 col-form-label">Name</label>
        
                                        <div class="col-md-8">
                                            <input id="element_name" type="text" class="form-control @error('element_name') is-invalid @enderror" name="element_name" value="{{ old('element_name') }}" required>
        
                                            @error('element_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                
                                @if(isset($vform->email) && $vform->email)
                                    <div class="form-group row">
                                        <label for="element_email" class="col-md-4 col-form-label">Email</label>
        
                                        <div class="col-md-8">
                                            <input id="element_email" type="email" class="form-control @error('element_email') is-invalid @enderror" name="element_email" value="{{ old('element_email') }}" required>
        
                                            @error('element_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                @if(isset($vform->contact) && $vform->contact)
                                    <div class="form-group row">
                                        <label for="element_contact" class="col-md-4 col-form-label">Contact</label>
        
                                        <div class="col-md-8">
                                            <input id="element_contact" type="number" class="form-control @error('element_contact') is-invalid @enderror" name="element_contact" value="{{ old('element_contact') }}" required>
        
                                            @error('element_contact')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                
                                @if(isset($vform->provience) && $vform->provience)
                                    <div class="form-group row">
                                        <label for="provience" class="col-md-4 col-form-label">{{ __('Provience') }}</label>
                
                                        <div class="col-md-8">
                                            <select name="provience" id="provience" class="form-control @error('provience') is-invalid @enderror" onchange="getCities()" required>
                                                <option value="">Select your Provience</option>
                                                @foreach($proviences as $pro)
                                                    <option value="{{$pro->name}}">{{$pro->name}}</option>
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
                                        <label for="district" class="col-md-4 col-form-label">{{ __('District') }}</label>
                
                                        <div class="col-md-8">
                                            <select name="district" id="district" class="form-control @error('district') is-invalid @enderror">
                                                <option value="">Select an District</option>
                                            </select>
                                            @error('course')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                
                                @if(isset($vform->photo) && $vform->photo)
                                    <div class="form-group row">
                                        <label for="element_photo" class="col-md-4 col-form-label">Photo</label>
        
                                        <div class="col-md-8">
                                            <input id="element_photo" type="file" class="form-control @error('element_photo') is-invalid @enderror" name="element_photo" value="{{ old('element_photo') }}" required>
        
                                            @error('element_photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                
                                @if(isset($vform->file) && $vform->file)
                                    <div class="form-group row">
                                        <label for="element_file" class="col-md-4 col-form-label">Attach File</label>
        
                                        <div class="col-md-8">
                                            <input id="element_file" type="file" class="form-control @error('element_file') is-invalid @enderror" name="element_file" value="{{ old('element_file') }}" required>
        
                                            @error('element_file')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                
                                @if(isset($vform->message) && $vform->message)
                                    <div class="form-group row">
                                        <label for="element_message" class="col-md-4 col-form-label">Message</label>
        
                                        <div class="col-md-8">
                                            <textarea name="element_message" id="element_message" rows="2" class="form-control @error('element_message') is-invalid @enderror"> {{ old('element_message') }} </textarea>
                                            
                                            @error('element_message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
            $("#district").html("");
            if(provience)
            {
                var cities = proviences[provience];
                var op='';
                cities.forEach((city) => {
                    op += '<option value="' + city + '">' + city + '</option>';
                });
                // console.log(op);
                $("#district").append(op);
            }
        }
    </script>

@endsection