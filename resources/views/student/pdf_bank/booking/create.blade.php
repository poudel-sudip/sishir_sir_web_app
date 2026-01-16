@extends('student.layouts.app')
@section('student-title')
    Enroll eBook
@endsection
@section('student-title-icon')
    <i class="fas fa-file-pdf"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Enroll New eBook') }}</div>

                    <div class="card-body enroll_form">

                        <form method="POST" action="/student/pdf-bank-bookings" enctype="multipart/form-data" id="verifyCourseForm">
                            @if (session('alreadybooked'))
                                <div class="alert alert-danger">
                                    {{ session('alreadybooked') }}
                                </div>
                            @endif
                           
                            @csrf
                            <div class="form-group row">
                                <label for="pdf_bank" class="col-md-4 col-form-label text-md-right">{{ __('eBook') }}</label>

                                <div class="col-md-8">
                                    <select name="pdf_bank" id="pdf_bank" class="enroll-form-control @error('pdf_bank') is-invalid @enderror" value="{{ old('pdf_bank') }}" autofocus required>
                                        <option value="">Select an E-Book...</option>
                                        @foreach($pdfbanks as $row)
                                            <option value="{{$row->id}}"> {{$row->title}} @ Rs. {{$row->price - $row->discount}} </option>
                                        @endforeach
                                    </select>
                                    @error('pdf_bank')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="remarks" class="col-md-4 col-form-label text-md-right">{{ __('Remarks') }}</label>

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
                                    <button type="submit" class="btn btn-primary">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection
