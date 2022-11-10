@extends('admin.layouts.app')
@section('admin-title')
    E-Books | {{$category->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">E-Books | {{$category->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/ebook/categories') }}">Categories</a></li>
              <li class="breadcrumb-item active" aria-current="page">E-Books </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">E-Books | {{$category->name}}</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/ebook/books/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add E-Book </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Book Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Chapters</th>
                            <th>Purchases</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($books as $row)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">{{$row->title ?? ''}}</td>
                            <td class="text-wrap">{{$row->category->name ?? '' }}</td>
                            <td>{{$row->price ?? ''}} - {{$row->discount ?? ''}} = {{$row->price - $row->discount}} </td>
                            <td> <a href="/admin/ebook/books/{{$row->id}}/chapters" class="btn-sm btn-primary">Chapters</a> </td>
                            <td>{{$row->bookings->where('status','=','Verified')->count()}} </td>
                            <td><span class='text-{{$row->status == "Active" ? "success" : "danger"}}'>{{$row->status}}</span></td>
                            <td>
                              <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                    <a href="/admin/ebook/books/{{$row->id}}" class="text-primary dropdown-item">Show</a>
                                    <a href="/admin/ebook/books/{{$row->id}}/edit" class="text-warning dropdown-item">Edit</a>
                                    <form id="delete-form-{{$row->id}}" action="/admin/ebook/books/{{$row->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="text-danger dropdown-item">Delete</a>
                                    </form>
                                </div>
                              </div>
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

