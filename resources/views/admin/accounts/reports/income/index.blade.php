@extends('admin.layouts.app')
@section('admin-title')
   Income Account Reports Index
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Income Account Reports</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Incomes</li>

                </ol>
            </nav>
        </div>
        <div class="row reports">

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Course Income Report </h4>
                        <form action="/admin/accounts/reports/incomes/course" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <select id="course" class="form-control @error('course') is-invalid @enderror" name="course" required>
                                        @foreach($batches as $batch)
                                            <option value="{{$batch->course->name.' '.$batch->name}}">{{$batch->course->name.' '.$batch->name}}</option>
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
                                    <button type="submit" class="btn btn-info">
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
                        <h4 class="card-title"> Other Income Report </h4>
                        <a href="/admin/accounts/reports/incomes/others" class="btn btn-info">Generate</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Daily Income Report </h4>
                        <form action="/admin/accounts/reports/incomes/daily" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="text" id="dailydate" class="form-control @error('dailydate') is-invalid @enderror" name="dailydate" placeholder="Date format as: 2021-01-01" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>
                                    @error('dailydate')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-info">
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
                        <h4 class="card-title"> Monthly Income Report </h4>
                        <form action="/admin/accounts/reports/incomes/monthly" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="text" id="monthlydate" class="form-control @error('monthlydate') is-invalid @enderror" name="monthlydate" placeholder="Date format as: 2021-01" pattern="[0-9]{4}-[0-9]{2}" required>
                                    @error('monthlydate')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-info">
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
                        <h4 class="card-title"> Deleted Income Report </h4>
                        <a href="/admin/accounts/reports/incomes/deleted" class="btn btn-info">Generate</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
