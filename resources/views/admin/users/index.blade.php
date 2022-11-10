@extends('admin.layouts.app')
@section('admin-title')
    Users
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Users</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Users</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Users</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission>=50)
                                <a href="{{ ('/admin/users/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Users </button></a>
                                @endif
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
                                        <th class="text-wrap">Interested Course</th>
                                        <th class="text-wrap">Created Date</th>
                                        {{-- <th>Is Online</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->contact}}</td>
                                        <td>
                                            @if($user->role == 'Admin')
                                            <span class="text-primary">{{$user->role}}</span>
                                            @else
                                            <span class="text-success">{{$user->role}}</span>
                                            @endif
                                        </td>
                                        <td class="text-wrap">{{$user->interests}}</td>
                                        <td class="text-wrap">{{$user->created_at}}</td>
                                        {{-- <td>
                                            @if(\Illuminate\Support\Facades\Cache::has('Is-Online-' . $user->id))
                                                <span class="text-success">Yes</span>
                                            @else
                                                <span class="text-secondary">No</span>
                                            @endif
                                        </td> --}}
                                        <td class="classroom-btn" width="160">
                                            <a href="/admin/users/{{$user->id}}" class="btn btn-primary">Show</a>
                                            @if(auth()->user()->permission>=30)
                                            <a href="/admin/users/{{$user->id}}/edit" class="btn btn-danger">Edit</a>
                                            @endif
                                            @if(auth()->user()->permission>=50)
                                            <form id="delete-form-{{$user->id}}" action="/admin/users/{{$user->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$user->id}});" class="btn btn-warning">Delete</a>
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
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    }
                                })
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
