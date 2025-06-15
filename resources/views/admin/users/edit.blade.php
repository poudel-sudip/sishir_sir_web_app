@extends('admin.layouts.app')
@section('admin-title')
    Edit User
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit User</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/users') }}">Users</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit User : {{$user->name}}</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/users/{{$user->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">{{ __('User Full Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">{{ __('User Email Address') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email" >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-md-4 col-form-label">{{ __('User Contact No.') }} </label>

                                <div class="col-md-8">
                                    <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') ?? $user->contact }}" required>

                                    @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="provience" class="col-md-4 col-form-label">{{ __('Provience') }}</label>

                                <div class="col-md-8">
                                    <select name="provience" id="provience" class="form-control @error('provience') is-invalid @enderror" value="{{ old('provience') }}" required autocomplete="provience">
                                        <option value="{{ucwords($user->provience)}}">{{ucwords($user->provience)}}</option>
                                        <option value="">---------</option>
                                        @foreach ($proviences as $pro)
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
                                <label for="district_city" class="col-md-4 col-form-label">{{ __('District') }}</label>

                                <div class="col-md-8">
                                    <select name="district_city" id="district_city" class="form-control @error('district_city') is-invalid @enderror" value="{{ old('district_city') }}"  autocomplete="district_city">
                                        <option value="{{ucwords($user->district_city)}}">{{ucwords($user->district_city)}}</option>
                                    </select>
                                    @error('district_city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blood_group" class="col-md-4 col-form-label">{{ __('Blood Group') }}</label>

                                <div class="col-md-8">
                                    <select name="blood_group" id="blood_group" class="form-control @error('blood_group') is-invalid @enderror" value="{{ old('blood_group') }}" required autocomplete="blood_group">
                                        <option value="{{ucwords($user->blood_group)}}">{{ucwords($user->blood_group)}}</option>
                                        <option value="">---------</option>
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
                                <label for="donate_blood" class="col-md-4 col-form-label">{{ __('Can Donate Blood') }}</label>

                                <div class="col-md-8 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="donate_blood_1" type="radio" class="form-check-input" name="donate_blood" value="1" @if($user->donate_blood) checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="donate_blood_0" type="radio" class="form-check-input" name="donate_blood" value="0" @if(!$user->donate_blood) checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('donate_blood')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label">{{ __('User Password') }} </label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') ?? $user->password }}" required>
                                    <input type="hidden" name="old_password" value="{{$user->password}}">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label">{{ __('User Role') }}</label>

                                <div class="col-md-8">
                                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') ?? $user->role }}" required>
                                        <option value="{{$user->role}}">{{$user->role}}</option>
                                        <option value="">---------</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Moderator">Moderator</option>
                                        <option value="Student">Student</option>
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>                       

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('User Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $user->status }}" required>
                                        <option value="{{$user->status}}">{{$user->status}}</option>
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

        $('#provience').on('change',function(){
            var province = $(this).val();
            $("#district_city").html("");
            if(province)
            {
                var cities = proviences[province];
                var op='';
                cities.forEach((city) => {
                    op += '<option value="' + city + '">' + city + '</option>';
                });
                // console.log(op);
                $("#district_city").append(op);
            }
            
        });
        

    </script>

@endsection
