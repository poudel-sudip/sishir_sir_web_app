@extends('admin.layouts.app')
@section('admin-title')
    Book Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Book</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/books') }}"> My Books</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View {{$book->title}} Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Book ID:</div>
                            <div>{{$book->id}}</div>
                        </div>
                    
                        <div class="course-row">
                            <div>Book Title:</div>
                            <div>{{ucwords($book->title)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Order: </div>
                            <div>{{$book->order}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Author: </div>
                            <div>{{ucwords($book->author)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Price: </div>
                            <div>Rs. {{$book->price ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Discount: </div>
                            <div>Rs. {{$book->discount ?? '0'}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Status: </div>
                            <div>{{$book->status}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Thumbnail Image: </div>
                            <div><img src="/storage/{{$book->thumbnail}}" width="200" alt=""></div>
                        </div>
                        
                        <div class="course-row">
                            <div>Book Description: </div>
                            <div>{!! $book->description !!}</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
