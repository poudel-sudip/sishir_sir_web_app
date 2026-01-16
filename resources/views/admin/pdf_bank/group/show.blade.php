@extends('admin.layouts.app')
@section('admin-title')
    eBook Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show eBook Detail</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-groups') }}">eBooks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View eBook Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>eBook ID:</div>
                            <div>{{$group->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Category:</div>
                            <div>{{$group->category->name ?? ''}}</div>
                        </div><div class="course-row">
                            <div>eBook Name:</div>
                            <div>{{$group->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Slug: </div>
                            <div>{{$group->slug}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Price: </div>
                            <div>Rs. {{$group->price ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Discount: </div>
                            <div>Rs. {{$group->discount ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Description: </div>
                            <div>{!! $group->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Is Pinned: </div>
                            <div>{{$group->isPinned}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Status: </div>
                            <div>{{$group->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Number of Pages:</div>
                            <div>{{$group->pages}}</div>
                        </div>
                        <div class="course-row">
                            <div>Paper:</div>
                            <div>{{$group->paper}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Thumbnail Image: </div>
                            <div><img src="/storage/{{$group->thumbnail}}" width="200" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
