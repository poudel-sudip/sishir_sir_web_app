@extends('admin.layouts.app')
@section('admin-title')
    E Books
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All E-Books</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">E-Books</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">E-Books Table</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/ebook/books/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add E-Book </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Book Title</th>
                            <th>Category</th>
                            <th>Book Author</th>
                            <th>Book Price</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                          <tr>
                            <td class="text-wrap">{{$book->id}}</td>
                            <td class="text-wrap">{{$book->title}}</td>
                            <td class="text-wrap">{{$book->category->name ?? ''}}</td>
                            <td class="text-wrap">{{$book->author}}</td>
                            <td class="text-wrap">{{$book->price ?? 0}} - {{$book->discount ?? 0}} = {{$book->price - $book->discount}}</td>
                            <td>
                              @if($book->status == 'Inactive')
                              <span class="text-danger">{{$book->status}}</span>
                              @else
                              <span class="text-success">{{$book->status}}</span>
                              @endif
                            </td>
                            <td>
                              <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                    <a href="/admin/ebook/books/{{$book->id}}" class="text-primary dropdown-item">Show</a>
                                    <a href="/admin/ebook/books/{{$book->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                    <form id="delete-form-{{$book->id}}" action="/admin/ebook/books/{{$book->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$book->id}});" class="text-warning dropdown-item">Delete</a>
                                    </form>
                                    <br>
                                    <a href="/admin/ebook/books/{{$book->id}}/chapters" class="text-info dropdown-item">Chapters</a>
                                    <a href="/admin/ebook/books/{{$book->id}}/bookings" class="text-primary dropdown-item">Bookings</a>

                                </div>
                              </div>
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
                   
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
