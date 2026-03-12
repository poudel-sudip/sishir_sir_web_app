@extends('admin.layouts.app')
@section('admin-title')
  eBook Groups | {{$category->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">eBook Groups | {{$category->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/pdf-bank/categories') }}">Categories</a></li>
              <li class="breadcrumb-item active" aria-current="page">eBook Groups </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">eBook Groups | {{$category->name}}</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/pdf-bank/pdf-groups/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add eBook Group </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>eBook Group</th>
                            {{-- <th>Category</th> --}}
                            <th>Price</th>
                            <th>PDF Files</th>
                            <th>Purchases</th>
                            <th>Status</th>
                            <th>Pinned</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($groups as $row)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">{{$row->title ?? ''}}</td>
                            {{-- <td class="text-wrap">{{$row->category->name ?? '' }}</td> --}}
                            <td>{{$row->price ?? ''}} - {{$row->discount ?? ''}} = {{$row->price - $row->discount}} </td>
                            <td class="classroom-btn"> <a href="/admin/pdf-bank/pdf-groups/{{$row->id}}/pdf-files" class="btn btn-primary">PDF Files ({{$row->chapters()->count()}}) </a> </td>
                            <td>{{$row->bookings->where('status','=','Verified')->count()}} </td>
                            <td><span class='text-{{$row->status == "Active" ? "success" : "danger"}}'>{{$row->status}}</span></td>
                            <td class="text-wrap">{{$row->isPinned ?? ''}}</td>
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
                          @php($i++)
                          @endforeach
                        </tbody>
                      </table>
                      
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>

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

@endsection

