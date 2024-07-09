@extends('admin.layouts.app')
@section('admin-title')
    PDF Bank Wallet Collections Filter
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">PDF Bank Wallet Collections Filter</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/wallet-collection">Wallet Collections</a></li>
                <li class="breadcrumb-item"><a href="/admin/wallet-collection/booking-type/pdf-bank">PDF Banks</a></li>
                <li class="breadcrumb-item active" aria-current="page">Filter</li>
              </ol>
            </nav>
        </div>  

        <div class="row">

            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Filter Collection Report</h4>  
                        <form action="/admin/wallet-collection/booking-type/pdf-bank/filter" class="row align-items-center text-center justify-content-center">
                            <div class="col-12 col-sm-6 col-md-3 col-lg-2 m-1 row text-nowrap align-items-center ">
                                <label for="start_date" class="col-12">Start Date: </label>
                                <input type="date" id="start_date" name="start_date" class="col-12 p-1 rounded d-inline-block border-primary">
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-2 m-1 row text-nowrap align-items-center ">
                                <label for="end_date" class="col-12">End Date: </label>
                                <input type="date" id="end_date" name="end_date" class="col-12 p-1 rounded d-inline-block border-primary">
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-2 m-1 row text-nowrap align-items-center ">
                                <label for="pdf_bank_id" class="col-12">PDF Bank: </label>
                                <select name="pdf_bank_id" id="pdf_bank_id" class="col-12 p-1 rounded d-inline-block border-primary">
                                    <option value=""></option>
                                    @if(isset($pdf_bank_groups))
                                        @foreach($pdf_bank_groups as $row)
                                            <option value="{{$row->id}}">{{$row->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-2 m-1 row text-nowrap align-items-center ">
                                <label for="wallet" class="col-12">Wallet: </label>
                                <select name="wallet" id="wallet" class="col-12 p-1 rounded d-inline-block border-primary">
                                    <option value=""></option>
                                    <option value="Cash">Cash</option>
                                    <option value="Esewa">Esewa</option>
                                    <option value="Fonepay">Fonepay</option>
                                    <option value="Bank">Bank</option>
                                    
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-2 m-1 row text-nowrap align-items-center ">
                                <label for="data_type" class="col-12">Result Type: </label>
                                <select name="data_type" id="data_type" class="col-12 p-1 rounded d-inline-block border-primary">
                                    <option value="all">All</option>
                                    <option value="wallet">Wallet Only</option>
                                    <option value="pdf-bank">PDF Bank Only</option>
                                    <option value="details">Details Only</option>                                    
                                    <option value="wallet-pdf-bank">Wallet and PDF Bank </option>                                    
                                    <option value="wallet-details">Wallet and Booking Details</option>                                    
                                    <option value="pdf-bank-details">PDF Bank and Booking Details</option>                                    
                                </select>
                            </div>
                            <div class="col-12 m-1 ">
                                <button type="submit" class="btn btn-info">Fetch</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(isset($fetchdata) && $fetchdata == true)
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Data Filtered</h4>     
                            <div class="d-flex mx-md-3 justify-content-around">
                                {!! $filterkeys !!}    
                            </div>                       
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($pdf_bank_bookings_wallet))
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="custon-table-header">
                                <h4 class="card-title">PDF Bank Wallets:</h4>                           
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
                                        @foreach($pdf_bank_bookings_wallet as $row)
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
                                            <th class="text-wrap">{{number_format($pdf_bank_bookings_wallet->sum('count'))}}</th>
                                            <th class="text-wrap">{{number_format($pdf_bank_bookings_wallet->sum('amount'))}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($pdf_bank_bookings_groups))
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="custon-table-header">
                                <h4 class="card-title">PDF Banks:</h4>
                            </div>
                            <div class="table-responsive table-responsive-md">
                                <table class="table table-bordered" id="advanced-asc-table">
                                    <thead>
                                        <tr>
                                            <th width="40">SN</th>
                                            <th>PDF Bank</th>
                                            <th>Count</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i=1)
                                        @foreach($pdf_bank_bookings_groups as $row)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td class="text-wrap">{{$row->pdf_bank_name}}</td>
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
                                            <th class="text-wrap">{{number_format($pdf_bank_bookings_groups->sum('count'))}}</th>
                                            <th class="text-wrap">{{number_format($pdf_bank_bookings_groups->sum('amount'))}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($pdf_bank_bookings_details))
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="custon-table-header">
                                <h4 class="card-title">Booking Details:</h4>
                            </div>
                            <div class="table-responsive table-responsive-md">
                                <table class="table table-bordered advanced-desc-table" id="advanced-desc-table">
                                    <thead>
                                        <tr>
                                            <th width="40">SN</th>
                                            <th>PDF Bank</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Mode</th>
                                            <th>Date</th>
                                            <th>ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i=1)
                                        @foreach($pdf_bank_bookings_details as $row)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td class="text-wrap">{{$row->book->title ?? ''}}</td>
                                                <td class="text-wrap">{{$row->user->name ?? ''}} <br> {{$row->user->contact ?? ''}} </td>
                                                <td class="text-wrap">{{number_format($row->paymentAmount)}}</td>
                                                <td class="text-wrap">{{$row->verificationMode}}</td>                                        
                                                <td class="text-wrap">{{$row->created_at}}</td>       
                                                <td class="text-wrap">{{$row->id}}</td>                                                                         
                                            </tr>
                                            @php($i++)
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
