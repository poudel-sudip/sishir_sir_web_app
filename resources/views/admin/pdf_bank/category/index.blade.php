@extends('admin.layouts.app')
@section('admin-title')
    PDF Bank Categories
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All PDF Bank Categories</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">PDF Bank Categories </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">PDF Bank Categories Lists</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/pdf-bank/categories/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Category </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Category Name</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>PDF Groups</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($categories as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$cat->name}}</td>
                            <td>{{$cat->order}}</td>
                            <td><span class='text-{{$cat->status == "Active" ? "success" : "danger"}}'>{{$cat->status}}</span></td>
                            <td class="classroom-btn"> <a href="/admin/pdf-bank/categories/{{$cat->id}}/groups" class="btn btn-primary">PDf Groups ({{$cat->ebooks()->count()}}) </a> </td>
                            <td class="classroom-btn" width="50">
                              <a href="/admin/pdf-bank/categories/{{$cat->id}}/edit" class="btn btn-warning">Edit</a>
                              <form class="d-inline" id="delete-form-{{$cat->id}}" action="/admin/pdf-bank/categories/{{$cat->id}}" method="POST">
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

