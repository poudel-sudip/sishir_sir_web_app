@extends('admin.layouts.app')
@section('admin-title')
   Menu Sub Groups | {{$group->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Menu Sub Groups | {{$group->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
              <li class="breadcrumb-item active" aria-current="page">Sub Menus </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Sub Menus | {{$group->name}}</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/menus/'.$group->id.'/sub-groups/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Sub Menu </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Order</th>
                            <th>Menu Items</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($subgroups as $subgroup)
                          <tr>
                            <td width="50">{{$i}}</td>
                            <td>{{$subgroup->name}}</td>
                            <td>{{$subgroup->order}}</td>
                            <td><a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/items">Menu Items ( {{$subgroup->items->count()}} ) </a></td>
                            <td>
                              @if($subgroup->status == 'Inactive')
                                <span class="text-danger">{{$subgroup->status}}</span>
                                @else
                                <span class="text-success">{{$subgroup->status}}</span>
                              @endif
                            </td>
                            <td class="classroom-btn" width="160">
                              <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/edit" class="btn btn-danger">Edit</a>
                              <form id="delete-form-{{$subgroup->id}}" action="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$subgroup->id}});" class="btn btn-warning">Delete</a>
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

