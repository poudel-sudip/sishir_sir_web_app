@extends('admin.layouts.app')
@section('admin-title')
    Book Publishers
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Book Publishers</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/books') }}">Books</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Publishers </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Book Publishers</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/books/publishers/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Publisher </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            {{-- <th>Slug</th> --}}
                            <th>Books</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($categories as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$cat->name}}</td>
                            {{-- <td>{{$cat->slug}}</td> --}}
                            <td><a href="/admin/books/publishers/{{$cat->id}}/books">Books ({{$cat->pub_books()->count()}}) </a></td>
                            <td class="text-wrap"><span class="text-{{$cat->status == 'Active' ? 'success' : 'danger'}}">{{$cat->status}}</span></td>
                            <td class="classroom-btn" width="50">
                              <a href="/admin/books/publishers/{{$cat->id}}/edit" class="btn btn-warning">Edit</a>
                              <form id="delete-form-{{$cat->id}}" action="/admin/books/publishers/{{$cat->id}}" method="POST" style="display: inline">
                                  @csrf
                                  @method('DELETE')
                                  <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="btn btn-danger">Delete</a>
                              </form>
                            </td>
                          </tr>
                          @php($i++)
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

