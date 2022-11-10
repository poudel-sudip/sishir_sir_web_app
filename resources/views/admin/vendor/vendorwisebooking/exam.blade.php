@extends('admin.layouts.app')
@section('admin-title')
    Vendor Wise Exam Bookings
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Vendor Wise Exam Bookings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/exam-hall/bookings/all') }}">Exam Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Filter Vendor</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Vendor Wise Exam Bookings</h4>
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="main-booking-table">
                          <thead>
                            <tr>
                                <th class="text-wrap">ID</th>
                                <th class="text-wrap">Date</th>
                                <th class="text-wrap">Exam</th>
                                <th class="text-wrap">Student</th>
                                <th class="text-wrap">Email</th>
                                <th class="text-wrap">Discount + Commession</th>
                                <th class="text-wrap">Status</th>
                                <th class="text-wrap">Vendor</th>
                                <th class="text-wrap">Team</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($bookings as $booking)
                                <tr>
                                    <td class="text-wrap">{{$booking->booking->id ?? ''}}</td>
                                    <td class="text-wrap">{{date('Y-m-d',strtotime($booking->created_at))}}</td>
                                    <td class="text-wrap">{{$booking->booking->category->title ?? ''}}</td>
                                    <td class="text-wrap">{{$booking->booking->user_name ?? ''}}</td>
                                    <td class="text-wrap">{{ $booking->booking->user->email ?? ''}}</td>
                                    <td class="text-wrap">Rs. {{ $booking->booking->discount ?? '0' }} </td>
                                    <td class="text-wrap">{{$booking->booking->status ?? ''}}</td>
                                    <td class="text-wrap">{{$booking->vendor->name ?? ''}}</td>
                                    <td class="text-wrap">{{$booking->team->name ?? ''}}</td>
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
                        
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
