@extends('tutors.layouts.app')
@section('tutor-title')
    {{$course->course}} | Tutor Course
@endsection

@section('tutor-title-icon')
    <i class="fas fa-eye"></i>
@endsection

@section('content')
    <div class="content-wrapper tutor-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card student_exam_card">
                    <div class="card-header">{{$course->course}} </div>
                    <div class="card-body">
                        <div class="course-row row">
                            <div class="col-md-3">Course : </div>
                            <div class="col-md-9">{{$course->course}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Fee : </div>
                            <div class="col-md-9">{{$course->fee}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Discount: </div>
                            <div class="col-md-9">{{$course->discount}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Start Date: </div>
                            <div class="col-md-9">{{$course->startDate}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Duration: </div>
                            <div class="col-md-9">{{$course->duration}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Time Slot: </div>
                            <div class="col-md-9">{{$course->timeSlot}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Payment Mode: </div>
                            <div class="col-md-9">{{$course->payMode}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Payment Amount: </div>
                            <div class="col-md-9">{{$course->payAmount}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Status: </div>
                            <div class="col-md-9">{{$course->status}}</div>
                        </div>
                        <div class="course-row row">
                            <div class="col-md-3">Description: </div>
                            <div class="col-md-9">{!! $course->description !!}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
