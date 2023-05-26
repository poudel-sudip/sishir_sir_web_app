@extends('admin.layouts.app')
@section('admin-title')
    Show Library Material | {{$category->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Library Material Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/library') }}">Library</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/library/'.$category->id.'/directories') }}">{{ucwords($category->name)}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="course-row">
                            <div>Material ID:</div>
                            <div>{{$material->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Material Category:</div>
                            <div>{{$category->name}}</div>
                        </div>
                        <hr>
                        <div class="course-row">
                            <div>Material Name:</div>
                            <div>{{ucwords($material->name)}}</div>
                        </div>
                        <div class="course-row">
                            <div>Material Type:</div>
                            <div>{{ucwords($material->type)}}</div>
                        </div>
                        <div class="course-row">
                            <div> Material File Name:</div>
                            <div>{{$material->filename}}</div>
                        </div>
                        <div class="course-row">
                            <div>Material Order:</div>
                            <div>{{$material->order}}</div>
                        </div>
                        <div class="course-row">
                            <div>Material Can Download:</div>
                            <div>{{$material->download ? 'Yes' : 'No'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Material Status:</div>
                            <div>{{$material->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Material Created Date:</div>
                            <div>{{$material->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Thumbnail:</div>
                            <div><img src="/storage/{{$material->thumbnail}}" alt="" class="img img-fluid" style="max-height:200px"></div>
                        </div>
                        <div class="course-row">
                            <div>Material Description:</div>
                            <div>{!! $material->description !!}</div>
                        </div>
                        @if($material->fileurl)
                        <div class="course-row">
                            <div>Material File:</div>
                            <div><iframe src="/storage/{{$material->fileurl}}" frameborder="0" style="width: 100%; min-height:500px" target="_parent"></iframe></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
