@extends('admin.layouts.app')
@section('admin-title')
    Career Vaccancy Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Career Vaccancy Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/careers') }}">Careers</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$vaccancy->title}} </div>
                    <div class="card-body">
                        
                        <div class="course-row">
                            <div>Title : </div>
                            <div>{{$vaccancy->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Created Date : </div>
                            <div>{{$vaccancy->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status: </div>
                            <div>{{$vaccancy->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Description: </div>
                            <div>{!! $vaccancy->description !!}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
