@extends('admin.layouts.app')
@section('admin-title')
    Publishers
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Publishers</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Publishers</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Publishers</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission>=20)
                                <a href="{{ ('/admin/publishers/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Add Publisher</button></a>
                                @endif
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
                                        <th>Partnership Mode</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($publishers as $publisher)
                                <tr>
                                    <td class="text-wrap">{{$publisher->id}}</td>
                                    <td class="text-wrap">{{$publisher->name}}</td>
                                    <td class="text-wrap">{{$publisher->user->email ?? ''}}</td>
                                    <td class="text-wrap">{{$publisher->user->contact ?? ''}}</td>
                                    <td class="text-wrap text-center">{{$publisher->partner_mode}} ({{$publisher->mode_value}}) </td>
                                    <td class="text-wrap text-center">{{$publisher->user->status ?? ''}}</td>
                                    <td class="classroom-btn" width="50">
                                        <a href="/admin/publishers/{{$publisher->id}}/books"  class="btn btn-primary">Books</a>

                                    </td>
                                                                     
                                    <td class="classroom-btn text-center">
                                        <a href="/admin/publishers/{{$publisher->id}}" class="m-1 btn btn-info">Show</a> <br>
                                        @if(auth()->user()->permission>=20)
                                        <a href="/admin/publishers/{{$publisher->id}}/edit" class="m-1 btn btn-warning">Edit</a> <br>
                                        <form id="delete-form-{{$publisher->id}}" action="/admin/publishers/{{$publisher->id}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$publisher->id}});" class="m-1 btn btn-danger">Delete</a>
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
