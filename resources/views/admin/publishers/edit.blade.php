@extends('admin.layouts.app')
@section('admin-title')
    Edit Publisher
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Publisher</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/publishers">Publishers</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Publisher: {{ $publisher->name }}</div>

                    <div class="card-body">
                        <form method="POST" action="/admin/publishers/{{$publisher->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">{{ __('Publisher Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $publisher->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $publisher->user->email }}" autocomplete="email" >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-md-4 col-form-label">{{ __('Contact No') }}</label>

                                <div class="col-md-8">
                                    <input id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') ?? $publisher->user->contact }}" autocomplete="contact" >

                                    @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label">{{ __('Publisher Password') }} </label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') ?? $publisher->user->password }}" required>
                                    <input type="hidden" name="old_password" value="{{$publisher->user->password}}">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="partner_mode" class="col-md-4 col-form-label">{{ __('Parthership Mode') }}</label>

                                <div class="col-md-8">
                                    <select name="partner_mode" id="partner_mode" class="form-control @error('partner_mode') is-invalid @enderror">
                                        <option value="{{$publisher->partner_mode}}">{{$publisher->partner_mode}}</option>
                                        <option value="">--------------</option>
                                        <option value="Percentage">Percentage</option>
                                        <option value="Package">Package</option>
                                    </select>
                                    @error('partner_mode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="parthership_value" class="col-md-4 col-form-label">{{ __('Partnership Mode Value') }}</label>

                                <div class="col-md-8">
                                    <input id="parthership_value" type="text" class="form-control @error('parthership_value') is-invalid @enderror" name="parthership_value" value="{{ old('parthership_value') ?? $publisher->mode_value }}" autocomplete="parthership_value" >

                                    @error('parthership_value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">{{ __(' Description') }}</label>

                                <div class="col-md-8">
                                    <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror"> {!! old('description') ?? $publisher->description !!} </textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}</label>

                                <div class="col-md-8">
                                    <img src="/storage/{{$publisher->user->photo}}" alt="" height="50">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') ?? $publisher->user->photo }}" >
                                    <input type="hidden" name="oldImage" value="{{$publisher->user->photo}}">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="isPinned" class="col-md-5 col-form-label">{{ __('Is Pinned') }}</label>

                                <div class="col-md-7 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios1" type="radio" class="form-check-input" name="isPinned" value="Yes" @if($publisher->isPinned=="Yes") checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios2" type="radio" class="form-check-input" name="isPinned" value="No" @if($publisher->isPinned=="No") checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('isPinned')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>                   --}}

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Publisher Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $publisher->user->status }}" required>
                                        <option value="{{$publisher->user->status}}">{{$publisher->user->status}}</option>
                                        <option value="">---------</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Active">Active</option>
                                    </select>
                                    @error('status')
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

@endsection
