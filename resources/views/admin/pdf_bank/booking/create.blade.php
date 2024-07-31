@extends('admin.layouts.app')
@section('admin-title')
    Create PDF Bank Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create PDF Bank Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank-bookings') }}">PDF Bank Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Booking</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add PDF Bank Booking</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/pdf-bank-bookings" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="group_name" class="col-md-5 col-form-label">{{ __('PDF Bank Group') }}</label>
                                <div class="col-md-7">
                                        <select name="group_name" id="group_name" class="form-control @error('group_name') is-invalid @enderror" value="{{ old('group_name') }}" autofocus required>
                                           <option value="">Choose a PDF Bank ...</option>
                                            @foreach($groups as $row)
                                                <option value="{{$row->id}}"> {{$row->title}} @ Rs. {{$row->price - $row->discount}} </option>
                                            @endforeach
                                    </select>
                                    @error('group_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="userid" class="col-md-5 col-form-label">{{ __('User ID') }}</label>

                                <div class="col-md-7">
                                    <input id="userid" type="text" class="form-control @error('userid') is-invalid @enderror" name="userid" value="{{ old('userid') }}" required>

                                    @error('userid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verificationMode" class="col-md-5 col-form-label">{{ __('Verification Mode') }}</label>

                                <div class="col-md-7">
                                    <select name="verificationMode" id="verificationMode" class="form-control @error('verificationMode') is-invalid @enderror" value="{{ old('verificationMode') }}"  required>
                                        <option value="Cash">Cash</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="Fonepay">Fonepay</option>
                                        <option value="NepalPayment">NepalPayment</option>
                                        <option value="Bank">Bank</option>

                                        {{-- <option value="Cash">Cash</option>
                                        <option value="Connect IPS">Connect IPS</option>
                                        <option value="IME Pay">IME Pay</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="Khalti">Khalti</option>
                                        <option value="Bank">Bank</option> --}}
                                    </select>
                                    @error('verificationMode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="paymentAmount" class="col-md-5 col-form-label ">{{ __('Payment Amount') }}</label>

                                <div class="col-md-7">
                                    <input id="paymentAmount" type="text" class="form-control @error('paymentAmount') is-invalid @enderror" name="paymentAmount" value="{{ old('paymentAmount') ?? 0 }}" required >

                                    @error('paymentAmount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-5 col-form-label ">{{ __('Discount') }}</label>

                                <div class="col-md-7">
                                    <input id="discount" type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? 0 }}" required >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="verificationDocument" class="col-md-5 col-form-label">{{ __('Verification Document Photo') }} </label>

                                <div class="col-md-7">
                                    <input id="verificationDocument" type="file" class="form-control @error('verificationDocument') is-invalid @enderror" name="verificationDocument" value="{{ old('verificationDocument') }}" >

                                    @error('verificationDocument')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarks" class="col-md-5 col-form-label">{{ __('Booking Remarks') }} </label>

                                <div class="col-md-7">
                                    <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" >

                                    @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-5 col-form-label">{{ __('Booking Status') }}</label>

                                <div class="col-md-7">
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') }}"  required>
                                        <option value="Unverified">Unverified</option>
                                        <option value="Verified">Verified</option>
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



    </script>

@endsection
