@extends('admin.layouts.app')
@section('admin-title')
    Tutor Batches Report
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Tutor Batches Report</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports/tutor') }}">Tutor Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Generate</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="custon-table-header">
{{--                        <h4 class="card-title">Tutor Batches Report</h4>--}}
                        <a href="/admin/reports/tutor/{{$tutor->id}}/batches/export">Download</a>
                    </div>
                    <div class="report">
                            <h3 class="text-center">{{$tutor->name}}</h3>
                            <div class="text-14">
                                <span class="mx-1">Email: {{$tutor->email}}</span>
                                <span class="mx-1">Contact: {{$tutor->contact}}</span>
                                <span class="mx-1">Qualification: {{$tutor->qualification}}</span>
                                <span class="mx-1">Experience: {{$tutor->experience}}</span>
                                <span class="mx-1">Created On: {{date('Y/m/d',strtotime($tutor->created_at))}}</span>
                                <span class="mx-1">Modified On: {{date('Y/m/d',strtotime($tutor->updated_at))}}</span>
                            </div>
                            <div class="table-responsive table-responsive-md">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SN</th>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        <th>Start On</th>
                                        <th>End On</th>
                                        <th>Duration</th>
                                        <th>Time</th>
                                        <th>Payment Amount</th>
                                    </tr>
                                    @php($i=1)
                                    @forelse($reports as $rep)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$rep->mybatch->course->name}}</td>
                                            <td>{{$rep->mybatch->name}}</td>
                                            <td>{{date('Y/m/d',strtotime($rep->mybatch->startDate))}}</td>
                                            <td>{{date('Y/m/d',strtotime($rep->mybatch->endDate))}}</td>
                                            <td>{{$rep->mybatch->duration.' '.$rep->mybatch->durationType}}</td>
                                            <td>{{$rep->mybatch->timeSlot}}</td>
                                            <td>{{$rep->price}}</td>
                                        </tr>
                                        @php($i++)
                                    @empty
                                        <tr><td colspan="12" class="text-center">No Booking Details Found</td></tr>
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
