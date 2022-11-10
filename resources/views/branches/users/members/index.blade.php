@extends('branches.layouts.app')
@section('admin-title')
    Branch Members
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Branch Members</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/branch/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Branch Members</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title"> Branch members</h4>
                            <div class="text-right">
                                <a href="{{ ('/branch/members/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Member </button></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="user-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @foreach($members as $user)
                                    <tr>
                                        <td>{{$user->id ?? ''}} | {{$user->user->id ?? ''}} </td>
                                        <td>{{$user->name ?? ''}}</td>
                                        <td>{{$user->user->email ?? ''}}</td>
                                        <td>{{$user->user->contact ?? ''}}</td>
                                        <td>{{$user->role ?? ''}}</td>
                                        <td class="classroom-btn" width="160">
                                            <a href="/branch/members/{{$user->id}}/edit" class="btn btn-info">Edit</a>
                                            <form class="d-inline" id="delete-form-{{$user->id}}" action="/branch/members/{{$user->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$user->id}});" class="btn btn-danger">Delete</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>                         
                                
                            </table>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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
    
@endsection
