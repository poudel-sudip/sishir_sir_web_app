@extends('admin.layouts.app')
@section('admin-title')
    My Books
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">My Books</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">My Books </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">My Books</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/books/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Book </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Book Title</th>
                            <th>Price</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($books as $row)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">{{ucwords($row->title ?? '')}}</td>
                            <td><s class="text-danger mr-2">{{$row->price ?? ''}} </s> <span class="ml-2 text-primary">{{$row->price - $row->discount}}</span> </td>
                            <td>{{$row->order}} </td>
                            <td><span class='text-{{$row->status == "Active" ? "success" : "danger"}}'>{{$row->status}}</span></td>
                            <td class="classroom-btn" width="100">
                              <a href="/admin/books/{{$row->id}}" class="btn btn-primary">Show</a>
                              <a href="/admin/books/{{$row->id}}/edit" class="btn btn-warning">Edit</a>
                              <form id="delete-form-{{$row->id}}" action="/admin/books/{{$row->id}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="btn btn-danger">Delete</a>
                              </form>
                            </td>
                          </tr>
                          @php($i++)
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

