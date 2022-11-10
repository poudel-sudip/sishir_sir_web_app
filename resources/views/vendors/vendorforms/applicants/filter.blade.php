@extends('vendors.layouts.app')
@section('admin-title')
    Filtered Form Applicants | {{ucwords($vform->title)}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Filtered Form Applicants | {{ucwords($vform->title)}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/vendor/vendor-dynamic-forms') }}">Forms</a></li>
              <li class="breadcrumb-item"><a href="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants">Applicants</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Filtered </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="custon-table-header">
                      <h4 class="card-title">Filteres Form Applicants | {{$str}} | {{ucwords($vform->title)}} </h4>
                      <div class="text-right">
                        @if(count($applicants))
                        <a href="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants/export/{{$str}}"><button type="button" class="btn btn-sm ml-3 btn-info"> Export Applicants </button></a>
                        @endif
                      </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="category-table">
                      <thead>
                        <tr>
                          <th>SN</th>
                          <th>ID</th>
                          <th class="text-wrap">Sub Category</th>
                          <th class="text-wrap">Name</th>
                          <th class="text-wrap">Email</th>
                          <th class="text-wrap">Contact</th>
                          <th class="text-wrap">Message</th>
                          <th class="text-wrap">Remarks</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php($i=1)
                        @foreach($applicants as $row)
                        <tr>
                          <td>{{$i}}</td>
                          <td class="text-wrap">{{$row->id}}</td>
                          <td class="text-wrap">{{$row->sub_category}}</td>
                          <td class="text-wrap">{{$row->name}}</td>
                          <td class="text-wrap">{{$row->email}}</td>
                          <td class="text-wrap">{{$row->contact}}</td>
                          <td class="text-wrap">{{$row->message}}</td>
                          <td class="text-wrap">{{$row->remarks}}</td>
                          
                          <td class="classroom-btn" width="75">
                            <a href="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants/{{$row->id}}" class="btn btn-info">Show</a>
                            <form id="delete-form-{{$row->id}}" action="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants/{{$row->id}}" method="POST" style="display: inline">
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

