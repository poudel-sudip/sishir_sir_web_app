@extends('admin.layouts.app')
@section('admin-title')
    Edit Vendor
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Vendor</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/vendor">Vendors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
              </ol>
          </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">Edit Vendor: {{ $vendor->name }}</div>

                    <div class="card-body">
                        <form method="POST" action="/admin/vendor/{{$vendor->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">{{ __('Vendor Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $vendor->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $vendor->user->email }}" autocomplete="email" >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact" class="col-md-4 col-form-label">{{ __('Contact No') }}</label>

                                <div class="col-md-8">
                                    <input id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') ?? $vendor->user->contact }}" autocomplete="contact" >

                                    @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="coverage_type" class="col-md-4 col-form-label">{{ __('Area Coverage Type') }}</label>

                                <div class="col-md-8">
                                    <select id="coverage_type" class="form-control @error('coverage_type') is-invalid @enderror" name="coverage_type" value="{{ old('coverage_type') ?? $vendor->coverage_type}}" required onchange="getCoverageArea()">
                                        <option value="{{$vendor->coverage_type}}">{{ucwords($vendor->coverage_type)}}</option>
                                        <option value="">---------</option>
                                        <option value="provience">Provience</option>
                                        <option value="district">District</option>
                                    </select>
                                    @error('coverage_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="provienceArea" class="form-group row @if($vendor->coverage_type=='district') d-none @endif">
                                <label for="provience" class="col-md-4 col-form-label">{{ __('Coverage Proviences') }}</label>

                                <div class="col-md-8">
                                    <select id="provience" class="form-control @error('provience') is-invalid @enderror" name="provience[]" multiple >
                                        @php($prov=array_map("trim",explode(",",$vendor->provience)))
                                        @foreach($proviences as $pro)
                                            <option value="{{$pro->name}}" @if(in_array($pro->name,$prov)) selected @endif >{{$pro->name}}</option>                                                
                                        @endforeach
                                    </select>
                                    @error('provience')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="districtArea" class="form-group row @if($vendor->coverage_type=='provience') d-none @endif">
                                <label for="district" class="col-md-4 col-form-label">{{ __('Coverage Districts/Cities') }}</label>

                                <div class="col-md-8">
                                    <select id="district" class="form-control @error('district') is-invalid @enderror" name="district[]" size="10" multiple >
                                        @php($disarr=array_map("trim",explode(",",$vendor->district_city)))
                                        @foreach($districts as $dis)
                                            <option value="{{$dis->name}}" @if(in_array($dis->name,$disarr)) selected @endif >{{$dis->name}}</option>                                                
                                        @endforeach
                                    </select>
                                    @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label">{{ __('Vendor Password') }} </label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') ?? $vendor->user->password }}" required>
                                    <input type="hidden" name="old_password" value="{{$vendor->user->password}}">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-md-4 col-form-label">{{ __('Vendor Discount(%)') }}</label>

                                <div class="col-md-8">
                                    <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') ?? $vendor->vendor_discount ?? 0 }}" autocomplete="discount" >

                                    @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">{{ __(' Description') }}</label>

                                <div class="col-md-8">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') ?? $vendor->description }}"  autocomplete="description" >

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}</label>

                                <div class="col-md-8">
                                    <img src="/storage/{{$vendor->user->photo}}" alt="" height="50">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') ?? $vendor->user->photo }}" >
                                    <input type="hidden" name="oldImage" value="{{$vendor->user->photo}}">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isPinned" class="col-md-5 col-form-label">{{ __('Is Pinned') }}</label>

                                <div class="col-md-7 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios1" type="radio" class="form-check-input" name="isPinned" value="Yes" @if($vendor->isPinned=="Yes") checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="membershipRadios2" type="radio" class="form-check-input" name="isPinned" value="No" @if($vendor->isPinned=="No") checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('isPinned')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_access" class="col-md-5 col-form-label">{{ __('Access To Users') }}</label>

                                <div class="col-md-7 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="" type="radio" class="form-check-input" name="user_access" value="Yes" @if($vendor->user_access=="Yes") checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="" type="radio" class="form-check-input" name="user_access" value="No" @if($vendor->user_access=="No") checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('user_access')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="enquiry_access" class="col-md-5 col-form-label">{{ __('Access To Enquiries/Followup') }}</label>

                                <div class="col-md-7 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="" type="radio" class="form-check-input" name="enquiry_access" value="Yes" @if($vendor->enquiry_access=="Yes") checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="" type="radio" class="form-check-input" name="enquiry_access" value="No" @if($vendor->enquiry_access=="No") checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('enquiry_access')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="manual_booking_access" class="col-md-5 col-form-label">{{ __('Access To Manual Bookings') }}</label>

                                <div class="col-md-7 row">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="" type="radio" class="form-check-input" name="manual_booking_access" value="Yes" @if($vendor->manual_booking_access=="Yes") checked @endif >Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input id="" type="radio" class="form-check-input" name="manual_booking_access" value="No" @if($vendor->manual_booking_access=="No") checked @endif>No</label>
                                        </div>
                                    </div>
                                    @error('manual_booking_access')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Vendor Status') }}</label>

                                <div class="col-md-8">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') ?? $vendor->user->status }}" required>
                                        <option value="{{$vendor->user->status}}">{{$vendor->user->status}}</option>
                                        <option value="">---------</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Active">Active</option>
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
        function getCoverageArea()
        {
            var type = $('#coverage_type').find(":selected").val();
            if(type == "provience")
            {
                $('#provienceArea').removeClass('d-none');
                $('#districtArea').addClass('d-none');
            }
            else if(type == "district")
            {
                $('#provienceArea').addClass('d-none');
                $('#districtArea').removeClass('d-none');
            }
            else
            {
                $('#provienceArea').addClass('d-none');
                $('#districtArea').addClass('d-none');
            }
        }
    </script>

@endsection
