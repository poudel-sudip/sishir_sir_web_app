@extends('admin.layouts.app')
@section('admin-title')
    {{$status}} Booking List
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{$status}} Bookings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/course-bookings') }}">Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$status}}</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All {{$status}} Bookings</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered all-entries-table">
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
                                        <td>{{$booking->user->name ?? ''}}</td>
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
                                            <a href="/admin/course-bookings/{{$booking->id}}" class="btn btn-primary">Show</a>
                                            <a href="/admin/course-bookings/{{$booking->id}}/edit" class="btn btn-warning">Edit</a>
                                            <form id="delete-form-{{$booking->id}}" action="/admin/course-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-danger">Delete</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            
                        </div>

                        <div class="mt-2">
                            {{$bookings->onEachSide(1)->links('paginator.bootstrap')}}
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
