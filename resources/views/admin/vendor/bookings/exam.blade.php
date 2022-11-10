@extends('admin.layouts.app')
@section('admin-title')
    Vendor Exam Bookings
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Vendor Exam Bookings</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/vendor') }}">Vendors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Exam Bookings</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                          <h4 class="card-title">{{$vendor->name}} | Exam Bookings</h4>
                        </div>
                        <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="main-booking-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Exam Name</th>
                                <th>Booked By</th>
                                <th>Email</th>
                                <th>Due Amount</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->booking->id}}</td>
                                <td>{{date('Y-m-d',strtotime($booking->created_at))}}</td>
                                <td>{{$booking->booking->category->title ?? '' }}</td>
                                <td>{{$booking->booking->user_name}}</td>
                                <td>{{ $booking->booking->user->email ?? '' }}</td>
                                <td>
                                    @if($booking->booking->status == 'Verified' && $booking->booking->dueAmount>10)
                                        Rs. {{ $booking->booking->dueAmount ?? '0' }}
                                    @endif
                                </td>
                               
                                <td>
                                    @if($booking->booking->status == 'Verified')
                                    <span class="text-success">{{$booking->booking->status}}</span>
                                    @else
                                    <span class="text-warning">{{$booking->booking->status}}</span>
                                    @endif
                                </td>
                                <td class="text-wrap" max-width="150px">{{ $booking->booking->remarks }}</td>
                                {{-- <td class="classroom-btn" width="150">
                                    <a href="/admin/exam-hall/bookings/{{$booking->booking->id}}" class="btn btn-primary">Show</a>
                                    @if(auth()->user()->permission>=40)
                                    <a href="/admin/exam-hall/bookings/{{$booking->booking->id}}/edit" class="btn btn-danger">Edit</a>
                                    <form id="delete-form-{{$booking->id}}" action="/admin/exam-hall/bookings/{{$booking->booking->id}}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-warning">Delete</a>
                                    </form>
                                    @endif
                                </td> --}}
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {{-- <script type="text/javascript">
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
                        </script> --}}
                        <hr>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
