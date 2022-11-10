@extends('admin.layouts.app')
@section('admin-title')
    Zoom Meetings
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Zoom Meetings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Zoom Meetings</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Zoom meetings</h4>
                            <div class="text-right">
                                <a href="/admin/zoom/meetings/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Meeting </button></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="user-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Meeting ID</th>
                                        <th>Meeting Topic</th>
                                        <th>Meeting Type</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @php($i=1)
                                    @foreach($meetings as $meeting)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$meeting['id']}}</td>
                                        <td>{{$meeting['topic']}}</td>
                                        <td>{{$meeting['type']}}</td>
                                        <td>{{$meeting['time'] ?? ''}}</td>
                                        <td class="classroom-btn" width="160">
                                            <a href="/admin/zoom/meetings/{{$meeting['id']}}" class="btn btn-primary">Show</a>
                                            <a href="/admin/zoom/meetings/{{$meeting['id']}}/edit" class="btn btn-danger">Edit</a>
                                            <form id="delete-form-{{$meeting['id']}}" action="/admin/zoom/meetings/{{$meeting['id']}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$meeting['id']}});" class="btn btn-warning">Delete</a>
                                            </form>
                                        </td>
                                    </tr>
                                    @php($i++)
                                    @endforeach
                                </tbody>                         
                                
                            </table>
                            <script type="text/javascript">
                                function deleteData(id)
                                {
                                    if(confirm('Are You Sure? ')){
                                        document.getElementById('delete-form-'+id).submit();
                                    }
                                }
                            </script>
                            <hr>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
