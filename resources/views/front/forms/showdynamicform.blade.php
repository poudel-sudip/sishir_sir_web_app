@extends('front.layouts.app')

@section('page_title', ($vform->title))
@section('og-title', ($vform->title))
@section('og-url', url('/dynamic-forms/'.$vform->slug))
@section('og-description', ($vform->title))
@if($vform->banner)
@section('og-image', asset('/storage/'.$vform->banner))
@endif

@section('content')
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-md-12 etutor-breadcrumb text-center">
                <h2>{{($vform->title)}}</h2>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item">Dynamic Forms</li>
                        <li class="breadcrumb-item active" aria-current="page">Fill Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-page">
        <div class="container-fluid px-md-5">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-center">
                            {{($vform->title)}}
                        </div>
                        <div class="card-body enroll_form row">
                            @if($vform->banner)
                            <div class="col-md-6">
                                <img src="/storage/{{$vform->banner}}" alt="" class="img img-fluid" style="max-height: 300px">
                            </div>
                            @endif
                            
                            <div class="col-md-6">
                                <form action="/dynamic-forms/{{$vform->slug}}" method="post" enctype="multipart/form-data">
                                    @csrf
    
                                    @if (Session::has('successMessage'))
                                    <div class="form-group row">
                                        <div class="alert alert-success">{!! Session::get('successMessage') !!}</div>
                                    </div>
                                    @endif
    
                                    <div class="form-group row">
                                        <label for="sub_course" class="col-12 col-form-label">{{ __('Course') }}</label>
                
                                        <div class="col-md-8">
                                            <select name="sub_course" id="sub_course" class="form-control @error('sub_course') is-invalid @enderror">
                                                {{-- <option value="">Choose One Sub Course</option> --}}
                                                @php($subs = array_map('trim', explode(',', $vform->sub_categories)))
                                                @foreach($subs as $cat)
                                                    <option value="{{($cat)}}">{{($cat)}}</option>
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
                                            <label for="element_name" class="col-12 col-form-label">Name</label>
            
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
                                            <label for="element_email" class="col-12 col-form-label">Email</label>
            
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
                                            <label for="element_contact" class="col-12 col-form-label">Contact</label>
            
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
                                                                                                    
                                    @if(isset($vform->message) && $vform->message)
                                        <div class="form-group row">
                                            <label for="element_message" class="col-12 col-form-label">Message</label>
            
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
                                        <div class="col-md-6 ">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection