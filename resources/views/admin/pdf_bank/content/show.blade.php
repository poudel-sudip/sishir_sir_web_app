@extends('admin.layouts.app')
@section('admin-title')
    {{$content->title}} | {{$group->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show PDF File Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-groups') }}">eBooks</a></li>
                <li class="breadcrumb-item"><a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files">Contents</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Show PDF File Content Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>PDF File ID:</div>
                            <div>{{$content->id}}</div>
                        </div>                      
                        <div class="course-row">
                            <div>eBook Name: </div>
                            <div>{{$group->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>PDF File Title: </div>
                            <div>{{$content->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>PDF File Status: </div>
                            <div>{{$content->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Can Download:</div>
                            <div>{{$content->download ? 'Yes' : 'No'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Authors:</div>
                            <div>{{$content->author}}</div>
                        </div>
                        <div class="course-row">
                            <div>Number of Pages:</div>
                            <div>{{$content->pages}}</div>
                        </div>
                        <div class="course-row">
                            <div>Published Year:</div>
                            <div>{{$content->published_year}}</div>
                        </div>
                        <div class="course-row">
                            <div>Video URL: </div>
                            <div>
                                {{$content->video_file ?? ''}} 
                                @if(trim($content->video_file)) 
                                <br>
                                <a class="view-video btn btn-info" href="#videoModal" video-title="{{$content->title}}" video-url="{{$content->video_file}}" data-bs-toggle="modal" data-bs-target="#videoModal" data-toggle="modal" data-target="#videoModal">Play <span class="fas fa-video mdi mdi-video"></span></a>
                                @endif
                            </div>
                        </div>
                        <div class="course-row">
                            <div>PDF File: </div>
                            <div>
                                <iframe src="/storage/{{$content->pdf_file}}" frameBorder="0" scrolling="auto" height="600" width="100%"></iframe>
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
