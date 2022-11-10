@extends('vendors.layouts.app')
@section('admin-title')
    Latest 300 Course Bookings
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Latest 300 Course Bookings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Course Bookings</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Latest 300 Course Bookings</h4>
                          <div class="text-right">
                              <a href="{{ ('/vendor/bookings/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Booking </button></a>
                          </div>
                      </div>
                        @if(session('error_message'))
                            <div class="form-group row">
                                <div class="col-12 alert alert-danger">{{ session('error_message') }}</div>
                            </div>
                        @endif
                        @if(session('success_message'))
                            <div class="form-group row">
                                <div class="col-12 alert alert-success">{{ session('success_message') }}</div>
                            </div>
                        @endif
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="main-booking-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Course Name</th>
                                <th>Batch Name</th>
                                <th>Booked By</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->booking->id ?? ''}}</td>
                                <td>{{date('Y-m-d',strtotime($booking->booking->created_at ?? ''))}}</td>
                                <td class="text-wrap">{{$booking->booking->course->name ?? ''}}</td>
                                <td class="text-wrap">{{$booking->booking->batch->name ?? ''}}</td>
                                <td>{{$booking->booking->user_name ?? ''}}</td>
                                <td>{{ $booking->booking->user->email ?? ''}}</td>
                                <td>{{ $booking->booking->user->contact ?? ''}}</td>
                                                               
                                <td>
                                    @if(isset($booking->booking->status) && $booking->booking->status == 'Verified')
                                    <span class="text-success">{{$booking->booking->status ?? ''}}</span>
                                    @else
                                    <span class="text-warning">{{$booking->booking->status ?? ''}}</span>
                                    @endif
                                </td>
                                <td class="text-wrap" max-width="150px">{{ $booking->booking->remarks ?? '' }}</td>
                                <td class="classroom-btn" width="150">
                                    <a href="/vendor/bookings/{{$booking->id}}" class="btn btn-primary">Show</a>
                                    <a href="/vendor/bookings/{{$booking->id}}/edit" class="btn btn-danger">Edit</a>
                                    @if((!isset($booking->booking->status)) || (isset($booking->booking->status) && $booking->booking->status != 'Verified'))
                                    <form id="delete-form-{{$booking->id}}" action="/vendor/bookings/{{$booking->id}}" method="POST" style="display: inline">
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
                        <hr>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
