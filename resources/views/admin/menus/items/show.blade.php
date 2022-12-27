@extends('admin.layouts.app')
@section('admin-title')
    Show Menu Item | {{$subgroup->name}} | {{$group->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Menu Item Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Menus</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/items') }}">Sub Menus</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="course-row">
                            <div>Menu Item ID:</div>
                            <div>{{$item->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Group:</div>
                            <div>{{$group->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Sub Menu:</div>
                            <div>{{$subgroup->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Name:</div>
                            <div>{{$item->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Type:</div>
                            <div>{{$item->type}}</div>
                        </div>
                        <div class="course-row">
                            <div>File Name:</div>
                            <div>{{$item->filename}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Order:</div>
                            <div>{{$item->order}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Status:</div>
                            <div>{{$item->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Menu Description:</div>
                            <div>{!! $item->description !!}</div>
                        </div>
                        @if($item->fileurl)
                        <div class="course-row">
                            <div>Menu File:</div>
                            <div><iframe src="/storage/{{$item->fileurl}}" frameborder="0" style="width: 100%; min-height:500px" target="_parent"></iframe></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
