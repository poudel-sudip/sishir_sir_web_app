@extends('admin.layouts.app')
@section('admin-title')
    {{date('Y-m',strtotime($start))}}  Report
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{date('Y-m',strtotime($start))}} Report</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports/gross') }}">Gross</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Monthly</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">{{date('Y-m',strtotime($start))}} Income Lists</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($incomes as $income)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d h:i A',strtotime($income->date))}}</td>
                                        <td>
                                            @if(in_array($income->category,['Misc','Opening','Deposite']))
                                                <strong>{{$income->category}}</strong> income in <strong>{{$income->ledger}}</strong>  by <em> {{$income->fromAccount}} </em>
                                            @else
                                                Paid by <strong>{{$income->ledger}}</strong> for <strong>{{$income->category}}</strong> by <em> {{$income->fromAccount}} </em> 
                                            @endif
                                            as {{$income->type}} Income
                                        </td>
                                        <td>Rs {{$income->amount}}</td>
                                        

                                    </tr>
                                    @php($i++)
                                @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">{{date('Y-m',strtotime($start))}} Expense Lists</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date('Y-m-d h:i A',strtotime($expense->date))}}</td>
                                        <td>
                                            
                                            @if($expense->type=='Tutors')
                                            Paid to <strong>{{$expense->ledger}}</strong> for <strong>{{$expense->category}}</strong> by <em> {{$expense->fromAccount}} </em> as Tutor Expense
                                            @elseif($expense->type=='Staff')
                                            Paid to <strong>{{$expense->ledger}}</strong> by <em> {{$expense->fromAccount}} </em> as <strong> Staff Salary </strong>
                                            @elseif($expense->type=='Refund')
                                            Paid to <strong>{{$expense->ledger}}</strong> for <strong>{{$expense->category}}</strong> by <em> {{$expense->fromAccount}} </em> as Course Refund
                                            @elseif($expense->type=='Office' && $expense->category=='Withdraw')
                                            Withdrawn from <strong>{{$expense->fromAccount}}</strong> to <strong>{{$expense->toAccount}}</strong> as Office Expense
                                            @elseif($expense->type=='Office')
                                            Paid to <strong>{{$expense->ledger}}</strong> for <strong>{{$expense->category}}</strong>  by <em> {{$expense->fromAccount}} </em> as Office Expense
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

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <div class="h4">Total Income:- Rs {{$incomes->sum('amount')}}  </div>
                    <div class="h4">Total Expense:- Rs {{$expenses->sum('amount')}} </div>
                    <div class="h4">Gross Amount:- Rs {{($incomes->sum('amount'))-($expenses->sum('amount'))}} </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
