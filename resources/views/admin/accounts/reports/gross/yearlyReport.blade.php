@extends('admin.layouts.app')
@section('admin-title')
    {{date('Y',strtotime($start))}}  Report
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{date('Y',strtotime($start))}} Report</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Accounts</li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports/gross') }}">Gross</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Yearly</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">{{date('Y',strtotime($start))}} Income Lists</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($incomedata as $income)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$income->category}}</td>
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
                            <h4 class="card-title">{{date('Y',strtotime($start))}} Expense Lists</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($expensedata as $expense)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$expense->category}}</td>
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
