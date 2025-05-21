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
                    <div class="card-header">Show Vaccancy Details </div>
                    <div class="card-body">                        
                        <div class="course-row">
                            <div>Title  </div>
                            <div>{{$vaccancy->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Created Date  </div>
                            <div>{{$vaccancy->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Author </div>
                            <div>{{$vaccancy->author}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status </div>
                            <div>{{$vaccancy->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Related Tags </div>
                            <div>{{implode(', ',$vaccancy->related_tag_names)}}</div>
                        </div>
                        <div class="course-row">
                            <div>Thumbnail </div>
                            <div><img src="/storage/{{$vaccancy->thumbnail}}" alt="" class="img img-fluid" style="max-height: 100px;"></div>
                        </div>
                        <div class="course-row">
                            <div>Description </div>
                            <div>{!! $vaccancy->description !!}</div>
                        </div>

                        <div class="course-row">
                            <div>Search Tags </div>
                            <div>{!! $vaccancy->search_tags !!}</div>
                        </div>

                        <div class="course-row">
                            <div>Image File </div>
                            <div class="text-center"><img src="/storage/{{$vaccancy->img_file}}" alt="" class="img img-fluid" style=""></div>
                        </div>

                        <div class="course-row">
                            <div>PDF File </div>
                            <div>
                                @if(trim($vaccancy->pdf_file))
                                    <iframe src="/storage/{{$vaccancy->pdf_file}}#toolbar=1" 
                                        oncontextmenu="return false" 
                                        onselectstart="return false" 
                                        ondragstart="return false"
                                        frameborder="0" 
                                        style="width: 100%; min-height:700px" 
                                        target="_parent"
                                        nodownload>
                                    </iframe> 
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
