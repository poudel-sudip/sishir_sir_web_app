@extends('teams.layouts.app')
@section('admin-title')
    Show Admin Form Applicant Followup
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Admin Form Applicant Followup</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/team/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/team/followup/followed') }}">Followups</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/team/followup/followed/admin-forms') }}">Admin Forms</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/team/followup/followed/admin-forms/'.$assign->id.'/applicants') }}">Applicants</a></li>
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
                            <div>Applicant ID:</div>
                            <div>{{$followup->applicant->id ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Full Name:</div>
                            <div>{{$followup->applicant->name ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Email:</div>
                            <div>{{$followup->applicant->email ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div> Contact:</div>
                            <div>{{$followup->applicant->contact ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div> Sub Category:</div>
                            <div>{{$followup->applicant->sub_category ?? ''}}</div>
                        </div>
                        <div class="course-row">
                            <div>Applicant Message:</div>
                            <div>{{$followup->applicant->message ?? ''}}</div>
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
