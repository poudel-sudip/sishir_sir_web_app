@extends('admin.layouts.app')
@section('admin-title')
    Due Bookings
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Verified Due Bookings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/bookings') }}">Bookings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Due</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">All Due Bookings</h4>
                          
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="advanced-desc-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Action</th>
                                <th>Date</th>
                                {{-- <th>Course</th> --}}
                                <th>Batch</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Due Amount</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($bookings as $booking)
                            <tr style="@if($booking->suspended) color:red !important @endif">
                                <td>{{$booking->id}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                            <a href="/admin/bookings/{{$booking->id}}" class="text-primary dropdown-item">Show</a>
                                            <a href="/admin/bookings/{{$booking->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                            <form id="delete-form-{{$booking->id}}" action="/admin/bookings/{{$booking->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="text-warning dropdown-item">Delete</a>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>{{date('Y-m-d',strtotime($booking->created_at))}}</td>
                                {{-- <td class="text-wrap">{{$booking->course->name ?? ''}}</td> --}}
                                <td class="text-wrap">{{$booking->batch->name ?? ''}}</td>
                                <td class=""> {{$booking->user_name}}</td>
                                <td class="text-wrap">{{ $booking->user->email ?? '' }}</td>
                                <td class="text-wrap">{{ $booking->user->contact ?? '' }}</td>
                                <td>
                                    @if($booking->status == 'Verified' && $booking->dueAmount>10)
                                        Rs. {{ $booking->dueAmount ?? '0' }}
                                    @endif
                                </td>
                                <td>
                                    @if($booking->status == 'Verified')
                                    <span class="text-success">{{$booking->status}}</span>
                                    @else
                                    <span class="text-warning">{{$booking->status}}</span>
                                    @endif
                                </td>
                                <td class="text-wrap" max-width="150px">{{ $booking->remarks }}</td>
                                
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
