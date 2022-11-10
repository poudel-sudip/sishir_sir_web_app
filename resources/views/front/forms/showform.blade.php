@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{$category->name}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/forms') }}">Forms</a></li>
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
                            {{$category->form->title}}
                        </div>
                        <div class="card-body enroll_form">
                            <form action="/forms/{{$category->slug}}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if (Session::has('successMessage'))
                                <div class="form-group row">
                                    <div class="alert alert-success">{!! Session::get('successMessage') !!}</div>
                                </div>
                                @endif

                                <div class="form-group text-center">
                                    @if($category->form->banner)
                                    <img src="/storage/{{$category->form->banner}}" alt="" class="img img-fluid" style="max-height: 250px">
                                    <hr>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label for="sub_course" class="col-md-4 col-form-label">{{ __('Sub Course') }}</label>
            
                                    <div class="col-md-8">
                                        <select name="sub_course" id="sub_course" class="form-control @error('sub_course') is-invalid @enderror">
                                            {{-- <option value="">Choose One Sub Course</option> --}}
                                            @foreach($category->subCategories as $cat)
                                                <option value="{{ucwords($cat->name)}}">{{ucwords($cat->name)}}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_course')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                @if(isset($category->form->name) && $category->form->name)
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
                                
                                @if(isset($category->form->email) && $category->form->email)
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

                                @if(isset($category->form->contact) && $category->form->contact)
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
                                
                                @if(isset($category->form->provience) && $category->form->provience)
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
                                
                                @if(isset($category->form->photo) && $category->form->photo)
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
                                
                                @if(isset($category->form->file) && $category->form->file)
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
                                
                                @if(isset($category->form->message) && $category->form->message)
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