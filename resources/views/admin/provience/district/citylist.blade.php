@extends('admin.layouts.app')
@section('admin-title')
    All District/Cities | {{$provience->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All District/Cities | {{$provience->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/provience') }}">Proviences</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Cities </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">All District/Cities | {{$provience->name}}</h4>
                        <div class="text-right">
                            <a href="/admin/provience/{{$provience->id}}/district-city/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add District/City </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($cities as $city)
                            <tr>
                              <td>{{$i}}</td>
                              <td>{{$city->name}}</td>
                              <td class="classroom-btn" width="160">
                                <form id="delete-form-{{$city->id}}" action="/admin/provience/{{$provience->id}}/district-city/{{$city->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$city->id}});" class="btn btn-danger">Delete</a>
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

