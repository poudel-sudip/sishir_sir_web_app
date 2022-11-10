@extends('admin.layouts.app')
@section('admin-title')
    All Users Report
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">All Users Report</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/reports/user') }}">User Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Generate</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="custom-table-header">
{{--                        <h4 class="card-title">All Users Report</h4>--}}
                        <a href="/admin/reports/user/all/export">Download</a>
                    </div>
                    <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered">
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>District/City</th>
                                <th>Role</th>
                                <th>Interests</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Updated On</th>
                            </tr>
                            @php($i=1)
                            @forelse($reports as $rep)
                                <tr>
                                    <td class="text-wrap">{{$i}}</td>
                                    <td class="text-wrap">{{$rep->name}}</td>
                                    <td class="text-wrap">{{$rep->email}}</td>
                                    <td class="text-wrap">{{$rep->contact}}</td>
                                    <td class="text-wrap">{{$rep->district}}</td>
                                    <td class="text-wrap">{{$rep->role}}</td>
                                    <td class="text-wrap">{{$rep->interests}}</td>
                                    <td class="text-wrap">{{$rep->status}}</td>
                                    <td class="text-wrap">{{date('Y/m/d',strtotime($rep->created_at))}}</td>
                                    <td class="text-wrap">{{date('Y/m/d',strtotime($rep->updated_at))}}</td>
                                </tr>
                                @php($i++)
                            @empty
                            <tr><td colspan="9" class="text-center">No User Details Found</td></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
