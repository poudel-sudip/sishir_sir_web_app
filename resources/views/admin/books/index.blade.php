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
                        {{-- <div class="text-right">
                            <a href="{{ ('/admin/books/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Book </button></a>
                        </div> --}}
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Action</th>
                            <th>Category</th>
                            <th>Book Title</th>
                            <th>Publisher</th>
                            <th>Final Price</th>
                            <th>Edition</th>
                            <th>Pub. Year</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($books as $row)
                          <tr>
                            <td>{{$i}}</td>
                            <td>
                              <div class="dropdown">
                                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                      <a href="/admin/books/{{$row->id}}/reviews" class="text-info dropdown-item">Reviews</a>
                                      <a href="/admin/books/{{$row->id}}" class="text-primary dropdown-item">Show</a>
                                      <a href="/admin/books/{{$row->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                      <form id="delete-form-{{$row->id}}" action="/admin/books/{{$row->id}}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="text-warning dropdown-item">Delete</a>
                                      </form>
                                  </div>
                              </div>
                            </td>
                            <td class="text-wrap">{{ucwords($row->category->name ?? '')}}</td>
                            <td class="text-wrap">{{ucwords($row->title ?? '')}}</td>
                            <td class="text-wrap">{{ucwords($row->publisher->name ?? '')}}</td>
                            <td><s class="text-danger mr-2">{{$row->price ?? ''}} </s> <span class="ml-2 text-primary">{{($row->price - (($row->price*$row->discount)/100))}}</span> </td>
                            <td>{{$row->edition}} </td>
                            <td>{{$row->published_year}} </td>
                            <td><span class='text-{{$row->status == "Active" ? "success" : "danger"}}'>{{$row->status}}</span></td>
                            
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

