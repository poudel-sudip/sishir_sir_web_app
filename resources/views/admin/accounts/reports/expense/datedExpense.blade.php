@extends('admin.layouts.app')
@section('admin-title')
    Dated Expense Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Expense on 
                @if($filter->type=='Year')
                {{date('Y',strtotime($filter->date))}}
                @elseif($filter->type=='Month')
                {{date('Y-m',strtotime($filter->date))}}
                @else
                {{$filter->date}}
                @endif
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports/expenses') }}">Expenses</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Date Filter</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Date Filtered Expense Lists</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="table-courses">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i=1)
                                    @foreach($data as $expense)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{date('Y-m-d h:i A',strtotime($expense->date))}}</td>
                                            <td>{{$expense->type}}</td>
                                            <td>
                                                @if($expense->category=='Withdraw')
                                                {{$expense->category}} from <strong>{{$expense->fromAccount}}</strong> to <strong>{{$expense->toAccount}}</strong>
                                                @else
                                                Paid to <strong>{{$expense->ledger}}</strong> for <strong>{{$expense->category}}</strong>  by <em> {{$expense->fromAccount}} </em> 
                                                @endif
                                            </td>
                                            <td>Rs {{$expense->amount}}</td>
                                            
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
