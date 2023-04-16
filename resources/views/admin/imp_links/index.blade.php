@extends('admin.layouts.app')
@section('admin-title')
    Important Links
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Important Links</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Important Links </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Important Links</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/imp-links/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Link </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Category</th>
                            <th>Order</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($links as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$cat->link_title}}</td>
                            <td class="text-wrap">{{$cat->link_url}}</td>
                            <td>{{$cat->link_category}}</td>
                            <td>{{$cat->link_order}}</td>
                            
                            <td class="classroom-btn" width="100">
                                <a href="/admin/imp-links/{{$cat->id}}/edit" class="btn btn-danger">Edit</a>
                                <form id="delete-form-{{$cat->id}}" action="/admin/imp-links/{{$cat->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="btn btn-warning">Delete</a>
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

