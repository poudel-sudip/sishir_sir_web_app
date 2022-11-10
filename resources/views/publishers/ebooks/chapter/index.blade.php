@extends('publishers.layouts.app')
@section('admin-title')
    Chapters | {{$book->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Chapters | {{$book->title}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/publisher/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/publisher/ebooks/all') }}">E-Books</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chapters</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Chapters | {{$book->title}}</h4>
                        <div class="text-right">
                            <a href="/publisher/ebooks/{{$ebook->id}}/chapters/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Chapter </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="table-courses">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Chapter Name</th>
                            <th>Chapter Title</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters as $chapter)
                          <tr>
                            <td class="text-wrap">{{$chapter->id}}</td>
                            <td class="text-wrap">{{$chapter->name}}</td>
                            <td class="text-wrap">{{$chapter->title}}</td>
                            <td>
                              @if($chapter->status == 'Inactive')
                              <span class="text-danger">{{$chapter->status}}</span>
                              @else
                              <span class="text-success">{{$chapter->status}}</span>
                              @endif
                            </td>
                            <td>
                              <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                    <a href="/publisher/ebooks/{{$ebook->id}}/chapters/{{$chapter->id}}/files" class="text-primary dropdown-item">Files</a>
                                    <a href="/publisher/ebooks/{{$ebook->id}}/chapters/{{$chapter->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                    <form id="delete-form-{{$chapter->id}}" action="/publisher/ebooks/{{$ebook->id}}/chapters/{{$chapter->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="javascript:deleteData({{$chapter->id}});" class="text-warning dropdown-item">Delete</a>
                                    </form>
                                    <br>
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
                    <hr>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
