@extends('admin.layouts.app')
@section('admin-title')
    Course Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Course</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/curriculum') }}">Curriculum</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Course Batch Curriculum Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Course:</div>
                            <div>{{$curriculum->batch->course->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch:</div>
                            <div>{{$curriculum->batch->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Curriculum ID: </div>
                            <div>{{$curriculum->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Curriculum Title: </div>
                            <div>{{$curriculum->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Curriculum Is Main Heading: </div>
                            <div>{{$curriculum->is_heading ? 'Yes': 'No'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Curriculum Status: </div>
                            <div>{{$curriculum->status ? 'Active': 'Inactive'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Curriculum Description: </div>
                            <div>{!! $curriculum->description !!}</div>
                        </div>                                              
                        
                        @if($curriculum->pdf_file)
                        <div class="course-row">
                            <div>PDF File: </div>
                            <div>
                                <iframe src="{{$curriculum->pdf_file}}" width="100%" height="500px"></iframe>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
