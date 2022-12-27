@extends('admin.layouts.app')
@section('admin-title')
    Advertisements
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Advertisement</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Advertisement </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Advertisement</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/advertisement/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add AD </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th width="50">SN</th>
                            <th>Banner</th>
                            {{-- <th width="75">Status</th> --}}
                            <th width="50">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($ads as $row)
                          <tr>
                            <td width="50">{{$i}}</td>
                            <td class="text-center"> <img src="/storage/{{$row->banner}}" alt="" style="height: 200px; width:auto;" class="img img-fluid img-responsive"> <p class="mt-2"> {{$row->link}} </p> </td>
                            {{-- <td width="50"><span class='text-{{$row->status == "Active" ? "success" : "danger"}}'>{{$row->status}}</span></td> --}}
                            <td class="classroom-btn" width="75">
                              <form id="delete-form-{{$row->id}}" action="/admin/advertisement/{{$row->id}}" method="POST" class="d-inline">
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

