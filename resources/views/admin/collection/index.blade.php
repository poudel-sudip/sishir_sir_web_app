@extends('admin.layouts.app')
@section('admin-title')
    All Wallet Collections
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Wallet Collections</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Wallet Collections</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Wallet Type Collection:</h4>
                        </div>
                        <div class="row align-items-center justify-content-center">
                            @php($counter = 1)
                            @foreach($wallet_type as $row)
                                <div class="col-6 col-md-4">
                                    <a href="javascript:void(0);" class="rounded p-2 d-inline-block border shadow card-bg-{{$counter}}">
                                        <div class="">Wallet: {{$row->type}}</div>
                                        <div class="">Count: {{number_format($row->count)}}</div>
                                        <div class="">Amount: {{number_format($row->amount)}}</div>
                                    </a>
                                </div>
                                @php($counter++)
                            @endforeach
                            @php($counter = 1)
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin">
                <div class="card border border-danger">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Booking Type Collection:</h4>
                        </div>
                        <div class="row align-items-center justify-content-center">
                            @php($counter = 5)
                            @foreach($booking_type as $row)
                                <div class="col-6 col-md-4">
                                    <a href="{{$row->link}}" class="rounded p-2 d-inline-block border shadow card-bg-{{$counter}}">
                                        <div class="">Type: {{$row->type}}</div>
                                        <div class="">Count: {{number_format($row->count)}}</div>
                                        <div class="">Amount: {{number_format($row->amount)}}</div>
                                    </a>
                                </div>
                                @php($counter--)
                            @endforeach
                            @php($counter = 1)
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
