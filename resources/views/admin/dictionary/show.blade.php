@extends('admin.layouts.app')
@section('admin-title')
    Dictionary Content Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Dictionary Content</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/health-dictionary') }}">Dictionary Contents</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">                       
                                              
                        <div class="course-row">
                            <div>Created Date : </div>
                            <div>{{$dictionary->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Title : </div>
                            <div>{{$dictionary->name}}</div>
                        </div>
                        
                        <div class="course-row ">
                            <div>Content: </div>
                            <div class="content-body">{!! Helper::prepareHtmlContent($dictionary->description) !!}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
