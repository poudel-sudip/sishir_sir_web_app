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
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$course->name}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Course ID:</div>
                            <div>{{$course->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Name:</div>
                            <div>{{$course->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Slug: </div>
                            <div>{{$course->slug}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Category: </div>
                            <div>{{$course->category->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Description: </div>
                            <div>{!! $course->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Details: </div>
                            <div>{!! $course->detail !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Is Popular: </div>
                            <div>{{$course->isPopular}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Status: </div>
                            <div>{{$course->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Image: </div>
                            <div><img src="/storage/{{$course->image}}" width="200"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
