@extends('admin.layouts.app')
@section('admin-title')
    User Reports
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">User Reports</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Reports</li>
            </ol>
        </nav>
    </div>
    <div class="row reports">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All User Reports</h4>
                <ul class="list-ticked">
                    <li>User Reports <a href="/admin/reports/user/all" class="btn btn-warning">Generate</a></li>
                </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filter Users by Courses</h4>
                    <form action="/admin/reports/user/filterbycourse" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="course" class="col-md-4 col-form-label">{{ __('Course') }} </label>

                            <div class="col-md-8">
                                <select id="course" class="form-control @error('course') is-invalid @enderror" name="course" required>
                                    @foreach($courses as $course)
                                        <option value="{{$course->name}}">{{$course->name}}</option>
                                    @endforeach
                                </select>

                                @error('course')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filter Users by Created Date</h4>
                    <form action="/admin/reports/user/filterbydate" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="createdStart" class="col-md-4 col-form-label">{{ __('Start Date') }} </label>

                            <div class="col-md-8">
                                <input id="createdStart" type="date" class="form-control @error('createdStart') is-invalid @enderror" name="createdStart" required>

                                @error('createdStart')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="createdEnd" class="col-md-4 col-form-label">{{ __('End Date') }} </label>

                            <div class="col-md-8">
                                <input id="createdEnd" type="date" class="form-control @error('createdEnd') is-invalid @enderror" name="createdEnd" required>

                                @error('createdEnd')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filter Users by District/City</h4>
                    <form action="/admin/reports/user/filterbydistrict" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="district" class="col-md-4 col-form-label">{{ __('District/City') }} </label>

                            <div class="col-md-8">
                                {{-- <input id="district" type="string" class="form-control @error('district') is-invalid @enderror" name="district" required> --}}
                                <select id="district" class="form-control @error('district') is-invalid @enderror" name="district" required>
                                    @foreach($cities as $city)
                                        <option value="{{$city->name}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filter Users by Provience</h4>
                    <form action="/admin/reports/user/filterbyprovience" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="provience" class="col-md-4 col-form-label">{{ __('Provience') }} </label>

                            <div class="col-md-8">
                                <select id="provience" class="form-control @error('provience') is-invalid @enderror" name="provience" required>
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
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Generate') }}
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
