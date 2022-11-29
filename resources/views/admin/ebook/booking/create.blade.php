@extends('admin.layouts.app')
@section('admin-title')
    Create E-Book Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create E-Book Booking</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/ebook-bookings') }}">E-Book Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Booking</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Add E-Book Booking</div>
                    <div class="card-body">
                        <form method="POST" action="/admin/ebook-bookings" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="book_name" class="col-md-5 col-form-label">{{ __('Book Name') }}</label>
                                <div class="col-md-7">
                                        <select name="book_name" id="book_name" class="form-control @error('book_name') is-invalid @enderror" value="{{ old('book_name') }}" autofocus required>
                                           <option value="">Choose a Book...</option>
                                            @foreach($books as $book)
                                                <option value="{{$book->id}}"> {{$book->title}} @ Rs. {{$book->price - $book->discount}} </option>
                                            @endforeach
                                    </select>
                                    @error('book_name')
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
                                        <option value="Self">Self</option>
                                        <option value="Connect IPS">Connect IPS</option>
                                        <option value="IME Pay">IME Pay</option>
                                        <option value="Esewa">Esewa</option>
                                        <option value="Khalti">Khalti</option>
                                        <option value="Bank">Bank</option>
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
