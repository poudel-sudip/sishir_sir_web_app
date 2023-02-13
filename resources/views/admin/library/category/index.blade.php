@extends('admin.layouts.app')
@section('admin-title')
   Library Categories
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Library Categories</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Library Categories </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Library Categories</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/library/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Library Category</button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Order</th>
                            <th>Materials</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($categories as $group)
                          <tr>
                            <td width="50">{{$i}}</td>
                            <td>{{$group->name}}</td>
                            <td>{{$group->order}}</td>
                            <td><a href="/admin/library/{{$group->id}}/materials">Materials ( {{$group->materials->count()}} ) </a></td>
                            <td>
                              @if($group->status == 'Inactive')
                                <span class="text-danger">{{$group->status}}</span>
                                @else
                                <span class="text-success">{{$group->status}}</span>
                              @endif
                            </td>
                            <td class="classroom-btn" width="100">
                              <a href="/admin/library/{{$group->id}}/edit" class="btn btn-warning">Edit</a>
                              <form id="delete-form-{{$group->id}}" action="/admin/library/{{$group->id}}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$group->id}});" class="btn btn-danger">Delete</a>
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

