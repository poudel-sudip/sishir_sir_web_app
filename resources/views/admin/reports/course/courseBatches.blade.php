@extends('admin.layouts.app')
@section('admin-title')
  Course Batch Report
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Course Batch Report</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item"><a href="/admin/reports/course">Course Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Generate</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="custon-table-header">
{{--                        <h4 class="card-title">Course Batch Report</h4>--}}
                        <a href="/admin/reports/course/{{$course->id}}/export">Download</a>
                    </div>

                    <div class="report">
                        <h3 class="text-center">{{$course->category->name}}</h3>
                        <h4 class="text-center text-primary">{{$course->name}}</h4>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered">
                                <tr>
                                    <th>SN</th>
                                    <th>Batch Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Fee</th>
                                    <th>Discount</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Total st.</th>
                                    <th>Verified st.</th>
                                    <th>Created On</th>
                                    <th>Modified On</th>
                                </tr>
                            @php($i=1)
                                @forelse($reports as $report)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$report->name}}</td>
                                        <td>{{date('Y-m-d',strtotime($report->start))}}</td>
                                        <td>{{date('Y-m-d',strtotime($report->end))}}</td>
                                        <td>{{$report->fee}}</td>
                                        <td>{{$report->discount}}</td>
                                        <td>{{$report->time}}</td>
                                        <td>{{$report->status}}</td>
                                        <td>{{$report->totalstds}}</td>
                                        <td>{{$report->verifiedstds}}</td>
                                        <td>{{date('Y-m-d',strtotime($report->created_at))}}</td>
                                        <td>{{date('Y-m-d',strtotime($report->updated_at))}}</td>
                                    </tr>
                                    @php($i++)
                                @empty
                                    <tr><td colspan="12" class="text-center">No Batches Found</td></tr>
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
