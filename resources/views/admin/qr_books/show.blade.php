@extends('admin.layouts.app')
@section('admin-title')
    Book For QR Details
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Book For QR</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/qr-books') }}"> My Books For QR</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View QR Book Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Book ID:</div>
                            <div>{{$book->id}}</div>
                        </div>
                    
                        <div class="course-row">
                            <div>Book Category:</div>
                            <div>{{ucwords($book->category ?? ' ')}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Publisher:</div>
                            <div>{{ucwords($book->publisher ?? ' ')}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Title:</div>
                            <div>{{ucwords($book->title)}}</div>
                        </div>                       

                        <div class="course-row">
                            <div>Book Author: </div>
                            <div>{{ucwords($book->author)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Edition: </div>
                            <div>{{ucwords($book->edition)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book ISBN: </div>
                            <div>{{$book->isbn}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Published Year: </div>
                            <div>{{ucwords($book->published_year)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Pages: </div>
                            <div>{{ucwords($book->pages)}}</div>
                        </div>

                        <div class="course-row">
                            <div>Book Published Quantity: </div>
                            <div>{{ucwords($book->quantity)}}</div>
                        </div>
                        {{-- <div class="course-row">
                            <div>Book Availability: </div>
                            <div>{{ucwords($book->availability)}}</div>
                        </div> --}}

                        <div class="course-row">
                            <div>Book Price: </div>
                            <div>Rs. {{$book->price ?? '0'}}</div>
                        </div>
                        <div class="course-row">
                            <div> Discount (%): </div>
                            <div>{{$book->discount ?? '0'}}%</div>
                        </div>
                        <div class="course-row">
                            <div> Final Book Price: </div>
                            <div>Rs. {{ ($book->price - (($book->price*$book->discount)/100)) }}</div>
                        </div>
                        {{-- <div class="course-row">
                            <div>Book Purchase Link: </div>
                            <div>{{$book->purchase_link}}</div>
                        </div> --}}
                    
                        {{-- <div class="course-row">
                            <div>Book Status: </div>
                            <div>{{$book->status}}</div>
                        </div> --}}

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
