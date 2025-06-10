@extends('admin.layouts.app')
@section('admin-title')
  Health Days Categories
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Health Days Categories</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Health Days Categories </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title"> Health Days Categories </h4>
              <div class="text-right">
                <a class="btn btn-sm ml-3 btn-success" href="#add_category" data-bs-toggle="modal" data-bs-target="#add_category" data-toggle="modal" data-target="#add_category">Add Category</a>
              </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-desc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Category Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($categories as $cat)
                  <tr>
                    <td width="100">{{$i}}</td>
                    <td class="text-wrap">{{ucwords($cat->name)}}</td>
                    
                    <td class="classroom-btn" width="100">
                      <a class="edit_category btn btn-warning" href="#edit_category" category-id="{{$cat->id}}" category-name="{{$cat->name}}" data-bs-toggle="modal" data-bs-target="#edit_category" data-toggle="modal" data-target="#edit_category">Edit</a>
                      <form id="delete-form-{{$cat->id}}" action="/admin/health-days/categories/{{$cat->id}}" method="POST" style="display: inline">
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

  {{-- popup model for Category add start --}}
  <div id="add_category" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Add New Health Day Category </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/health-days/categories" enctype="multipart/form-data">
            @csrf
                
            <div class="form-group row my-0">
              <label for="category" class="col-md-4 col-form-label">{{ __(' Category Name') }}</label>

              <div class="col-md-8">
                <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required >

                @error('category')
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
  {{-- Popup Model For Category Add End --}}


  {{-- popup model for Category Edit start --}}
  <div id="edit_category" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Edit Health Day Category </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/health-days/categories" enctype="multipart/form-data">
            @csrf
            @method('PATCH')   

            <div class="form-group row my-0">
              <label for="category_id" class="col-md-4 col-form-label">{{ __(' Category ID') }}</label>

              <div class="col-md-8">
                <input id="category_id" type="text" class="form-control @error('category_id') is-invalid @enderror" name="category_id" value="{{ old('category_id') }}" required readonly>

                @error('category_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
              <label for="category_name" class="col-md-4 col-form-label">{{ __(' Category Name') }}</label>

              <div class="col-md-8">
                <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" required >

                @error('category_name')
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
  {{-- Popup Model For Category Edit End --}}


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
            'Your record has been deleted.',
            'success'
          )
        }
      })
    }
  </script>

  <script>
    $(document).on('click', '.edit_category', function(){
      const id=$(this).attr('category-id');
      const name=$(this).attr('category-name');
      $('#category_id').val("");
      $('#category_name').val("");
      
      $('#category_id').val(id);
      $('#category_name').val(name);
    })
  </script> 
@endsection

