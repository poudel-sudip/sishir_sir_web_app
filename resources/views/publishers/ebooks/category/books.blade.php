@extends('publishers.layouts.app')
@section('admin-title')
    E-Books | {{$category->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">E-Books | {{$category->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/publisher/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/publisher/ebooks/categories') }}">Categories</a></li>
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
                            <a href="{{ ('/publisher/ebooks/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add E-Book </button></a>
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
                            <td class="text-wrap">{{$row->ebook->title ?? ''}}</td>
                            <td class="text-wrap">{{ $row->ebook ? ($row->ebook->category ? $row->ebook->category->name : '') : ''}}</td>
                            <td>{{$row->ebook->price ?? ''}} - {{$row->ebook->discount ?? ''}} = {{$row->ebook ? ($row->ebook->price - $row->ebook->discount) : ''}} </td>
                            <td> <a href="/publisher/ebooks/{{$row->id}}/chapters" class="btn-sm btn-primary">Chapters</a> </td>
                            <td>{{$row->ebook ? ($row->ebook->bookings->where('status','=','Verified')->count()) : ''}} </td>
                            <td><span class='text-{{$row->ebook ? ($row->ebook->status == "Active" ? "success" : "danger") : ''}}'>{{$row->ebook->status ?? ''}}</span></td>
                            <td>
                              <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                    <a href="/publisher/ebooks/{{$row->id}}" class="text-primary dropdown-item">Show</a>
                                    <a href="/publisher/ebooks/{{$row->id}}/edit" class="text-warning dropdown-item">Edit</a>
                                    {{-- <form id="delete-form-{{$row->id}}" action="/publisher/books/{{$row->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="text-warning dropdown-item">Delete</a>
                                    </form> --}}
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

