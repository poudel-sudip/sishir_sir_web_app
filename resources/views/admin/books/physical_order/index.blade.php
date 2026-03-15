@extends('admin.layouts.app')
@section('admin-title')
    Physical Book Orders
@endsection


@section('content')
  <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Physical Book  Orders</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Physical Book  Orders</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                        <h4 class="card-title">Physical Book Orders</h4>
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="advanced-desc-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Action</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Publisher</th>
                                <th>Book</th>
                                <th>User</th>
                                <th>D. Location</th>
                                <th>Quantity</th>
                                <th>Unit Rate</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($orders as $row)
                                <tr>
                                    <td class="text-wrap">{{$row->id}} </td>
                                    <td>
                                      <div class="dropdown">
                                          <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                              <a href="/admin/physical-book-orders/{{$row->id}}" class="text-primary dropdown-item">Show</a>
                                              <form id="delete-form-{{$row->id}}" action="/admin/physical-book-orders/{{$row->id}}" method="POST">
                                                  @csrf
                                                  @method('DELETE')
                                                  <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="text-warning dropdown-item">Delete</a>
                                              </form>
                                          </div>
                                      </div>
                                    </td>
                                    <td class="text-wrap">{{date('Y-m-d',strtotime($row->created_at))}}</td>
                                    <td class="text-wrap">{{$row->book_category ?? ''}}</td>
                                    <td class="text-wrap">{{$row->book_publisher ?? ''}}</td>
                                    <td class="text-wrap">{{$row->book_title ?? ''}}</td>
                                    <td class="text-wrap">{{$row->name ?? ''}} <br> ({{$row->contact ?? ''}})</td>
                                    <td class="text-wrap">{{$row->location}}</td>
                                    <td class="text-wrap">{{$row->quantity}}</td>
                                    <td class="text-wrap">{{$row->unit_price}}</td>     
                                                                
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
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
        confirmButtonText: 'Yes, Delete it!'
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
