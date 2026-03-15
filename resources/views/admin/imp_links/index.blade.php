@extends('admin.layouts.app')
@section('admin-title')
  {{$category->name}} | Important Links
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">{{$category->name}} | Important Links</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/imp-links') }}">Link Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Links </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">{{$category->name}} | Important Links</h4>
                        <div class="text-right">
                            <a href="/admin/imp-links/{{$category->id}}/links/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Link </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Action</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Category</th>
                            <th>Order</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($links as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">
                              <div class="dropdown">
                                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                      <a href="/admin/imp-links/{{$category->id}}/links/{{$cat->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                      <form id="delete-form-{{$category->id}}" action="/admin/imp-links/{{$category->id}}/links/{{$cat->id}}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <a href="javascript:{}" onclick="javascript:deleteData({{$category->id}});" class="text-warning dropdown-item">Delete</a>
                                      </form>
                                  </div>
                              </div>
                            </td>
                            <td>{{$cat->link_title}}</td>
                            <td class="text-wrap">{{$cat->link_url}}</td>
                            <td>{{$cat->category->name ?? ''}}</td>
                            <td>{{$cat->link_order}}</td>
                            
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

