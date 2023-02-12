@extends('admin.layouts.app')
@section('admin-title')
   Menu Sub Items | {{$item->name}} | {{$category->name}} | {{$subgroup->name}} | {{$group->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Menu Sub Items  </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Menus</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories') }}">Categories</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories/'.$category->id.'/items') }}">Items</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menu Sub Items </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Menu Sub Items  | {{$item->name}} | {{$category->name}} | {{$subgroup->name}} | {{$group->name}}</h4>
                        <div class="text-right">
                            <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}/sub-items/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Menu Sub Item </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th width="20">Order</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th width="100">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($subItems as $sitem)
                          <tr>
                            <td width="50">{{$i}}</td>
                            <td class="text-wrap">{{$sitem->name}}</td>
                            <td>{{$sitem->order}}</td>
                            <td>{{ucwords($sitem->type)}}</td>
                            <td>
                              @if($sitem->status == 'Inactive')
                                <span class="text-danger">{{$sitem->status}}</span>
                                @else
                                <span class="text-success">{{$sitem->status}}</span>
                              @endif
                            </td>
                            <td class="classroom-btn" width="100">
                              <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}/sub-items/{{$sitem->id}}" class="btn btn-info">Show</a>
                              <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}/sub-items/{{$sitem->id}}/edit" class="btn btn-danger">Edit</a>
                              <form id="delete-form-{{$sitem->id}}" action="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}/sub-items/{{$sitem->id}}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:{}" onclick="javascript:deleteData({{$sitem->id}});" class="btn btn-warning">Delete</a>
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

