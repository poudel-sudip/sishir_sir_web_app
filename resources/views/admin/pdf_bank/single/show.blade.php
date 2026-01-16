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
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-singles') }}">eBooks</a></li>
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
                            <div>{{$single->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Category:</div>
                            <div>{{$single->category->name ?? ''}}</div>
                        </div><div class="course-row">
                            <div>eBook Name:</div>
                            <div>{{$single->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Slug: </div>
                            <div>{{$single->slug}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Price: </div>
                            <div>Rs. {{$single->price ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Discount: </div>
                            <div>Rs. {{$single->discount ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Description: </div>
                            <div>{!! $single->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Is Pinned: </div>
                            <div>{{$single->isPinned}}</div>
                        </div>
                        <div class="course-row">
                            <div>eBook Status: </div>
                            <div>{{$single->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Can Download:</div>
                            <div>{{$single->download ? 'Yes' : 'No'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Number of Pages:</div>
                            <div>{{$single->pages}}</div>
                        </div>
                        <div class="course-row">
                            <div>Paper:</div>
                            <div>{{$single->paper}}</div>
                        </div>
                        <div class="course-row">
                            <div>Video URL: </div>
                            <div>
                                {{$single->video_file ?? ''}} 
                                @if(trim($single->video_file)) 
                                <br>
                                <a class="view-video btn btn-info" href="#videoModal" video-title="{{$single->title}}" video-url="{{$single->video_file}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play <span class="fas fa-video mdi mdi-video"></span></a>
                                @endif
                            </div>
                        </div>
                        <div class="course-row">
                            <div>eBook Thumbnail Image: </div>
                            <div><img src="/storage/{{$single->thumbnail}}" width="200" alt=""></div>
                        </div>
                        <div class="course-row">
                            <div>PDF File: </div>
                            <div>
                                <iframe src="/storage/{{$single->pdf_file}}" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div id="videoModal" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-white align-items-center">
                    <h5 class="modal-title" id="playingTitle"> </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="videoPlayer" class="embed-responsive embed-responsive-16by9"> </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
