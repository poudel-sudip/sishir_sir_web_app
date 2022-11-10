@extends('admin.layouts.app')
@section('admin-title')
    Assign Team Member
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Assign Team Member</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/dynamic-forms/categories') }}">Form Categories</a></li>
                <li class="breadcrumb-item"><a href="/admin/dynamic-forms/categories/{{$category->id}}/team-assign">Team Assigns</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Assign Team | {{$category->name}}</div>
                    <div class="card-body">
                    <form class="forms-sample" method="POST" action="/admin/dynamic-forms/categories/{{$category->id}}/team-assign" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="sub_category" class="col-sm-4 col-form-label">{{ __('Sub Category') }}</label>
                            <div class="col-md-8">
                                <input id="sub_category" type="text" class="form-control @error('sub_category') is-invalid @enderror" name="sub_category" value="{{ old('sub_category') }}" autocomplete="name" autofocus>
                               
                                @error('sub_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team" class="col-sm-4 col-form-label">{{ __('Team Member') }}</label>
                            <div class="col-md-8">
                                <select name="team" id="team" class="form-control @error('team') is-invalid @enderror" required>
                                    <option value="">Select a Team Member</option>
                                    @foreach($teams as $team)
                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                    @endforeach
                                </select>

                                @error('team')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_id" class="col-sm-4 col-form-label">{{ __('Starting ID') }}</label>
                            <div class="col-md-8">
                                <input id="start_id" type="text" class="form-control @error('start_id') is-invalid @enderror" name="start_id" value="{{ old('start_id') }}" autocomplete="name" required autofocus>
                               
                                @error('start_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_id" class="col-sm-4 col-form-label">{{ __('Ending ID') }}</label>
                            <div class="col-md-8">
                                <input id="end_id" type="text" class="form-control @error('end_id') is-invalid @enderror" name="end_id" value="{{ old('end_id') }}" autocomplete="name" required autofocus>
                               
                                @error('end_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
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
