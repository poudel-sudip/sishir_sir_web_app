@extends('admin.layouts.app')
@section('admin-title')
    All Merchant Wise Bookings
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Merchant Wise  Bookings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Merchant Wise Bookings</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">All Merchant Wise Bookings</h4>
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="advanced-desc-table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Merchant</th>
                                    <th>Booking ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($bookings as $data)
                                    <tr>
                                        <td class="text-wrap">{{$i}}</td>
                                        <td class="text-wrap">{{ucwords($data->type ?? '')}}</td>
                                        <td class="text-wrap">{{ucwords($data->title ?? '')}}</td>
                                        <td class="text-wrap">{{ucwords($data->merchant ?? '')}}</td>
                                        <td class="text-wrap">{{$data->booking_id}}</td>

                                        @switch($data->type)
                                            @case('course')
                                                @if($data->courseBooking)
                                                    <td class="text-wrap"> {{$data->courseBooking->user->name}} </td>
                                                    <td class="text-wrap"> {{$data->courseBooking->user->email}} </td>
                                                    <td class="text-wrap"> {{$data->courseBooking->user->contact}} </td>
                                                    <td class="text-wrap"> Rs. {{$data->courseBooking->paymentAmount}} </td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                @break
                                            @case('exam')
                                                @if($data->examBooking)
                                                    <td class="text-wrap"> {{$data->examBooking->user->name}} </td>
                                                    <td class="text-wrap"> {{$data->examBooking->user->email}} </td>
                                                    <td class="text-wrap"> {{$data->examBooking->user->contact}} </td>
                                                    <td class="text-wrap"> Rs. {{$data->examBooking->paidAmount}} </td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                @break
                                            @case('ebook')
                                                @if($data->ebookBooking)
                                                    <td class="text-wrap"> {{$data->ebookBooking->user->name}} </td>
                                                    <td class="text-wrap"> {{$data->ebookBooking->user->email}} </td>
                                                    <td class="text-wrap"> {{$data->ebookBooking->user->contact}} </td>
                                                    <td class="text-wrap"> Rs. {{$data->ebookBooking->paymentAmount}} </td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                @break
                                            @default
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                @break
                                        @endswitch
                                        
                                        <td class="text-wrap"> {{date('Y-m-d g:i:s',strtotime($data->created_at))}} </td>
                                    </tr>
                                    @php($i++)
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
