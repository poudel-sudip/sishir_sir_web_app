@extends('admin.layouts.app')
@section('admin-title')
    Show Physical Book Order
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Physical Book Booking</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show Book Order</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Physical Book Order Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div >Order ID:</div>
                            <div >{{$order->id}}</div>
                        </div>                        
                        <div class="course-row">
                            <div >Book Category:</div>
                            <div >{{ucwords($order->book_category ?? ' ')}}</div>
                        </div>
                        <div class="course-row">
                            <div >Book Title:</div>
                            <div >{{ucwords($order->book_title ?? ' ')}}</div>
                        </div>
                        <div class="course-row">
                            <div >Book Author:</div>
                            <div >{{ucwords($order->book_author ?? ' ')}}</div>
                        </div>
                        <div class="course-row">
                            <div >Book Publication:</div>
                            <div >{{ucwords($order->book_publisher ?? ' ')}}</div>
                        </div>
                        <div class="course-row">
                            <div >Quantity:</div>
                            <div >{{$order->quantity}}</div>
                        </div>
                        <div class="course-row">
                            <div >Unit Price:</div>
                            <div >{{$order->unit_price}}</div>
                        </div>  
                        <div class="course-row">
                            <div > Message:</div>
                            <div >{{($order->message)}}</div>
                        </div>
                        
                        <div class="course-row">
                            <div >User:</div>
                            <div >{{($order->name ?? '')}} ({{$order->contact ?? ''}})</div>
                        </div>

                        <div class="course-row">
                            <div >Delivery Location:</div>
                            <div >{{($order->location)}}</div>
                        </div>
                        <div class="course-row">
                            <div >Issue Date:</div>
                            <div >{{($order->created_at)}}</div>
                        </div>
                                                
                    </div>
                </div>
            </div>
         
        </div>
    </div>
@endsection
