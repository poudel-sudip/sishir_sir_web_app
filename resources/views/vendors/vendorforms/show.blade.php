@extends('vendors.layouts.app')
@section('admin-title')
    Show Form Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Form Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/vendor/vendor-dynamic-forms') }}">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ucwords($vform->title)}} | Show Details</div>
                    <div class="card-body">
                       
                        <div class="course-row">
                            <div>Form Link: </div>
                            <div>{{url('/vendor-forms/'.$vform->slug)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Form Title: </div>
                            <div>{{ucwords($vform->title ?? '')}}</div>
                        </div>

                        <div class="course-row">
                            <div>Sub Categories: </div>
                            <div>{{ucwords($vform->sub_categories ?? '')}}</div>
                        </div>

                        <div class="course-row">
                            <div>Created Date : </div>
                            <div>{{$vform->created_at}}</div>
                        </div>

                        <div class="course-row">
                            <div>Status: </div>
                            <div>{{$vform->status}}</div>
                        </div>

                        <div class="course-row">
                            <div>Active Form Elements: </div>
                            <div>
                                @if($vform->name)
                                    <span class="m-2">Name</span>
                                @endif

                                @if($vform->email)
                                    <span class="m-2">Email</span>
                                @endif

                                @if($vform->contact)
                                    <span class="m-2">Contact</span>
                                @endif

                                @if($vform->provience)
                                    <span class="m-2">Provience</span>
                                @endif

                                @if($vform->photo)
                                    <span class="m-2">Photo</span>
                                @endif

                                @if($vform->file)
                                    <span class="m-2">File</span>
                                @endif

                                @if($vform->message)
                                    <span class="m-2">Message</span>
                                @endif

                            </div>
                        </div>

                        <div class="course-row">
                            <div>Form Banner: </div>
                            <div><img src="/storage/{{$vform->banner}}" alt="" class="img img-fluid"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
