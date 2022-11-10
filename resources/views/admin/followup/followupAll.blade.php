@extends('admin.layouts.app')
@section('admin-title')
   Batch Follow Up
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Follow Up: {{$batch->course->name.' / '.$batch->name}} </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/followup') }}">Follow Up</a></li>
              <li class="breadcrumb-item active" aria-current="page">List</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <a href="/admin/batch/{{$batch->id}}/followup/all"><button type="button" class="m-1 btn btn-primary"> All Users </button></a>
                            <a href="/admin/batch/{{$batch->id}}/followup/batch"><button type="button" class="m-1 btn btn-warning"> Batch Users </button></a>
                            <a href="/admin/batch/{{$batch->id}}/followup/followed"><button type="button" class="m-1 btn btn-danger"> Followed Users </button></a>
                        </div>
                        <div class="custon-table-header">
                            <h4 class="card-title">All Followup Users</h4>
                            <div class="text-right">
                                    <a href="/admin/batch/{{$batch->id}}/followup/all/download"><button type="button" class="btn btn-sm ml-3 btn-success"> Download </button></a>
                            </div>                           
                        </div>
                        
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="user-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Interests</th>
                                        <th>Prev. Bookings</th>
                                        <th>Remarks</th>
                                        @if($batch->status!="Closed")
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>       
                                <tbody>
                                    @php($i=1)
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->contact}}</td>
                                        <td class="text-wrap">{{$user->interests}}</td>
                                        <td class="text-wrap">{{$user->courses}}</td>
                                        <td  style="min-width:300px !important"> {!! $user->remarks !!} </td>
                                        @if($batch->status!="Closed")
                                        <td class="classroom-btn" width="160">
                                            <a href="/admin/batch/{{$batch->id}}/{{$user->user_id}}/followup" class="btn btn-primary">Add</a>
                                        </td>
                                        @endif
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
