@extends('admin.layouts.app')
@section('admin-title')
    Show Applicant Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Applicant Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/dynamic-forms') }}">Forms</a></li>
                <li class="breadcrumb-item"><a href="/admin/dynamic-forms/{{$vform->id}}/applicants">Applicants</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> {{ucwords($applicant->name)}} | {{ucwords($vform->title)}} | Show Details</div>
                    <div class="card-body">
                        
                        <div class="course-row">
                            <div>Form Title:</div>
                            <div>{{ucwords($vform->title)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Sub Category Course:</div>
                            <div>{{$applicant->sub_category}}</div>
                        </div>
                        <hr>
                        <div class="course-row">
                            <div>ID : </div>
                            <div>{{$applicant->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Date: </div>
                            <div>{{$applicant->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Name: </div>
                            <div>{{$applicant->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email: </div>
                            <div>{{$applicant->email}}</div>
                        </div>
                        <div class="course-row">
                            <div>Contact No: </div>
                            <div>{{$applicant->contact}}</div>
                        </div>                        
                        <div class="course-row">
                            <div>Message: </div>
                            <div>{{$applicant->message}}</div>
                        </div>
                        <hr>
                        <div class="course-row">
                            <div>Remarks: </div>
                            <div>{{$applicant->remarks}}</div>
                        </div>
                        <div class="course-row">
                            <div>Uploaded By: </div>
                            <div>{{$applicant->uploaded_by}}</div>
                        </div>                    
                        
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center h4">Add Data</div>
                        <form method="POST" action="/admin/dynamic-forms/{{$vform->id}}/applicants/{{$applicant->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="sub_category" class="col-md-3 col-form-label">{{ __('Sub Category') }} </label>
                                
                                <div class="col-md-9">
                                    <input type="text" id="sub_category" name="sub_category" class="form-control @error('sub_category') is-invalid @enderror" value="{{old('sub_category')}}">
                                    @error('sub_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="message" class="col-md-3 col-form-label">{{ __('Message') }} </label>
                                
                                <div class="col-md-9">
                                    <input type="text" id="message" name="message" class="form-control @error('message') is-invalid @enderror" value="{{old('message')}}">
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarks" class="col-md-3 col-form-label">{{ __('Remarks') }} </label>
                                
                                <div class="col-md-9">
                                    <input type="text" id="remarks" name="remarks" class="form-control @error('remarks') is-invalid @enderror" value="{{old('remarks')}}">
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
