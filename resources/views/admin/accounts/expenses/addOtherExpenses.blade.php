@extends('admin.layouts.app')
@section('admin-title')
    Add Other Expenses
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Other Expenses</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/expenses') }}">Expenses</a></li>
                    <li class="breadcrumb-item" aria-current="page">Other Expenses</li>

                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <form method="POST" action="/admin/accounts/expenses/others" enctype="multipart/form-data">
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
                                <label for="category" class="col-md-4 col-form-label">{{ __('Expense Category') }}</label>

                                <div class="col-md-8">
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}"  required>
                                        <option value="Misc">Misc</option>
                                        <option value="Withdraw">Withdraw</option>    
                                        @foreach($batches as $batch)
                                        <option value="{{$batch->course->name.' '.$batch->name}}">{{$batch->course->name.' '.$batch->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ledger" class="col-md-4 col-form-label">{{ __('Ledger') }}</label>

                                <div class="col-md-8">
                                    <input id="ledger" type="text" class="form-control @error('ledger') is-invalid @enderror" name="ledger" value="{{ old('ledger') }}"  >

                                    @error('ledger')
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
