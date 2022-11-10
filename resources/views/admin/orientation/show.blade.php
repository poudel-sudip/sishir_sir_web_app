@extends('admin.layouts.app')
@section('admin-title')
    Free Orientation Class Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Free Orientation Class Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/orientations') }}">Orientations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ucwords($orientation->course)}} </div>
                    <div class="card-body">
                        
                        <div class="course-row">
                            <div>Course : </div>
                            <div>{{ucwords($orientation->course)}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status : </div>
                            <div>{{ucwords($orientation->status)}}</div>
                        </div>
                        <div class="course-row">
                            <div>Date : </div>
                            <div>{{$orientation->date}}</div>
                        </div>
                        <div class="course-row">
                            <div>Time: </div>
                            <div>{{date("g:i a",strtotime($orientation->time))}}</div>
                        </div>
                        <div class="course-row">
                            <div>Join Link : </div>
                            <div>{{$orientation->join_link}}</div>
                        </div>
                        <div class="course-row">
                            <div>Description: </div>
                            <div>{!! $orientation->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Image: </div>
                            <div><img src="/storage/{{$orientation->image}}" alt="" class="img img-fluid" style="max-height:300px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
