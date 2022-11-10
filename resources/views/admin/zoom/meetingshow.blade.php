@extends('admin.layouts.app')
@section('admin-title')
    Zoom Meeting
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Show Meeting</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/zoom/meetings') }}">Zoom Meetings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Show</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">View Meeting Details</div>
                    <div class="card-body">
                        <div class="course-row">
                            <div>Meeting ID:</div>
                            <div>{{ $meeting->id }}</div>
                        </div>
                        <div class="course-row">
                            <div>Meeting Topic:</div>
                            <div>{{$meeting->topic}}</div>
                        </div>
                        <div class="course-row">
                            <div>Meeting Type:</div>
                            <div>{{$meeting->type}}</div>
                        </div>
                        <div class="course-row">
                            <div>Batch Time Slot:</div>
                            <div>{{$meeting->batch_time}}</div>
                        </div>
                        <div class="course-row">
                            <div>Status:</div>
                            <div>{{$meeting->status}}</div>
                        </div>
                        <div class="course-row">
                            <div>Join URL:</div>
                            <div>{{$meeting->join_url}}</div>
                        </div>
                        <div class="course-row">
                            <div>Action:</div>
                            <div>
                                <a href="{{$meeting->start_url}}" target="_blank" class="btn btn-success">Start Meeting</a>
                                <a href="{{$meeting->join_url}}" target="_blank" class="btn btn-primary">Join Meeting</a>
                                <a href="/admin/zoom/meetings/{{$meeting->id}}/edit" class="btn btn-warning">Edit Meeting</a>
                                <form id="delete-form-{{$meeting->id}}" action="/admin/zoom/meetings/{{$meeting->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$meeting->id}});" class="btn btn-danger">Delete Meeting</a>
                                </form>          
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function deleteData(id)
            {
                if(confirm('Are You Sure? ')){
                    document.getElementById('delete-form-'+id).submit();
                }
            }
        </script>
    </div>
@endsection
