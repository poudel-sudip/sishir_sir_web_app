@extends('admin.layouts.app')
@section('admin-title')
    Show Sub Menu | {{$group->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Sub Menu Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Menus</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="course-row">
                            <div>Sub Menu ID:</div>
                            <div>{{$subgroup->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Group:</div>
                            <div>{{$group->name}}</div>
                        </div>
                        <hr>
                        <div class="course-row">
                            <div>Sub Menu Name:</div>
                            <div>{{ucwords($subgroup->name)}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sub Menu Type:</div>
                            <div>{{ucwords($subgroup->type)}}</div>
                        </div>
                        <div class="course-row">
                            <div> Sub Menu File Name:</div>
                            <div>{{$subgroup->filename}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sub Menu Order:</div>
                            <div>{{$subgroup->order}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sub Menu Status:</div>
                            <div>{{$subgroup->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sub Menu Description:</div>
                            <div>{!! $subgroup->description !!}</div>
                        </div>
                        @if($subgroup->fileurl)
                        <div class="course-row">
                            <div>Sub Menu File:</div>
                            <div><iframe src="/storage/{{$subgroup->fileurl}}" frameborder="0" style="width: 100%; min-height:500px" target="_parent"></iframe></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
