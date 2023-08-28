@extends('admin.layouts.app')
@section('admin-title')
    Book Category Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Book Category</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/books/publishers') }}">Publishers</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/books/publishers/'.$publisher->id.'/categories') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Book Category Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Category ID:</div>
                            <div>{{$category->id}}</div>
                        </div>
                    
                        <div class="course-row">
                            <div>Publisher Name:</div>
                            <div>{{ucwords($category->publisher->name ?? ' ')}}</div>
                        </div>

                        <div class="course-row">
                            <div>Category Name:</div>
                            <div>{{ucwords($category->name ?? ' ')}}</div>
                        </div>

                        <div class="course-row">
                            <div>Category Order:</div>
                            <div>{{ucwords($category->order ?? ' ')}}</div>
                        </div>

                        <div class="course-row">
                            <div>Category Status: </div>
                            <div>{{$category->status}}</div>
                        </div>

                        <div class="course-row">
                            <div>Category Image:</div>
                            <div><img src="/storage/{{$category->image}}" alt="" class="img img-fluid"></div>
                        </div>
                                           
                        {{-- <div class="course-row">
                            <div>Category Description: </div>
                            <div>{!! $category->description !!}</div>
                        </div> --}}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
