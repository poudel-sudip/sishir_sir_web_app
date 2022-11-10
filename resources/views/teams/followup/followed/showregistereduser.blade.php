@extends('teams.layouts.app')
@section('admin-title')
    Show User Followup
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show User Followup</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/team/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/team/followup/followed') }}">Followups</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/team/followup/followed/registered-users') }}">Users</a></li>
              <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Followup Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>User ID:</div>
                            <div>{{$followup->user->id ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>User Full Name:</div>
                            <div>{{$followup->user->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>User Email:</div>
                            <div>{{$followup->user->email ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>User Contact:</div>
                            <div>{{$followup->user->contact ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Followup Status:</div>
                            <div>{{$followup->status ?? ''}}</div>
                        </div>
                       
                        <div class="m-4">
                            <div class="h5 m-2">Followup Remarks</div>
                            <div>
                                <table class="table table-fluid">
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Remark</th>
                                        <th>Status</th>
                                    </tr>
                                    @php($i=1)
                                    @php($remarks = json_decode($followup->remarks))
                                    @foreach($remarks as $remark)
                                    @php($row = json_decode($remark))
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{date("Y-m-d g:i a",strtotime($row->date))}}</td>
                                        <td>{{$row->rem ?? ''}}</td>
                                        <td>{{$row->status ?? ''}}</td>
                                    </tr>
                                    @php($i++)
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        
    </div>
@endsection
