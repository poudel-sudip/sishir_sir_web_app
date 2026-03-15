@extends('admin.layouts.app')
@section('admin-title')
  Vaccancy Tags
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">All Vaccancy Tags </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Vaccancy Tags </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">All Vaccancy Tags</h4>
              <div class="text-right">
                <a href="/admin/careers-tag/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Tag </button></a>
              </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-desc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Action</th>
                    <th>Tag Title</th>
                    <th>Vaccancies</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($tags as $cat)
                    <tr>
                      <td>{{$i}}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                            <a class="edit-category text-danger dropdown-item" href="#edit_category" cat-name="{{$cat->name}}"  cat-id="{{$cat->id}}" data-toggle="modal" data-target="#edit_category">Edit</a>
                            <form id="delete-form-{{$cat->id}}" action="/admin/careers-tag/{{$cat->id}}" method="POST">
                              @csrf
                              @method('DELETE')
                              <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="text-warning dropdown-item">Delete</a>
                            </form>
                          </div>
                        </div>
                      </td>
                      <td>{{$cat->name}}</td>
                      <td> <a href="/admin/careers-tag/{{$cat->id}}/vaccancies" class="btn-sm btn-info">Vaccancies ({{$cat->vaccancies()->count()}}) </a> </td>
                      
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

  {{-- for edit tag model start--}}
  <div class="modal fade" id="edit_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Vaccancy Tag</h5>
                <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>

            <div class="modal-body enroll_form">
                <form method="POST" action="/admin/careers-tag" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group row">
                      <label for="tag_id" class="col-md-4 col-form-label text-md-right">{{ __('Tag ID') }}</label>

                      <div class="col-md-8">
                        <input id="tag_id" type="text" class="form-control @error('tag_id') is-invalid @enderror" name="tag_id" value="{{ old('tag_id') }}" required readonly>
                        @error('tag_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="tag_name" class="col-md-4 col-form-label text-md-right">{{ __('Tag Name') }}</label>

                      <div class="col-md-8">
                        <input id="tag_name" type="text" class="form-control @error('tag_name') is-invalid @enderror" name="tag_name" value="{{ old('tag_name') }}" required autofocus>
                        @error('tag_name')
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
  {{-- for edit tag model end--}}

  <script>

    $(document).ready(function(){
      $('.edit-category').click(function(){
        $('#tag_id').attr('value','');
        $('#tag_name').attr('value','');

        //fetch current data
        let fid = $(this).attr('cat-id');
        let fname = $(this).attr('cat-name');

        //set the value to edit model
        $('#tag_id').attr('value',fid);
        $('#tag_name').attr('value',fname);
      });
    });

  </script>

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

