@extends('admin.layouts.app')
@section('admin-title')
  Dynamic Forms
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">All Dynamic Forms</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Forms</li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Dynamic Forms </h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/dynamic-forms/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Form </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th class="text-wrap">SN</th>
                            <th class="text-wrap">Action</th>
                            <th class="text-wrap">Group</th>
                            <th class="text-wrap">Title</th>
                            <th class="text-wrap">Sub Categories</th>
                            <th class="text-wrap">Form Applicants</th>
                            <th class="text-wrap">Form Link</th>
                            <th class="text-wrap">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                            @foreach($forms as $cat)
                          <tr>
                            <td class="text-wrap">{{$i}}</td>
                            <td class="text-wrap">
                              <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                  <a href="/admin/dynamic-forms/{{$cat->id}}" class="text-primary dropdown-item">Show</a>
                                  <a href="/admin/dynamic-forms/{{$cat->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                  <form id="delete-form-{{$cat->id}}" action="/admin/dynamic-forms/{{$cat->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="text-warning dropdown-item">Delete</a>
                                  </form>
                                  <form id="reset-form-{{$cat->id}}" action="/admin/dynamic-forms/{{$cat->id}}/reset" method="POST">
                                    @csrf
                                    <a href="javascript:{}" onclick="javascript:resetData({{$cat->id}});" class="text-primary dropdown-item">Reset</a>
                                  </form>
                                </div>
                              </div>
                            </td>
                            <td class="text-wrap">{{ucwords($cat->group->name ?? '')}}</td>
                            <td class="text-wrap">{{ucwords($cat->title)}}</td>
                            <td class="text-wrap">{!! ucwords($cat->sub_categories) !!}</td>
                            <td class="text-wrap"><a href="/admin/dynamic-forms/{{$cat->id}}/applicants">Applicants ( {{$cat->applicants->count()}} ) </a></td>
                            <td class="text-wrap">{{url('/dynamic-forms/'.$cat->slug)}}</td>
                            <td class="text-wrap">
                              @if($cat->status == 'Inactive')
                                <span class="text-danger">{{$cat->status}}</span>
                                @else
                                <span class="text-success">{{$cat->status}}</span>
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

                        function resetData(id)
                        {
                            Swal.fire({
                            title: 'Are you sure to reset it?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Reset it!'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              document.getElementById('reset-form-'+id).submit();
                              Swal.fire(
                                'Reset Successful!',
                                'Your Records has been Reset.',
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

