@extends('admin.layouts.app')
@section('admin-title')
   Booking Reports
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">All Booking Reports</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Booking Reports</li>
            </ol>
        </nav>
    </div> 
    <div class="row reports">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daily Bookings Report</h4>
                    <form action="/admin/reports/booking/daily" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="year_for_daily_booking" class="col-md-4 col-form-label">{{ __('Year') }}</label>

                            <div class="col-md-8">
                                <input id="year_for_daily_booking" type="number" class="form-control @error('year_for_daily_booking') is-invalid @enderror" name="year_for_daily_booking" value="{{ old('year_for_daily_booking') }}" required>

                                @error('year_for_daily_booking')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="month_for_daily_booking" class="col-md-4 col-form-label">{{ __('Month') }}</label>

                            <div class="col-md-8">
                                <input id="month_for_daily_booking" type="number" class="form-control @error('month_for_daily_booking') is-invalid @enderror" name="month_for_daily_booking" value="{{ old('month_for_daily_booking') }}" required>

                                @error('month_for_daily_booking')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="day_for_daily_booking" class="col-md-4 col-form-label">{{ __('Day') }}</label>

                            <div class="col-md-8">
                                <input id="day_for_daily_booking" type="number" class="form-control @error('day_for_daily_booking') is-invalid @enderror" name="day_for_daily_booking" value="{{ old('day_for_daily_booking') }}" required>

                                @error('day_for_daily_booking')
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
                    <h4 class="card-title">Monthly Bookings Report</h4>
                    <form action="/admin/reports/booking/monthly" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="year_for_monthly_booking" class="col-md-4 col-form-label">{{ __('Year') }}</label>

                            <div class="col-md-8">
                                <input id="year_for_monthly_booking" type="number" class="form-control @error('year_for_monthly_booking') is-invalid @enderror" name="year_for_monthly_booking" value="{{ old('year_for_monthly_booking') }}" required>

                                @error('year_for_monthly_booking')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="month_for_monthly_booking" class="col-md-4 col-form-label">{{ __('Month') }}</label>

                            <div class="col-md-8">
                                <input id="month_for_monthly_booking" type="number" class="form-control @error('month_for_monthly_booking') is-invalid @enderror" name="month_for_monthly_booking" value="{{ old('month_for_monthly_booking') }}" required>

                                @error('month_for_monthly_booking')
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
                    <h4 class="card-title">Yearly Bookings Reportt</h4>
                    <form action="/admin/reports/booking/yearly" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="year_for_yearly_booking" class="col-md-4 col-form-label">{{ __('Year') }}</label>

                            <div class="col-md-8">
                                <input id="year_for_yearly_booking" type="number" class="form-control @error('year_for_yearly_booking') is-invalid @enderror" name="year_for_yearly_booking" value="{{ old('year_for_yearly_booking') }}" required>

                                @error('year_for_yearly_booking')
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
                    <h4 class="card-title">All Bookings Report</h4>
                <ul class="list-ticked">
                    <li>Bookings Report<a href="/admin/reports/booking/all" class="btn btn-warning">Generate</a></li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
