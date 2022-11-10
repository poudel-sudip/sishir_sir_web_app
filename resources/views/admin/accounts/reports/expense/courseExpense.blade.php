@extends('admin.layouts.app')
@section('admin-title')
    {{$course}} | Expense Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$course}} Expenses</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports/expenses') }}">Expenses</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Course</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">{{$course}} Expense Lists</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Ledger</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>From Account</th>
                                    <th>To Account</th>
                                    <th>Verified By</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($data as $row)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d h:i A',strtotime($row->date))}}</td>
                                        <td>{{$row->type}}</td>
                                        <td>{{$row->ledger}}</td>
                                        <td>Rs {{$row->amount}}</td>
                                        <td>Rs {{$row->discount}}</td>
                                        <td>{{$row->fromAccount}}</td>
                                        <td>{{$row->toAccount}}</td>
                                        <td>{{$row->verifiedBy}}</td>
                                        <td class="text-wrap">{{$row->remarks}}</td>

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