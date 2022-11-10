@extends('admin.layouts.app')
@section('admin-title')
    Add Tutor Salary
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Tutor Salary</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/expenses') }}">Expenses</a></li>
                    <li class="breadcrumb-item" aria-current="page">Tutor Salary</li>

                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form method="POST" action="/admin/accounts/expenses/tutor" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label">{{ __('Date') }}</label>

                                <div class="col-md-8">
                                    <input id="date" type="datetime-local" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" >

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="course_name" class="col-md-4 col-form-label">{{ __('Course Name') }}</label>
                                <div class="col-md-8">
                                        <select name="course_name" id="course_name" class="form-control @error('course_name') is-invalid @enderror" value="{{ old('course_name') }}" autofocus required>
                                           <option value="">Select a Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->name}}" slug="{{$course->slug}}"> {{$course->name}} </option>
                                            @endforeach
                                    </select>
                                    @error('course_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="batch_name" class="col-md-4 col-form-label">{{ __('Batch Name') }}</label>

                                <div class="col-md-8">
                                        <select name="batch_name" id="batch_name" class="form-control @error('batch_name') is-invalid @enderror" value="{{ old('batch_name') }}"  required> </select>
                                    @error('batch_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="userid" class="col-md-4 col-form-label">{{ __('Tutor ID') }}</label>

                                <div class="col-md-8">
                                    <input id="userid" type="text" class="form-control @error('userid') is-invalid @enderror" name="userid" value="{{ old('userid') }}" >

                                    @error('userid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workingTime" class="col-md-4 col-form-label">{{ __('Working Time') }}</label>

                                <div class="col-md-8">
                                    <input id="workingTime" type="text" class="form-control @error('workingTime') is-invalid @enderror" name="workingTime" value="{{ old('workingTime') }}" placeholder="1 Day 1 Hour 1 Minutes" >

                                    @error('workingTime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label">{{ __('Amount (Rs)') }}</label>

                                <div class="col-md-8">
                                    <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required >

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label">{{ __('Discount (Rs)') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') }}"  >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fromacc" class="col-md-4 col-form-label">{{ __('From Account') }}</label>

                                <div class="col-md-8">
                                    <select name="fromacc" id="fromacc" class="form-control @error('fromacc') is-invalid @enderror" value="{{ old('fromacc') }}"  required>
                                        <option value="Cash">Cash</option>
                                        <option value="Connect IPS">Connect IPS</option>
                                        <option value="IME Pay">IME Pay</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="Khalti">Khalti</option>
                                        <option value="Global Bank">Global Bank</option>
                                        <option value="Mega Bank">Mega Bank</option>
                                    </select>
                                    @error('fromacc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="toacc" class="col-md-4 col-form-label">{{ __('To Account') }}</label>

                                <div class="col-md-8">
                                    <select name="toacc" id="toacc" class="form-control @error('toacc') is-invalid @enderror" value="{{ old('toacc') }}"  required>
                                        <option value="Cash">Cash</option>
                                        <option value="Connect IPS">Connect IPS</option>
                                        <option value="IME Pay">IME Pay</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="Khalti">Khalti</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                    @error('toacc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verifiedby" class="col-md-4 col-form-label">{{ __('Verified By') }}</label>

                                <div class="col-md-8">
                                    <select name="verifiedby" id="verifiedby" class="form-control @error('verifiedby') is-invalid @enderror" value="{{ old('verifiedby') }}"  required>
                                        <option value="Kamal Sir">Kamal Sir</option>
                                        <option value="Husain Sir">Husain Sir</option>    
                                    </select>
                                    @error('verifiedby')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarks" class="col-md-4 col-form-label">{{ __('Remarks') }}</label>

                                <div class="col-md-8">
                                    <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" >

                                    @error('remarks')
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
