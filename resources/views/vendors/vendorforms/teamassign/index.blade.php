@extends('vendors.layouts.app')
@section('admin-title')
    Form Assigned to Team
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title"> Team Assigns | {{$vform->title}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/vendor/vendor-dynamic-forms') }}">Vendor Forms</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Team Assigns </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title"> Team Assigns | {{$vform->title}} </h4>
                        <div class="text-right">
                            <a href="/vendor/vendor-dynamic-forms/{{$vform->id}}/team-assign/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Assign Team </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Team</th>
                            {{-- <th class="texy-wrap">Form</th> --}}
                            <th class="text-wrap">Sub Category</th>
                            <th>Start ID</th>
                            <th>End ID</th>
                            <th>Total</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($assigns as $data)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">{{date('Y-m-d',strtotime($data->created_at))}}</td>
                            <td class="text-wrap">{{$data->team->name ?? ''}}</td>
                            {{-- <td class="text-wrap">{{$data->form->title ?? ''}}</td> --}}
                            <td class="text-wrap">{{$data->sub_category ?? ''}}</td>
                            <td class="text-wrap">{{$data->start_id ?? ''}}</td>
                            <td class="text-wrap">{{$data->end_id ?? ''}}</td>
                            <td class="text-wrap">{{$data->total ?? ''}}</td>
                           
                            <td class="classroom-btn" width="75">
                              <form id="delete-form-{{$data->id}}" action="/vendor/vendor-dynamic-forms/{{$vform->id}}/team-assign/{{$data->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$data->id}});" class="btn btn-danger">Delete</a>
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

