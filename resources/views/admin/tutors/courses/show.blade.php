@extends('admin.layouts.app')
@section('admin-title')
    Tutors Courses Show
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$tutor->name}} : {{$course->course}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
              <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses">Courses</a></li>
              <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$course->course}} </div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Course : </div>
                            <div>{{$course->course}}</div>
                        </div>
                        <div class="course-row">
                            <div>Fee : </div>
                            <div>{{$course->fee}}</div>
                        </div>
                        <div class="course-row">
                            <div>Discount: </div>
                            <div>{{$course->discount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Start Date: </div>
                            <div>{{$course->startDate}}</div>
                        </div>
                        <div class="course-row">
                            <div>Duration: </div>
                            <div>{{$course->duration}}</div>
                        </div>
                        <div class="course-row">
                            <div>Classroom Link: </div>
                            <div>{{$course->classroomLink}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Mode: </div>
                            <div>{{$course->payMode}}</div>
                        </div>
                        <div class="course-row">
                            <div>Payment Amount: </div>
                            <div>{{$course->payAmount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status: </div>
                            <div>{{$course->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Description: </div>
                            <div>{!! $course->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
