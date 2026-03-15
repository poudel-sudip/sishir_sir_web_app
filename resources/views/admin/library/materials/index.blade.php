@extends('admin.layouts.app')
@section('admin-title')
  eLibrary Materials | {{$category->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">eLibrary Materials | {{$category->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/library') }}">eLibrary Categories</a></li>
              <li class="breadcrumb-item active" aria-current="page">Materials </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">eLibrary Materials | {{$category->name}}</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/library/'.$category->id.'/materials/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Material </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Order</th>
                            <th>Type</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($materials as $subgroup)
                          <tr>
                            <td width="50">{{$i}}</td>
                            <td class="text-wrap">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                        <a href="/admin/library/{{$category->id}}/materials/{{$subgroup->id}}" class="text-primary dropdown-item">Show</a>
                                        <a href="/admin/library/{{$category->id}}/materials/{{$subgroup->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                        <form id="delete-form-{{$subgroup->id}}" action="/admin/library/{{$category->id}}/materials/{{$subgroup->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$subgroup->id}});" class="text-warning dropdown-item">Delete</a>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="texxt-wrap">{{ucwords($subgroup->name)}}</td>
                            <td class="texxt-wrap">{{$subgroup->order}}</td>
                            <td class="texxt-wrap">{{ucwords($subgroup->type)}}</td>
                            <td>
                              @if($subgroup->status == 'Inactive')
                                <span class="text-danger">{{$subgroup->status}}</span>
                                @else
                                <span class="text-success">{{$subgroup->status}}</span>
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

