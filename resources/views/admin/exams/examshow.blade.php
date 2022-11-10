@extends('admin.layouts.app')
@section('admin-title')
    Exam Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Exam</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exam-category') }}">Exam Categories</a></li>
                <li class="breadcrumb-item"><a href="/admin/exam-category/{{$exam->category->id ?? ''}}/exams">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$exam->name}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Exam ID:</div>
                            <div>{{$exam->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Category:</div>
                            <div>{{$exam->category->title ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Name:</div>
                            <div>{{$exam->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Date: </div>
                            <div>{{$exam->exam_date}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Time: </div>
                            <div>{{$exam->exam_time}} HH:MM</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Description: </div>
                            <div>{!! $exam->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Marks Per Question: </div>
                            <div>{!! $exam->marks_per_question !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Nagative Markings: </div>
                            <div>{{$exam->negative_marks}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Status: </div>
                            <div>{{$exam->status}}</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
