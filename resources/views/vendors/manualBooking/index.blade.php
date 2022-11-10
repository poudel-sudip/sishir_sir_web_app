@extends('vendors.layouts.app')
@section('admin-title')
    Manual Booking
@endsection

@section('content')
<style>
  #main-booking-table{
    width: 100% !important;
  }
  #main-booking-table tr td:nth-child(2),
  #main-booking-table tr td:nth-child(3),
  #main-booking-table tr td:nth-child(6)
  {
    white-space: pre-wrap;
  }
  #main-booking-table #width-fixed{
    width: 110px;
  }
  .btn-manual, .slip-view{
    padding: 2px 5px;
    display: inline;
    font-size: 12px
  }
</style>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manual Booking Requests</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Manual Booking</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="">
                        <h4 class="card-title">Manual Booking Requests of : {{$coverageArea ?? ''}} </h4>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="main-booking-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Provience</th>
                            <th>District</th>
                            <th>Slip</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                          <tr>
                            <td>{{$booking->id}}</td>
                            <td>{{$booking->course->name ?? ''}}</td>
                            <td>{{$booking->name}}</td>
                            <td>{{$booking->email}}</td>
                            <td>{{$booking->mobile}}</td>
                            <td>{{$booking->provience}}</td>
                            <td>{{$booking->district}}</td>
                            <td>
                                <button type="button" data-toggle="modal" class="btn btn-primary slip-view" data-target="#slip-view" data-id="{{ $booking->id }}">
                                  View
                              </button>
                            </td>
                            <td> {{$booking->status}} </td>
                            <td id="width-fixed">
                                <a href="/vendor/manual-bookings/{{$booking->id}}/edit" class=" btn btn-danger btn-manual">Update</a>
                                <form id="delete-form-{{$booking->id}}" action="/vendor/manual-bookings/{{$booking->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$booking->id}});" class="btn btn-warning btn-manual">Delete</a>
                                </form>
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

    {{-- for Image Veiw --}}
<div class="modal fade" id="slip-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Slip: <span id="slip-title"></span></h5>
        <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-danger">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div id="slip-image"></div>
              </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.slip-view', function(){
    const id=$(this).attr('data-id');
    $.ajax({
        url:'/vendor/manual-bookings/'+id,
        dataType: 'json',
        type:'GET',
        success:function(data){
            $('#slip-title').html(data.name);
            $('#slip-image').html("");
            $('#slip-image').append(
                '<img src="/storage/'+data.payment_slip+'" width="100%">'
            )
        }
    })
  })
</script>    
@endsection
