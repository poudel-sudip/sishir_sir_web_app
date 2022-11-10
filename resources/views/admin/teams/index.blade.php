@extends('admin.layouts.app')
@section('admin-title')
    Teams
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Teams</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Teams</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Teams</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/teams/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add Team </button></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tutor-table">
                                <thead>
                                    <tr class="text-center">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $team)
                                <tr>
                                    <td class="text-wrap">{{$team->id}}</td>
                                    <td class="text-wrap">{{$team->user->name ?? ''}}</td>
                                    <td class="text-wrap">{{$team->user->email ?? ''}}</td>
                                    <td class="text-wrap">{{$team->user->contact ?? ''}}</td>
                                    <td class="text-wrap">{{$team->vendor->name ?? '-'}}</td>
                                    <td class="text-wrap text-center">{{$team->user->status ?? ''}}</td>
                                    <td class="classroom-btn">  </td>
                                                                     
                                    <td class="classroom-btn text-center" width="125">
                                        <a href="/admin/teams/{{$team->id}}" class="btn btn-info">Show</a> 
                                        <a href="/admin/teams/{{$team->id}}/edit" class="btn btn-warning">Edit</a>
                                        <form id="delete-form-{{$team->id}}" action="/admin/teams/{{$team->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$team->id}});" class="btn btn-danger">Delete</a>
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
                                        'Your file record has been deleted.',
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
