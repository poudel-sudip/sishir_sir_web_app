@extends('admin.layouts.app')
@section('admin-title')
   Menu Items | {{$category->name}} | {{$subgroup->name}} | {{$group->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Menu Items | {{$category->name}} | {{$subgroup->name}} | {{$group->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus') }}">Menu Groups</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups') }}">Sub Menus</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/menus/'.$group->id.'/sub-groups/'.$subgroup->id.'/categories') }}">Categories</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menu Items </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Menu Items  | {{$category->name}} | {{$subgroup->name}} | {{$group->name}}</h4>
                        <div class="text-right">
                            <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Menu Item </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th width="100">Action</th>
                            <th>Name</th>
                            <th width="20">Order</th>
                            <th>Type</th>
                            <th>Sub Items</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($items as $item)
                          <tr>
                            <td width="50">{{$i}}</td>
                            <td width="50">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                        <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}" class="text-primary dropdown-item">Show</a>
                                        <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                        <form id="delete-form-{{$item->id}}" action="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$item->id}});" class="text-warning dropdown-item">Delete</a>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="text-wrap">{{$item->name}}</td>
                            <td>{{$item->order}}</td>
                            <td>{{ucwords($item->type)}}</td>
                            <td width="50">
                              @if($item->type == 'heading')
                              <a href="/admin/menus/{{$group->id}}/sub-groups/{{$subgroup->id}}/categories/{{$category->id}}/items/{{$item->id}}/sub-items">Sub Items ( {{$item->subItems->count()}} ) </a>
                              @endif
                            </td>
                            <td>
                              @if($item->status == 'Inactive')
                                <span class="text-danger">{{$item->status}}</span>
                                @else
                                <span class="text-success">{{$item->status}}</span>
                              @endif
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

