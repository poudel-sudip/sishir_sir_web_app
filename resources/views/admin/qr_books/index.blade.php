@extends('admin.layouts.app')
@section('admin-title')
  My QR Generated Books
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">My QR Generated Books</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">My QR Generated Books </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">My QR Generated Books</h4>
              <div class="text-right">
                <a href="{{ ('/admin/qr-books/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Book </button></a>
              </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-desc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Category</th>
                    <th>Publisher</th>
                    <th>Book</th>
                    <th>Edition</th>
                    <th>Pub. Year</th>
                    <th>Quantity</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($books as $row)
                    <tr>
                      <td>{{$i}}</td>
                      <td class="text-wrap">{{ucwords($row->category ?? '')}}</td>
                      <td class="text-wrap">{{ucwords($row->title ?? '')}}</td>
                      <td class="text-wrap">{{ucwords($row->publisher ?? '')}}</td>
                      <td>{{$row->edition}} </td>
                      <td>{{$row->published_year}} </td>
                      <td><a href="/admin/qr-books/{{$row->id}}/scans">Show ({{$row->quantity}})</a></td>
                      <td class="classroom-btn" width="100">
                        <a href="/admin/qr-books/{{$row->id}}/show" class="btn btn-primary">Show</a>
                        <a href="/admin/qr-books/{{$row->id}}/edit" class="btn btn-warning">Edit</a>
                        <form id="delete-form-{{$row->id}}" action="/admin/qr-books/{{$row->id}}" method="POST" class="d-inline">
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
          );
        }
      });
    }
  </script>

@endsection

