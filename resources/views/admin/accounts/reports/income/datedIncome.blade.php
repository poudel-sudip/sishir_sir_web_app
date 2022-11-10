@extends('admin.layouts.app')
@section('admin-title')
    Dated Income Lists
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Income on 
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
                    <li class="breadcrumb-item"><a href="{{ url('/admin/accounts/reports/incomes') }}">Incomes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Date Filter</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Date Filtered Income Lists</h4>
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
                            @foreach($data as $income)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{date('Y-m-d h:i A',strtotime($income->date))}}</td>
                                    <td>{{$income->type}}</td>
                                    <td>
                                        @if(in_array($income->category,['Misc','Opening','Deposite']))
                                            <strong>{{$income->category}}</strong> income in <strong>{{$income->ledger}}</strong>  by <em> {{$income->fromAccount}} </em> 
                                        @else
                                            Paid by <strong>{{$income->ledger}}</strong> for <strong>{{$income->category}}</strong> by <em> {{$income->fromAccount}} </em> 
                                        @endif
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
        </div>
    </div>

@endsection
