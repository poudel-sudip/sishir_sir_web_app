@extends('admin.layouts.app')
@section('admin-title')
    PDF Banks
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All PDF Banks</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">PDF Banks</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">PDF Bank Groups</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/pdf-bank/pdf-groups/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add PDf Bank </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>PDf Bank Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th>PDF Files</th>
                            <th>Purchases</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $row)
                          <tr>
                            <td class="text-wrap">{{$row->id}}</td>
                            <td class="text-wrap">{{$row->title}}</td>
                            <td class="text-wrap">{{$row->category->name ?? ''}}</td>
                            <td class="text-wrap">{{$row->author}}</td>
                            <td class="text-wrap">{{$row->price ?? 0}} - {{$row->discount ?? 0}} = {{$row->price - $row->discount}}</td>
                            <td class="classroom-btn"> <a href="/admin/pdf-bank/pdf-groups/{{$row->id}}/pdf-files" class="btn btn-primary">PDF Files ({{$row->chapters()->count()}}) </a> </td>
                            <td class="classroom-btn"> <a href="/admin/pdf-bank/pdf-groups/{{$row->id}}/bookings" class="btn btn-info">Purchases ({{$row->bookings()->count()}}) </a> </td>
                            <td><span class='text-{{$row->status == "Active" ? "success" : "danger"}}'>{{$row->status}}</span></td>
                            <td class="classroom-btn" width="50">
                              <a href="/admin/pdf-bank/pdf-groups/{{$row->id}}" class="btn btn-info">Show</a>
                              <a href="/admin/pdf-bank/pdf-groups/{{$row->id}}/edit" class="btn btn-warning">Edit</a>
                              <form id="delete-form-{{$row->id}}" action="/admin/pdf-bank/pdf-groups/{{$row->id}}" method="POST" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="btn btn-danger">Delete</a>
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
