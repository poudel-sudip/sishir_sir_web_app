@extends('vendors.layouts.app')
@section('admin-title')
    Show Applicant Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Applicant Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/vendor/dynamic-forms') }}">Dynamic Forms</a></li>
                <li class="breadcrumb-item"><a href="/vendor/dynamic-forms/{{$category->id}}/applicants">Applicants</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> {{$applicant->name}} | {{$category->name}} | Show Details</div>
                    <div class="card-body">
                        
                        <div class="course-row">
                            <div>Category Course:</div>
                            <div>{{$category->name}}</div>
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
                            <div>Provience: </div>
                            <div>{{$applicant->provience}}</div>
                        </div>
                        <div class="course-row">
                            <div>District: </div>
                            <div>{{$applicant->district}}</div>
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
                        <hr>
                        @if(isset($applicant->photo))
                        <div class="course-row">
                            <div>Photo: </div>
                            <div> <img src="/storage/{{$applicant->photo}}" alt="" class="img img-fluid" style="max-height:150px"> </div>
                        </div>
                        @endif

                        @if(isset($applicant->file))
                        <div class="course-row">
                            <div>Attached File: </div>
                            <div> <iframe src="/storage/{{$applicant->file}}" alt="" class="w-100" style="max-height:500px"> </iframe> </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center h4">Add Remarks</div>
                        <form method="POST" action="/vendor/dynamic-forms/{{$category->id}}/applicants/{{$applicant->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="course" class="col-md-3 col-form-label">{{ __('Remarks') }} </label>
                                
                                <div class="col-md-9">
                                    <input type="text" id="remarks" name="remarks" class="form-control @error('remarks') is-invalid @enderror" value="{{old('remarks')}}" required>
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
