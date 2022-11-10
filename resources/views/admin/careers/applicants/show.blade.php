@extends('admin.layouts.app')
@section('admin-title')
    Career Application Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Vaccancy Applicant Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/careers') }}">Careers</a></li>
                <li class="breadcrumb-item"><a href="/admin/careers/{{$vaccancy->id}}/applicants">Applications</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="course-row">
                            <div>Vaccancy Title : </div>
                            <div>{{$vaccancy->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Vaccancy Created Date : </div>
                            <div>{{$vaccancy->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Vaccancy Status: </div>
                            <div>{{$vaccancy->status}}</div>
                        </div>
                        <hr>
                        <div class="course-row">
                            <div>Applicant Name: </div>
                            <div>{{$applicant->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Applied Post: </div>
                            <div>{{$applicant->post_name}}</div>
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
                            <div>Qualification: </div>
                            <div>{{$applicant->qualification}}</div>
                        </div>
                        <div class="course-row">
                            <div>Remarks: </div>
                            <div>{{$applicant->remarks}}</div>
                        </div>
                        <div class="course-row">
                            <div>Applicant Photo: </div>
                            <div> <img src="/storage/{{$applicant->photo}}" style="max-height:250px"></div>
                        </div>
                        <div class="course-row">
                            <div>Applicant CV: </div>
                            <div><iframe src="/storage/{{$applicant->cv}}"  frameBorder="0" scrolling="auto" height="600" width="100%"></iframe></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
