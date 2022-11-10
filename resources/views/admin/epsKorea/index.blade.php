@extends('admin.layouts.app')
@section('admin-title')
    EPS - Korea Registration
@endsection

@section('content')
<style>
  #main-booking-table{
    width: 100% !important;
  }
  #main-booking-table tr td:nth-child(2),
  #main-booking-table tr td:nth-child(3),
  #main-booking-table tr td:nth-child(6)
  {
    white-space: pre-wrap;
  }
  #main-booking-table #width-fixed{
    width: 110px;
  }
  .btn-manual, .slip-view{
    padding: 2px 5px;
    display: inline;
    font-size: 12px
  }
</style>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Registration EPS</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">EPS Registration</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">EPS Registration</h4>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="main-booking-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Sector</th>
                            <th>Sub Sector</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($eps as $eps)
                          <tr>
                            <td>{{$eps->id}}</td>
                            <td>{{$eps->fname}}</td>
                            <td>{{$eps->mobile}}</td>
                            <td>{{$eps->email}}</td>
                            <td>{{$eps->sector}}</td>
                            <td>{{$eps->subsector}}</td>
                            
                            <td>
                              @if($eps->status == 'Unregistered')
                              <span class="text-danger">{{$eps->status}}</span>
                              @else
                              <span class="text-success">{{$eps->status}}</span>
                              @endif
                            </td>
                            <td id="width-fixed">
                                <a href="/admin/eps-registration/{{$eps->id}}" class=" btn btn-primary btn-manual">Show</a>
                                <a href="/admin/eps-registration/{{$eps->id}}/edit" class=" btn btn-danger btn-manual">Update</a>
                                <form id="delete-form-{{$eps->id}}" action="/admin/eps-registration/{{$eps->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$eps->id}});" class="btn btn-warning btn-manual">Delete</a>
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
                    <hr>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>

@endsection
