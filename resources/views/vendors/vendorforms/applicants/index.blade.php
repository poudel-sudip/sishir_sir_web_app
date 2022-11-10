@extends('vendors.layouts.app')
@section('admin-title')
    Form Applicants | {{ucwords($vform->title)}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Form Applicants | {{ucwords($vform->title)}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/vendor/vendor-dynamic-forms') }}">Forms</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Applicants </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="custon-table-header">
                      <h4 class="card-title">Form Applicants | {{ucwords($vform->title)}} </h4>
                      <div class="text-right">
                        <a href="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants/export"><button type="button" class="btn btn-sm ml-3 btn-info"> Download Applicants </button></a>
                        <a href="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants/upload"><button type="button" class="btn btn-sm ml-3 btn-success"> Upload Applicants </button></a>
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

                  <hr>
                  <div class="description small">
                    <a href="{{ asset('admin/files/formapplicationupload.xlsx') }}" target="_blank">Download Bulk Form Applicants Upload Sample</a>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="h3 card-title text-center">Filter Data By Sub Course/Category</div>
                    <form method="POST" action="/vendor/vendor-dynamic-forms/{{$vform->id}}/applicants/filter" enctype="multipart/form-data">
                      @csrf
                      
                      <div class="form-group row">
                          <label for="sub_course" class="col-md-4 col-form-label text-right">{{ __('Filter By Sub Course') }} </label>
                          
                          <div class="col-md-6">
                              <input type="text" id="sub_course" name="sub_course" class="form-control @error('sub_course') is-invalid @enderror" required>
                              
                              @error('sub_course')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Submit') }}
                              </button>
                          </div>
                      </div>

                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

