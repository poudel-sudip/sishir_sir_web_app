@extends('admin.layouts.app')
@section('admin-title')
    Course Categories
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Course Categories</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Categories </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Categories table</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/categories/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Category </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                          <tr>
                            <td>{{$cat->id}}</td>
                            <td>{{$cat->name}}</td>
                            <td>{{$cat->slug}}</td>
                            <td>{{$cat->order}}</td>
                            <td>
                            @if($cat->status == 'Inactive')
                              <span class="text-danger">{{$cat->status}}</span>
                              @else
                              <span class="text-success">{{$cat->status}}</span>
                            @endif
                            </td>
                              <td class="classroom-btn" width="160">
                                  <a href="/admin/categories/{{$cat->id}}/edit" class="btn btn-danger">Edit</a>
                                  <form id="delete-form-{{$cat->id}}" action="/admin/categories/{{$cat->id}}" method="POST" style="display: inline">
                                      @csrf
                                      @method('DELETE')
                                      <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="btn btn-warning">Delete</a>
                                  </form>
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

