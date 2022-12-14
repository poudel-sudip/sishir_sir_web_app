@extends('admin.layouts.app')
@section('admin-title')
    Verify List
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Verify List</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Verify</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Bookings Verification Requests</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Batch</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{$booking->id}}</td>
                                        <td>{{date('Y-m-d',strtotime($booking->created_at))}}</td>
                                        <td>{{$booking->batch->name ?? ''}}</td>
                                        <td>{{$booking->user_name}}</td>
                                        <td>{{$booking->user->email ?? ''}}</td>
                                        <td>{{$booking->user->contact ?? ''}}</td>
                                        
                                        <td>
                                            @if($booking->status == 'Verified')
                                            <span class="text-success">{{$booking->status}}</span>
                                            @elseif($booking->status == 'Unverified')
                                            <span class="text-warning">{{$booking->status}}</span>
                                            @else
                                            <span class="text-info">{{$booking->status}}</span>
                                            @endif
                                        </td>
                                        <td class="classroom-btn" width="170">
                                            <a href="/admin/bookings/{{$booking->id}}" class="btn btn-primary">Show</a>
                                            @if(auth()->user()->permission>=40)
                                            <a href="/admin/bookings/{{$booking->id}}/edit" class="btn btn-danger">Verify</a>
                                            <form id="delete-form-{{$booking->id}}" action="/admin/bookings/{{$booking->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-warning">Delete</a>
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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
