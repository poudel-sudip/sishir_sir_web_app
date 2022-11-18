@extends('admin.layouts.app')
@section('admin-title')
    Show Feature
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Feature</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="/admin/courses/{{$feature->course->id}}/features">Features</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$feature->title}}</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Feature ID:</div>
                            <div>{{$feature->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Name:</div>
                            <div>{{$feature->course->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Feature Title:</div>
                            <div>{{$feature->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Feature Description:</div>
                            <div>{!! $feature->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Feature Icon:</div>
                            <div><img src="/storage/{{$feature->image}}" width="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
