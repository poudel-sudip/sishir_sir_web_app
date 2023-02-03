@extends('admin.layouts.app')
@section('admin-title')
    Show Category | {{$subgroup->name}} | {{$group->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Category Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Menus</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="course-row">
                            <div>Menu Category ID:</div>
                            <div>{{$category->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Group:</div>
                            <div>{{$group->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sub Menu:</div>
                            <div>{{$subgroup->name}}</div>
                        </div>
                        <hr>
                        <div class="course-row">
                            <div>Menu Category  Name:</div>
                            <div>{{ucwords($category->name)}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Category  Type:</div>
                            <div>{{ucwords($category->type)}}</div>
                        </div>
                        <div class="course-row">
                            <div> Category File Name:</div>
                            <div>{{$category->filename}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Category  Order:</div>
                            <div>{{$category->order}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Category  Status:</div>
                            <div>{{$category->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Thumbnail:</div>
                            <div><img src="/storage/{{$category->thumbnail}}" alt="" class="img img-fluid" style="max-height:200px"></div>
                        </div>
                        <div class="course-row">
                            <div>Menu Category  Description:</div>
                            <div>{!! $category->description !!}</div>
                        </div>
                        @if($category->fileurl)
                        <div class="course-row">
                            <div>Menu Category File:</div>
                            <div><iframe src="/storage/{{$category->fileurl}}" frameborder="0" style="width: 100%; min-height:500px" target="_parent"></iframe></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
