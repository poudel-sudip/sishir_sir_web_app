@extends('admin.layouts.app')
@section('admin-title')
    All Tutor Reports
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">All Tutor Reports</h3>
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
{{--                        <h4 class="card-title">All Tutors Report</h4>--}}
                        <a href="/admin/reports/tutor/all/export">Download</a>
                    </div>
                    <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Qualification</th>
                                <th>Experiences</th>
                                <th>Courses</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Updated On</th>
                            </tr>
                            @php($i=1)
                            @forelse($reports as $rep)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$rep->name}}</td>
                                    <td>{{$rep->email}}</td>
                                    <td>{{$rep->contact}}</td>
                                    <td class="text-wrap" style="min-width:200px">{{$rep->qualification}}</td>
                                    <td class="text-wrap" style="min-width:200px">{{$rep->experience}}</td>
                                    <td class="text-wrap" style="min-width:200px">{{$rep->courses}}</td>
                                    <td>{{$rep->status}}</td>
                                    <td>{{date('Y/m/d',strtotime($rep->created_at))}}</td>
                                    <td>{{date('Y/m/d',strtotime($rep->updated_at))}}</td>
                                </tr>
                                @php($i++)
                            @empty
                                <tr><td colspan="12" class="text-center">No Tutor Details Found</td></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
