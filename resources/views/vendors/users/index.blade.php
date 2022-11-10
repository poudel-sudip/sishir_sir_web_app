@extends('vendors.layouts.app')
@section('admin-title')
    My Users
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">My Users</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Users</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">My Users</h4>
                            <div class="text-right">
                                <a href="{{ ('/vendor/users/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add User </button></a>
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
                                        <th>Provience</th>
                                        <th>District/City</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->user->id ?? ''}}</td>
                                        <td>{{$user->user->name ?? ''}}</td>
                                        <td>{{$user->user->email ?? ''}}</td>
                                        <td>{{$user->user->contact ?? ''}}</td>
                                        <td>{{$user->user->provience ?? ''}}</td>
                                        <td>{{$user->user->district_city ?? ''}}</td>
                                        <td>{{$user->user->status ?? ''}}</td>
                                        
                                        <td class="classroom-btn" width="160">
                                            <a href="/vendor/users/{{$user->id}}" class="btn btn-primary">Show</a>
                                            <a href="/vendor/users/{{$user->id}}/edit" class="btn btn-danger">Edit</a>
                                            @if(!isset($user->user) || (!$user->user->bookings->count() && !$user->user->exam_bookings->count() && !$user->user->video_bookings->count() && !$user->user->ebook_bookings->count() ))
                                            <form id="delete-form-{{$user->id}}" action="/vendor/users/{{$user->id}}" method="POST" style="display: inline">
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
