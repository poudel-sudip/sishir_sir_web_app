@extends('admin.layouts.app')
@section('admin-title')
    SMS 
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">SMS</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">SMS</li>
              </ol>
          </nav>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                    @endif
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All SMS</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/sms/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add SMS</button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>SMS Message</th>
                                        <th>Group</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>{{date('Y-m-d H:i:s',strtotime($message->created_at))}}</td>
                                        <td class="text-wrap"> {{$message->message}} </td>
                                        <td class="text-wrap">{{$message->groups}}</td>
                                    </tr>
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
