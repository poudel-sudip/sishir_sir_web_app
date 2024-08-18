@extends('student.layouts.app')
@section('student-title')
    Add New Message Ticket
@endsection
@section('student-title-icon')
    <i class="fas fa-address-card"></i>
@endsection


@section('content')
    <div class="student-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Add New Message Ticket') }}</div>

                    <div class="card-body enroll_form">

                        <form method="POST" action="/student/tickets" enctype="multipart/form-data" id="verifyCourseForm">
                                                       
                            @csrf
                            
                            <div class="form-group row">
                                <label for="ticket_title" class="col-md-4 col-form-label text-md-right">{{ __('Ticket Title') }}</label>

                                <div class="col-md-8">
                                    <input id="ticket_title" type="text" class="form-control @error('ticket_title') is-invalid @enderror" name="ticket_title" value="{{ old('ticket_title') }}" required >

                                    @error('ticket_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ticket_message" class="col-md-4 col-form-label text-md-right">{{ __('Ticket Message') }}</label>

                                <div class="col-md-8">
                                    {{-- <input id="ticket_message" type="text" class="form-control @error('ticket_message') is-invalid @enderror" name="ticket_message" value="{{ old('ticket_message') }}" required > --}}
                                    <textarea name="ticket_message" id="ticket_message" class="summernote form-control @error('ticket_message') is-invalid @enderror" required>{{ old('ticket_message') }}</textarea>

                                    @error('ticket_message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

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
