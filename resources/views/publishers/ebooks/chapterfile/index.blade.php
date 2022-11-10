@extends('publishers.layouts.app')
@section('admin-title')
    Chapter Files | {{$chapter->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Chapters Files | {{$chapter->title}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/publisher/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/publisher/ebooks/all') }}">E-Books</a></li>
                <li class="breadcrumb-item"><a href="/publisher/ebooks/{{$ebook->id}}/chapters">Chapters</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chapters</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Chapters Files | {{$chapter->title}}</h4>
                        <div class="text-right">
                            <a href="/publisher/ebooks/{{$ebook->id}}/chapters/{{$chapter->id}}/files/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Image </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="table-courses">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Files</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($chaptersfiles as $files)
                          <tr>
                            <td class="text-wrap">{{$files->id}}</td>
                            <td class="text-wrap">
                                <a href="/storage/{{$files->image}}" target="_blank"><img src="/storage/{{$files->image}}" width="200" alt=""></a>
                            </td>
                            <td width="100"><form id="delete-form-{{$chapter->id}}" action="/publisher/ebooks/{{$ebook->id}}/chapters/{{$chapter->id}}/files/{{$files->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$chapter->id}});" class="btn btn-danger btn-sm">Delete</a>
                            </form></td>
                            <td>
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
