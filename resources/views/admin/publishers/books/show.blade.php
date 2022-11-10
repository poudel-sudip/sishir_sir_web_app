@extends('admin.layouts.app')
@section('admin-title')
    Publisher E-Book Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Publisher's E-Book</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/publishers') }}">Publishers</a></li>
                <li class="breadcrumb-item"><a href="/admin/publishers/{{$publisher->id}}/books">E-Books</a></li>
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
                            <div>Book Publisher</div>
                            <div>{{$publisher->name}}</div>
                        </div><div class="course-row">
                            <div>Book ID:</div>
                            <div>{{$book->id}}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Category:</div>
                            <div>{{$book->category->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Name:</div>
                            <div>{{$book->title}}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Slug: </div>
                            <div>{{$book->slug}}</div>
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
                            <div>Book Description: </div>
                            <div>{!! $book->description !!}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Is Pinned: </div>
                            <div>{{$book->isPinned}}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Status: </div>
                            <div>{{$book->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Book Thumbnail Image: </div>
                            <div><img src="/storage/{{$book->thumbnail}}" width="200" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
