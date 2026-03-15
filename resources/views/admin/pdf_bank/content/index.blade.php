@extends('admin.layouts.app')
@section('admin-title')
    PDF Files | {{$group->title}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">PDF Files | {{$group->title}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/pdf-groups') }}">eBook</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contents</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header align-items-center">
                        <h4 class="card-title">PDF Files :: {{$group->title}}</h4>
                        <div class="text-right">
                          <a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/import-library"><button type="button" class="btn btn-sm m-1 btn-info"> Import PDF From Material Library </button></a>
                          <a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/import-singles"><button type="button" class="btn btn-sm m-1 btn-primary"> Import From eBook Singles </button></a>
                          <a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/create"><button type="button" class="btn btn-sm m-1 btn-success"> Add PDF File </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Action</th>
                            {{-- <th>File Name</th> --}}
                            <th>File Title</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($contents as $row)
                          <tr>
                            <td class="text-wrap">{{$row->id}}</td>
                            <td width="50">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                        <a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/{{$row->id}}" class="text-primary dropdown-item">Show</a>
                                        <a href="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/{{$row->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                        <form id="delete-form-{{$row->id}}" action="/admin/pdf-bank/pdf-groups/{{$group->id}}/pdf-files/{{$row->id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" class="text-warning dropdown-item">Delete</a>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            {{-- <td class="text-wrap">{{$row->name}}</td> --}}
                            <td class="text-wrap">{{$row->title}}</td>
                            <td>
                              @if($row->status == 'Inactive')
                              <span class="text-danger">{{$row->status}}</span>
                              @else
                              <span class="text-success">{{$row->status}}</span>
                              @endif
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
