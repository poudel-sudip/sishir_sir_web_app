@extends('admin.layouts.app')
@section('admin-title')
   Expense Account Reports Index
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Expense Account Reports</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Expenses</li>

                </ol>
            </nav>
        </div>
        <div class="row reports">

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Tutor Expense Report </h4>
                        <form action="/admin/accounts/reports/expenses/tutor" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <select id="tutor" class="form-control @error('tutor') is-invalid @enderror" name="tutor" required>
                                        @foreach($tutors as $tutor)
                                            <option value="{{$tutor->name}}">{{$tutor->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('tutor')
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
                        <h4 class="card-title"> Course Expense Report </h4>
                        <form action="/admin/accounts/reports/expenses/course" method="post" enctype="multipart/form-data">
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
                        <h4 class="card-title"> Staff Expense Report </h4>
                        <form action="/admin/accounts/reports/expenses/staff" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="text" id="staff" class="form-control @error('staff') is-invalid @enderror" name="staff" placeholder="Full Staff Name as: Sudip Poudel"  required>
                                    @error('staff')
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
                        <h4 class="card-title"> Other Expense Report </h4>
                        <a href="/admin/accounts/reports/expenses/others" class="btn btn-info">Generate</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Daily Expense Report </h4>
                        <form action="/admin/accounts/reports/expenses/daily" method="post" enctype="multipart/form-data">
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
                        <h4 class="card-title"> Monthly Expense Report </h4>
                        <form action="/admin/accounts/reports/expenses/monthly" method="post" enctype="multipart/form-data">
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
                        <h4 class="card-title"> Deleted Expense Report </h4>
                        <a href="/admin/accounts/reports/expenses/deleted" class="btn btn-info">Generate</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
