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
                                <a href="{{ ('/admin/users/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Users </button></a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered all-desc-table" id="search_users_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Action</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Province</th>
                                        <th>District</th>
                                        <th>B Group</th>
                                        <th>B Donate</th>
                                        <th>Role</th>
                                        {{-- <th class="text-wrap">Created Date</th> --}}
                                    </tr>
                                </thead>       
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td width="50">
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                                    <a href="/admin/users/{{$user->id}}" class="text-primary dropdown-item">Show</a>
                                                    <a href="/admin/users/{{$user->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                                    <form id="delete-form-{{$user->id}}" action="/admin/users/{{$user->id}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:{}" onclick="javascript:deleteData({{$user->id}});" class="text-warning dropdown-item">Delete</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-wrap">{{$user->name}}</td>
                                        <td class="text-wrap">{{$user->email}}</td>
                                        <td class="text-wrap">{{$user->contact}}</td>
                                        <td class="text-wrap">{{$user->provience}}</td>
                                        <td class="text-wrap">{{$user->district_city}}</td>
                                        <td class="text-wrap">{{$user->blood_group}}</td>
                                        <td class="text-wrap">{{$user->donate_blood ? 'Yes' : 'No'}}</td>
                                        <td>
                                            @if($user->role == 'Admin')
                                            <span class="text-primary">{{$user->role}}</span>
                                            @elseif($user->role == 'Moderator')
                                            <span class="text-danger">{{$user->role}}</span>
                                            @else
                                            <span class="text-success">{{$user->role}}</span>
                                            @endif
                                        </td>
                                        {{-- <td class="text-wrap">{{$user->created_at}}</td> --}}
                                        
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
                        {{-- <div class="mt-2">
                            {{$users->onEachSide(1)->links('paginator.bootstrap')}}
                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            const table_source = "/admin/users?json_type=1";
            $('#search_users_table').DataTable().destroy();
            $('#search_users_table').DataTable({
                searching: true,
                ordering: true,
                paging: true,
                info: true,
                lengthChange: true,
                processing: true,
                serverSide: true,
                ajax: table_source,
                columns: [
                    { data: 'id'},
                    { data: 'action', orderable: false, searchable: false },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'contact' },
                    { data: 'provience' },
                    { data: 'district_city' },
                    { data: 'blood_group' },
                    { data: 'donate_blood' },
                    { data: 'role' },
                ],
                columnDefs: [
                    {
                        targets: '_all',
                        className: 'text-start text-wrap'
                    },
                ],
                order: [[0, 'desc']], 
                lengthMenu: [[50, 100, 200, 500], [50, 100, 200, 500]],
                pageLength: 50, 

            });

        });
    </script>
@endsection
