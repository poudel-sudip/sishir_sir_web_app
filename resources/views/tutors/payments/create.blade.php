@extends('tutors.layouts.app')
@section('tutor-title')
    Create New Payment Request
@endsection
@section('tutor-title-icon')
    <i class="fas fa-plus"></i>
@endsection

@section('content')
<div class="tutor-content-wrapper"> 
    <div class="row">
        <div class="col-12 my-3">
            <div class="card">
                <div class="card-body">
                <h5>Payment Requests for :  {{$course->course}}</h5>
                    <form action="/tutor/payment-requests" method="post" class="mt-3">
                        @csrf
                        <div class="form-group row">
                            <label for="course" class="col-md-5 col-form-label">{{ __('Course ID') }}</label>

                            <div class="col-md-7">
                                <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') ?? $course->id }}" required readonly>

                                @error('course')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="totalAmount" class="col-md-5 col-form-label">{{ __('Total Course Pay Amount') }}</label>

                            <div class="col-md-7">
                                <input id="totalAmount" type="text" class="form-control @error('totalAmount') is-invalid @enderror" name="totalAmount" value="{{ old('totalAmount') ?? $totalPayAmount }}" required readonly>

                                @error('totalAmount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="paidAmount" class="col-md-5 col-form-label">{{ __('Paid Amount') }}</label>

                            <div class="col-md-7">
                                <input id="paidAmount" type="text" class="form-control @error('paidAmount') is-invalid @enderror" name="paidAmount" value="{{ old('paidAmount') ?? $paidAmount }}" required readonly>

                                @error('paidAmount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remainingAmount" class="col-md-5 col-form-label">{{ __('Remaining Amount') }}</label>

                            <div class="col-md-7">
                                <input id="remainingAmount" type="text" class="form-control @error('remainingAmount') is-invalid @enderror" name="remainingAmount" value="{{ old('remainingAmount') ?? ($totalPayAmount-$paidAmount) }}" required readonly>

                                @error('remainingAmount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="requestAmount" class="col-md-5 col-form-label">{{ __('Request Amount') }}</label>

                            <div class="col-md-7">
                                <input id="requestAmount" type="text" class="form-control @error('requestAmount') is-invalid @enderror" name="requestAmount" value="{{ old('requestAmount')  }}" required >

                                @error('requestAmount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remarks" class="col-md-5 col-form-label">{{ __('Remarks') }}</label>

                            <div class="col-md-7">
                                <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks')  }}"  >

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
