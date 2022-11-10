@extends('admin.layouts.app')
@section('admin-title')
    Verified Batch Booking
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Verified Batch Booking Reports</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/reports/batch') }}">Batch Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Verified</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
{{--                            <h4 class="card-title">{{ __('All Verified Bookings Report of Batch: ').$batch->name }}</h4>--}}
                            <a href="/admin/reports/batch/{{$batch->id}}/verified/export">Download</a>
                        </div>
                        <div class="report">
                            <h3 class="text-center">{{$batch->course->name}}</h3>
                            <h5 class="text-center text-primary">{{$batch->name}}</h5>
                            <div class="text-14">
                                <span class="mx-1">Start On: {{date('Y/m/d',strtotime($batch->startDate))}}</span>
                                <span class="mx-1">End On: {{date('Y/m/d',strtotime($batch->endDate))}}</span>
                                <span class="mx-1">Duration: {{$batch->duration.' '.$batch->durationType}}</span>
                                <span class="mx-1">Time: {{$batch->timeSlot}}</span>
                                <span class="mx-1">Fee: {{$batch->fee}}</span>
                                <span class="mx-1">Discount: {{$batch->discount}}</span>
                                <span class="mx-1">Status: {{$batch->status}}</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Payment Amount</th>
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
                                            <td>{{$rep->amount}}</td>
                                            <td>{{$rep->mode}}</td>
                                            <td>{{$rep->account}}</td>
                                            <td>{{$rep->status}}</td>
                                        </tr>
                                        @php($i++)
                                    @empty
                                        <tr><td colspan="9" class="text-center">No Booking Details Found</td></tr>
                                    @endforelse
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
