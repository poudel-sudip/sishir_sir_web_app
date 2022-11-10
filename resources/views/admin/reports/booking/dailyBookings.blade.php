@extends('admin.layouts.app')
@section('admin-title')
    Daily Bookings Report
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Daily Bookings Report</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports/booking') }}">Bookings Report</a></li>
            <li class="breadcrumb-item active" aria-current="page">Generate(daily)</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">{{ __('Daily Bookings on : ').date('Y-m-d',strtotime($date)) }}</h4>
                        <a href="/admin/reports/booking/daily/{{$date}}/export">Download</a>
                    </div>
                    <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered">
                            <tr>
                                <th>SN</th>
                                <th>Date</th>
                                <th>Booked By</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Course</th>
                                <th>Batch</th>
                                <th>Discounted Price</th>
                                <th>Duration</th>
                                <th>Start On</th>
                                <th>End On</th>
                                <th>Payment Amt.</th>
                                <th>Mode</th>
                                <th>Account No</th>
                                <th>Status</th>
                            </tr>
                            @php($i=1)
                            @forelse($reports as $rep)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{date('Y/m/d',strtotime($rep->created_at))}}</td>
                                    <td>{{$rep->name}}</td>
                                    <td>{{$rep->email}}</td>
                                    <td>{{$rep->contact}}</td>
                                    <td>{{$rep->mybatch->course->name ?? ''}}</td>
                                    <td>{{$rep->mybatch->name ?? ''}}</td>
                                    <td>Rs. {{($rep->mybatch->fee ?? 0)-($rep->mybatch->discount ?? 0) ?? ''}}</td>
                                    <td>{{($rep->mybatch->duration ?? '').' '.($rep->mybatch->durationType ?? '')}}</td>
                                    <td>@if($rep->mybatch->startDate ?? '') {{date('Y/m/d',strtotime($rep->mybatch->startDate ?? '') ?? '')}} @endif</td>
                                    <td>@if($rep->mybatch->endDate ?? '') {{date('Y/m/d',strtotime($rep->mybatch->endDate ?? '')) ?? ''}} @endif</td>
                                    <td>Rs. {{$rep->amount}}</td>
                                    <td>{{$rep->mode}}</td>
                                    <td>{{$rep->account}}</td>
                                    <td>{{$rep->status}}</td>
                                </tr>
                                @php($i++)
                            @empty
                                <tr><td colspan="15" class="text-center">No Booking Details Found</td></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
