@extends('admin.layouts.app')
@section('admin-title')
    Notifications
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Notifications</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Notifications</li>
              </ol>
          </nav>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Notifications</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/notifications/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add Notifications</button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Notification</th>
                                        <th>Group</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $notification)
                                <tr>
                                    <td>{{$notification->id}}</td>
                                    <td class="text-wrap"><h5>{{$notification->title}}</h5></td>
                                    <td class="text-wrap">{{$notification->groups}}</td>
                                    <td>{{date('Y-m-d',strtotime($notification->created_at))}}</td>
                                    <td class="classroom-btn" width="160">
                                        <a href="/admin/notifications/{{$notification->id}}" class="btn btn-primary">Show</a>
                                        <a href="/admin/notifications/{{$notification->id}}/edit" class="btn btn-danger">Edit</a>
                                        <form id="delete-form-{{$notification->id}}" action="/admin/notifications/{{$notification->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$notification->id}});" class="btn btn-warning">Delete</a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                function deleteData(id)
                                {
                                    Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    document.getElementById('delete-form-'+id).submit();
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    }
                                })
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
