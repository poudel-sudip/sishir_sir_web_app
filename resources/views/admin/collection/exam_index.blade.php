@extends('admin.layouts.app')
@section('admin-title')
    Exam Wallet Collections
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Exam Wallet Collections</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/wallet-collection">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wallet Collections</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Exam Wallets:</h4>
                            <div class="text-right">
                                <a href="/admin/wallet-collection/booking-type/exam/filter" class="btn btn-success">Filter</a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th width="40">SN</th>
                                        <th>Wallet</th>
                                        <th>Count</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i=1)
                                    @foreach($exam_bookings_wallet as $row)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td class="text-wrap">{{$row->mode}}</td>
                                            <td class="text-wrap">{{number_format($row->count)}}</td>
                                            <td class="text-wrap">{{number_format($row->amount)}}</td>                                        
                                        </tr>
                                        @php($i++)
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th class="text-wrap">Total</th>
                                        <th class="text-wrap">{{number_format($exam_bookings_wallet->sum('count'))}}</th>
                                        <th class="text-wrap">{{number_format($exam_bookings_wallet->sum('amount'))}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Exam Sets:</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-asc-table">
                                <thead>
                                    <tr>
                                        <th width="40">SN</th>
                                        <th>Exam</th>
                                        <th>Count</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i=1)
                                    @foreach($exam_bookings_category as $row)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td class="text-wrap">{{$row->exam_name}}</td>
                                            <td class="text-wrap">{{number_format($row->count)}}</td>
                                            <td class="text-wrap">{{number_format($row->amount)}}</td>                                        
                                        </tr>
                                        @php($i++)
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th class="text-wrap">Total</th>
                                        <th class="text-wrap">{{number_format($exam_bookings_category->sum('count'))}}</th>
                                        <th class="text-wrap">{{number_format($exam_bookings_category->sum('amount'))}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
