@extends('admin.layouts.app')
@section('admin-title')
    Health Day Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Health Day</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/health-days?year='.date('Y',strtotime($healthDay->date))) }}">Health Days</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="course-row">
                            <div>Date : </div>
                            <div>{{$healthDay->date}}</div>
                        </div>

                        <div class="course-row">
                            <div>Title : </div>
                            <div>{{$healthDay->title}}</div>
                        </div>
                       
                        <div class="course-row">
                            <div>Author : </div>
                            <div>{{$healthDay->author}}</div>
                        </div>

                        {{-- <div class="course-row">
                            <div>Status: </div>
                            <div>{{$healthDay->status}}</div>
                        </div> --}}

                        <div class="course-row">
                            <div>Description: </div>
                            <div>{!! $healthDay->description !!}</div>
                        </div>

                        <div class="course-row">
                            <div>Thumbnail: </div>
                            <div><img src="/storage/{{$healthDay->image}}" class="img img-fluid" style="max-height:150px" alt=""></div>
                        </div>

                        @if(trim($healthDay->pdf_file))
                            <div class="course-row">
                                <div>PDF File: </div>
                                <div><iframe src="/storage/{{$healthDay->pdf_file}}" frameborder="0"style="width: 100%; min-height:500px" target="_parent" ></iframe></div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
