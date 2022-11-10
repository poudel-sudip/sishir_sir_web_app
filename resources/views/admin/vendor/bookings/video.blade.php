@extends('admin.layouts.app')
@section('admin-title')
    Vendor Video Bookings
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Vendor Video Bookings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/vendor') }}">Vendors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Video Bookings</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                          <h4 class="card-title">{{$vendor->name}} | Video Bookings</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="main-booking-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Video Course </th>
                                <th>Booked By</th>
                                <th>Email</th>
                                <th>Due Amount</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->booking->id}}</td>
                                <td>{{date('Y-m-d',strtotime($booking->created_at))}}</td>
                                <td>{{$booking->booking->course->name ?? '' }}</td>
                                <td>{{$booking->booking->user_name}}</td>
                                <td>{{ $booking->booking->user->email ?? '' }}</td>
                                <td>
                                    @if($booking->booking->status == 'Verified' && $booking->booking->dueAmount>10)
                                        Rs. {{ $booking->booking->dueAmount ?? '0' }}
                                    @endif
                                </td>
                               
                                <td>
                                    @if($booking->booking->status == 'Verified')
                                    <span class="text-success">{{$booking->booking->status}}</span>
                                    @else
                                    <span class="text-warning">{{$booking->booking->status}}</span>
                                    @endif
                                </td>
                                <td class="text-wrap" max-width="150px">{{ $booking->booking->remarks }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                       
                        <hr>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
