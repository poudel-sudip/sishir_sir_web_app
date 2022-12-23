@extends('admin.layouts.app')
@section('admin-title')
   Menu Groups
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Menu Groups</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Menus </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Menu Group</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/menus/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Menu Group </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Order</th>
                            <th>Sub Groups</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($groups as $group)
                          <tr>
                            <td width="50">{{$i}}</td>
                            <td>{{$group->name}}</td>
                            <td>{{$group->order}}</td>
                            <td><a href="/admin/menus/{{$group->id}}/sub-groups">Sub Groups ( {{$group->subGroups->count()}} ) </a></td>
                            <td>
                              @if($group->status == 'Inactive')
                                <span class="text-danger">{{$group->status}}</span>
                                @else
                                <span class="text-success">{{$group->status}}</span>
                              @endif
                            </td>
                            <td class="classroom-btn" width="160">
                              <a href="/admin/menus/{{$group->id}}/edit" class="btn btn-danger">Edit</a>
                              <form id="delete-form-{{$group->id}}" action="/admin/menus/{{$group->id}}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$group->id}});" class="btn btn-warning">Delete</a>
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

