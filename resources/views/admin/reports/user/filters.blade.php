@extends('admin.layouts.app')
@section('admin-title')
    User Reports
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Filtered Users Report</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/reports/user') }}">User Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Generate(filter)</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custom-table-header">
                            <h4 class="card-title">Filter Type :- {{ucwords($filter)}} | {{is_string($value) ? $value : ''}}</h4>
                            @if($filter!='date')
                                <a href="/admin/reports/user/filter/{{$filter}}/{{{$value}}}/download">Download</a>
                            @endif

                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered">
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Provience</th>
                                    <th>District/City</th>
                                    <th>Interests</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Last Login</th>
                                </tr>
                                @php($i=1)
                                @forelse($users as $rep)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$rep->name}}</td>
                                        <td>{{$rep->email}}</td>
                                        <td>{{$rep->contact}}</td>
                                        <td>{{$rep->provience}}</td>
                                        <td>{{$rep->district_city}}</td>
                                        <td class="text-wrap">{{$rep->interests}}</td>
                                        <td>{{$rep->role}}</td>
                                        <td>{{$rep->status}}</td>
                                        <td>{{date('Y/m/d',strtotime($rep->created_at))}}</td>
                                        <td>{{$rep->last_login ?? ''}}</td>
                                    </tr>
                                    @php($i++)
                                @empty
                                    <tr><td colspan="11" class="text-center">No User Details Found</td></tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
