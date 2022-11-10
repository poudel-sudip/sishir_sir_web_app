@extends('admin.layouts.app')
@section('admin-title')
    Branches
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Branches</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Branches</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Branches</h4>
                            <div class="text-right">
                                <a href="{{ ('/admin/branches/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add Branch</button></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tutor-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Options</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($branches as $branch)
                                <tr>
                                    <td class="text-wrap">{{$branch->id}} | {{$branch->user->id ??''}}</td>
                                    <td class="text-wrap">{{$branch->name}}</td>
                                    <td class="text-wrap">{{$branch->user->email ?? ''}}</td>
                                    <td class="classroom-btn text-wrap">
                                    </td>
                                                                     
                                    <td class="classroom-btn" width="160">
                                        <a href="/admin/branches/{{$branch->id}}" class="btn btn-info">Show</a>
                                        @if(auth()->user()->permission>=20)
                                        <a href="/admin/branches/{{$branch->id}}/edit" class="btn btn-danger">Edit</a>
                                        <form id="delete-form-{{$branch->id}}" action="/admin/branches/{{$branch->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$branch->id}});" class="btn btn-warning">Delete</a>
                                        </form>
                                        @endif
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
