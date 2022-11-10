@extends('admin.layouts.app')
@section('admin-title')
    Show Dynamic Form Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Dynamic Form Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/dynamic-forms/categories') }}">Dynamic Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$category->name}} | Show Details</div>
                    <div class="card-body">
                        
                        <div class="course-row">
                            <div>Category Name:</div>
                            <div>{{$category->name}}</div>
                        </div>
                        <div class="course-row">
                            <div>Created Date : </div>
                            <div>{{$category->created_at}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status: </div>
                            <div>{{$category->status}}</div>
                        </div>
                       <hr>

                        <div class="course-row">
                            <div>Form Title: </div>
                            <div>{{$category->form->title ?? ''}}</div>
                        </div>

                        <div class="course-row">
                            <div>Active Form Elements: </div>
                            <div>
                                @if($category->form->name)
                                    <span class="m-2">Name</span>
                                @endif

                                @if($category->form->email)
                                    <span class="m-2">Email</span>
                                @endif

                                @if($category->form->contact)
                                    <span class="m-2">Contact</span>
                                @endif

                                @if($category->form->provience)
                                    <span class="m-2">Provience</span>
                                @endif

                                @if($category->form->photo)
                                    <span class="m-2">Photo</span>
                                @endif

                                @if($category->form->file)
                                    <span class="m-2">File</span>
                                @endif

                                @if($category->form->message)
                                    <span class="m-2">Message</span>
                                @endif

                            </div>
                        </div>

                        <div class="course-row">
                            <div>Form Banner: </div>
                            <div><img src="/storage/{{$category->form->banner}}" alt="" class="img img-fluid"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
