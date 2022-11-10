@extends('admin.layouts.app')
@section('admin-title')
    Show Batch
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Batch</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$batch->name}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Batch ID:</div>
                            <div>{{$batch->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Category Name:</div>
                            <div>{{$batch->course->category->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Name:</div>
                            <div>{{$batch->course->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Name:</div>
                            <div>{{$batch->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Description:</div>
                            <div>{!! $batch->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Fee:</div>
                            <div>Rs.{{$batch->fee}}</div>
                        </div>
                        <div class="course-row">
                            <div>Discount:</div>
                            <div>Rs.{{$batch->discount}}</div>
                        </div>
                        <div class="course-row">
                            <div>Final Fee:</div>
                            <div>Rs.{{($batch->fee)-($batch->discount)}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Duration:</div>
                            <div>{{$batch->duration}} {{$batch->durationType}}</div>
                        </div>
                        <div class="course-row">
                            <div>Start Date:</div>
                            <div>{{$batch->startDate}}</div>
                        </div>
                        <div class="course-row">
                            <div>End Date:</div>
                            <div>{{$batch->endDate}}</div>
                        </div>
                        <div class="course-row">
                            <div>Course Join Link:</div>
                            <div>{{$batch->classroomLink}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Status:</div>
                            <div>{{$batch->status}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
