@extends('admin.layouts.app')
@section('admin-title')
    Specail Course Bookings
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Tutor Special Course Bookings</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors">Tutors</a></li>
                <li class="breadcrumb-item"><a href="/admin/tutors/{{$tutor->id}}/courses">Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bookings</li>
                </ol>
            </nav>
        </div> 
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">{{$course->course}} Bookings</h4>
                          <!-- <div class="text-right">
                            @if(auth()->user()->permission>=40)
                              <a href="{{ ('/admin/bookings/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Booking </button></a>
                            @endif
                          </div> -->
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="booking-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Course Name</th>
                                <th>Booked By</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Due Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($bookings as $booking)
                            <tr style="@if($booking->suspended) color:red !important @endif">
                                <td>{{$booking->id}}</td>
                                <td>{{date('Y-m-d',strtotime($booking->created_at))}}</td>
                                <td>{{$booking->course->course ?? ''}}</td>
                                <td>{{$booking->user_name}}</td>
                                <td>{{$booking->user->email ?? ''}}</td>
                                <td>{{$booking->user->contact ?? ''}}</td>
                                <td>
                                    @if($booking->status == 'Verified' && $booking->dueAmount>0)
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
                                <td class="classroom-btn" width="150">
                                    <a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/bookings/{{$booking->id}}" class="btn btn-primary">Show</a>
                                    @if(auth()->user()->permission>=40)
                                    <a href="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/bookings/{{$booking->id}}/edit" class="btn btn-danger">Edit</a>
                                    <form id="delete-form-{{$booking->id}}" action="/admin/tutors/{{$tutor->id}}/courses/{{$course->id}}/bookings/{{$booking->id}}" method="POST" style="display: inline">
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
