@extends('admin.layouts.app')
@section('admin-title')
    Update EPS Registration
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Update EPS Registration</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update EPS Registration</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title"> Update EPS Registration</h4>
                    </div>
                    <form method="POST" action="/admin/eps-registration/{{$korea->id}}" enctype="multipart/form-data">
                        @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="eps-id" class="col-md-4 col-form-label">{{ __('EPS Registration ID') }}</label>

                                <div class="col-md-8">
                                    <input id="eps-id" type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ old('id') ?? $korea->id }}" readonly>

                                </div>
                            </div>
                        

                        <div class="form-group row">
                            <label for="fname" class="col-md-4 col-form-label">{{ __('Full Name') }}</label>

                            <div class="col-md-8">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') ?? $korea->fname }}" readonly >

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobileNo" class="col-md-4 col-form-label">{{ __('Contact No.') }}</label>

                            <div class="col-md-8">
                                <input id="mobileNo" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') ?? $korea->mobile }}" readonly>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $korea->email }}" readonly >

                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="sector" class="col-md-4 col-form-label">{{ __('Sector') }}</label>

                            <div class="col-md-8">
                                <input id="sector" type="text" class="form-control @error('sector') is-invalid @enderror" name="sector" value="{{ old('sector') ?? $korea->sector }}" readonly>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subsector" class="col-md-4 col-form-label">{{ __('Sub Sector') }}</label>

                            <div class="col-md-8">
                                <input id="subsector" type="text" class="form-control @error('subsector') is-invalid @enderror" name="subsector" value="{{ old('subsector') ?? $korea->subsector }}" readonly>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="photo" class="col-md-12 col-form-label">{{ __('Photo') }}</label>
    
                                <div class="col-md-12">
                                    <a href="/storage/{{$korea->photo}}" target="_blank">
                                        <img src="/storage/{{$korea->photo}}" class="w-100 img img-responsive">
                                    </a>
                                </div>
                            </div>
    
                            <div class="form-group col-md-5">
                                <label for="passport" class="col-md-12 col-form-label">{{ __('Passport') }}</label>
    
                                <div class="col-md-12">
                                    <a href="/storage/{{$korea->passport}}" target="_blank">
                                        <img src="/storage/{{$korea->passport}}" class="w-100 img img-responsive">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="payment_slip" class="col-md-12 col-form-label">{{ __('Payment 
                                Slip') }}</label>
    
                                <div class="col-md-12">
                                    <a href="/storage/{{$korea->payment_slip}}" target="_blank">
                                        <img src="/storage/{{$korea->payment_slip}}" class="w-100 img img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label">{{ __('Registered Status') }}</label>

                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') ?? $korea->status }}"  required>
                                    <option value="{{$korea->status}}">{{$korea->status}}</option>
                                    <option value="Unregistered">Unregistered</option>
                                    <option value="Registered">Registered</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="remarks" class="col-md-4 col-form-label">{{ __('Remarks') }}</label>

                            <div class="col-md-8">
                                <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') ?? $korea->remarks }}" >

                                @error('remarks')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection