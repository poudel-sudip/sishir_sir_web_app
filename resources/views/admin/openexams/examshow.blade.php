@extends('admin.layouts.app')
@section('admin-title')
    Open Exam Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Open Exam</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/open-exams') }}">Open Exams</a></li>
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
                            <div>{{ucwords($exam->exam->category->title ?? '')}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Name:</div>
                            <div>{{$exam->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Slug: </div>
                            <div>{{$exam->slug}}</div>
                        </div>
                        <div class="course-row">
                            <div>Exam Time: </div>
                            <div>{{$exam->exam->exam_time ?? '00:00'}} HH:MM</div>
                        </div>
                        
                        <div class="course-row">
                            <div>Marks Per Question: </div>
                            <div>{!! $exam->exam->marks_per_question ?? '1' !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Nagative Markings: </div>
                            <div>{{$exam->exam->negative_marks ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Result Status: </div>
                            <div>{{$exam->result_status}}</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
