@extends('admin.layouts.app')
@section('admin-title')
    Blog Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Blog</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/blogs') }}">Blogs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$blog->title}} </div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Image: </div>
                            <div><img src="/storage/{{$blog->image}}" width="200"></div>
                        </div>

                        <div class="course-row">
                            <div>Author Name:</div>
                            <div>{{$blog->author}}</div>
                        </div>
                        <div class="course-row">
                            <div>Created Date : </div>
                            <div>{{$blog->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status: </div>
                            <div>{{$blog->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Description: </div>
                            <div>{!! $blog->description !!}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
