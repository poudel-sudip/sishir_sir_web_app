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
            <div class="col-md-8 grid-margin stretch-card">
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
                                        @if(auth()->user()->permission>=50)
                                        <option value="">---------</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Student">Student</option>
                                        @endif
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permission" class="col-md-4 col-form-label">{{ __('Admin Permission Level') }}</label>

                                <div class="col-md-8">
                                    <select id="permission" class="form-control @error('permission') is-invalid @enderror" name="permission" value="{{ old('permission') ?? $user->permission }}" required>
                                        <option value="{{$user->permission}}">
                                            @if($user->permission==10)
                                                {{ 'Sales' }}
                                            @elseif($user->permission==20)
                                                {{ 'Technical' }}
                                            @elseif($user->permission==30)
                                                {{ 'Communication' }}
                                            @elseif($user->permission==40)
                                                {{ 'Account' }}
                                            @elseif($user->permission==50)
                                                {{ 'Admin' }}
                                            @endif
                                        </option>
                                        @if(auth()->user()->permission>=50)
                                        <option value="">---------</option>
                                        <option value="50">Admin</option>
                                        <option value="40">Account</option>
                                        <option value="30">Communication</option>
                                        <option value="20">Technical</option>
                                        <option value="10">Sales</option>
                                        @endif
                                    </select>
                                    @error('permission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interests" class="col-md-4 col-form-label">{{ __('Select your Courses') }}</label>

                                <div class="col-md-8">
                                    <textarea class="col-12 form-control text-wrap" name="old_interests" readonly>{{$user->interests}}</textarea>
                                    <input id="interests" type="text" class="col-12 form-control @error('interests') is-invalid @enderror" name="interests" value=" " readonly>
                                    <div class="interest-form-group col-12 row">
                                        <select class="form-control col-8" id="courses">

                                            @foreach($courses as $course)
                                                <option value="{{$course->name}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                        <button class="ml-3 btn btn-primary btn-sm" onclick="javascript:courseadd()" type="button" >+</button>
                                    </div>
                                    @error('interests')
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
        function courseadd()
        {
            var current= $('#courses').find(":selected").val();
            var previous=$('#interests').val();
            var final=previous;
            if(current){
                final =current + ', ' + previous ;
                $("#interests").val(final);
            }
            $("#courses").val('');
        }
    </script>

@endsection
