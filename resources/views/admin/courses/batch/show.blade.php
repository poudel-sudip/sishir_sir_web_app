@extends('admin.layouts.app')
@section('admin-title')
    Show Batch
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Batch Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses/'.$course->id.'/batches') }}">Batches</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Batch Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Batch ID:</div>
                            <div>{{$batch->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Name:</div>
                            <div>{{$batch->name}}</div>
                        </div>                        
                        <div class="course-row">
                            <div>Course Name:</div>
                            <div>{{optional($batch->course)->name}}</div>
                        </div>                        
                        <div class="course-row">
                            <div>Batch Description:</div>
                            <div>{!! $batch->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div> Fee:</div>
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
                            <div> Duration:</div>
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
                            <div> Join Link:</div>
                            <div>{{$batch->classroomLink}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Status:</div>
                            <div>{{$batch->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Image:</div>
                            <div><img src="/storage/{{$batch->image}}" alt="" class="img img-fluid" style="max-height:150px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
