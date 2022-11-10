@extends('vendors.layouts.app')
@section('admin-title')
    Dynamic Form Groups
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Form Groups</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/vendor/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Form Groups </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Form Groups </h4>
                        <div class="text-right">
                            <a class="btn btn-sm ml-3 btn-success" href="#add_group" data-bs-toggle="modal" data-bs-target="#add_group" data-toggle="modal" data-target="#add_group">Add Group</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="advanced-desc-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Group Name</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($groups as $cat)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">{{ucwords($cat->name)}}</td>
                           
                            <td class="classroom-btn" width="175">
                              <a href="/vendor/vendor-dynamic-forms/groups/{{$cat->id}}/forms" class="btn btn-info">Forms</a>
                              <a class="edit_group btn btn-warning" href="#edit_group" group-id="{{$cat->id}}" group-name="{{$cat->name}}" data-bs-toggle="modal" data-bs-target="#edit_group" data-toggle="modal" data-target="#edit_group">Edit</a>

                              <form id="delete-form-{{$cat->id}}" action="/vendor/vendor-dynamic-forms/groups/{{$cat->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="btn btn-danger">Delete</a>
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

    {{-- popup model for group add start --}}
    <div id="add_group" class="modal fade">
      <div class="modal-dialog ">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title"> Add New Form Group </h5>
                  <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form method="POST" action="/vendor/vendor-dynamic-forms/groups" enctype="multipart/form-data">
                      @csrf
                          
                      <div class="form-group row">
                        <label for="group" class="col-md-3 col-form-label">{{ __(' Group Name') }}</label>
  
                        <div class="col-md-9">
                          <input id="group" type="text" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ old('group') }}" required >
  
                          @error('group')
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
    {{-- Popup Model For Group Add End --}}

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

      {{-- popup model for group Edit start --}}
      <div id="edit_group" class="modal fade">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Edit Form Group </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/vendor/vendor-dynamic-forms/groups" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')   

                        <div class="form-group row">
                          <label for="group_id" class="col-md-3 col-form-label">{{ __(' Group ID') }}</label>
    
                          <div class="col-md-9">
                            <input id="group_id" type="text" class="form-control @error('group_id') is-invalid @enderror" name="group_id" value="{{ old('group_id') }}" required readonly>
    
                            @error('group_id')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="group_name" class="col-md-3 col-form-label">{{ __(' Group Name') }}</label>
    
                          <div class="col-md-9">
                            <input id="group_name" type="text" class="form-control @error('group_name') is-invalid @enderror" name="group_name" value="{{ old('group_name') }}" required >
    
                            @error('group_name')
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
      {{-- Popup Model For Group Edit End --}}

  <script>
    $(document).on('click', '.edit_group', function(){
        const id=$(this).attr('group-id');
        const name=$(this).attr('group-name');
        $('#group_id').val("");
        $('#group_name').val("");
        
        $('#group_id').val(id);
        $('#group_name').val(name);
    })
  </script> 
@endsection

