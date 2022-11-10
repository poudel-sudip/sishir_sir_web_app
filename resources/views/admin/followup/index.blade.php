@extends('admin.layouts.app')
@section('admin-title')
    Follow Up
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Follow Up Batches</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Follow Up</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Batches</h4>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="user-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Course</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @php($i=1)
                                    @foreach($batches as $batch)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$batch->course->name}}</td>
                                        <td>{{$batch->name}}</td>
                                        <td>{{$batch->status}}</td>
                                        <td class="classroom-btn" width="160">
                                            <a href="/admin/batch/{{$batch->id}}/followup/all" class="btn btn-primary">View</a>
                                        </td>
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
