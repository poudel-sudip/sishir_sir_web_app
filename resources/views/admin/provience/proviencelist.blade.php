@extends('admin.layouts.app')
@section('admin-title')
    All Proviences
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Proviences</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Proviences </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">All Proviences</h4>
                        <div class="text-right">
                            <a href="/admin/provience/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Provience </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Options</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($proviences as $pro)
                            <tr>
                              <td>{{$i}}</td>
                              <td>{{$pro->name}}</td>
                              <td class="classroom-btn">
                                <a href="/admin/provience/{{$pro->id}}/district-city"  class="btn btn-primary">District/City ({{$pro->cities->count()}})</a>
                              </td>
                              <td class="classroom-btn" width="160">
                                <a href="/admin/provience/{{$pro->id}}/edit"  class="btn btn-warning">Edit</a>
                                <form id="delete-form-{{$pro->id}}" action="/admin/provience/{{$pro->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$pro->id}});" class="btn btn-danger">Delete</a>
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

