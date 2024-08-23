@extends('admin.layouts.app')
@section('admin-title')
  Home Highlights
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Home Highlights</h3>
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Home Highlights </li>
          </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">Home Highlights</h4>
              <div class="text-right">
                <a class="btn btn-success" href="#add_highlight" data-bs-toggle="modal" data-bs-target="#add_highlight" data-toggle="modal" data-target="#add_highlight">Add Highlight</a>
              </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-desc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                    @foreach($highlights as $cat)
                  <tr>
                    <td width="50">{{$i}}</td>
                    <td class="text-wrap">{{$cat->name}}</td>
                    <td class="text-wrap">{{$cat->description}}</td>                            
                    <td class="classroom-btn" width="50">
                      <a class="edit_highlight btn btn-warning" href="javascript:{}" data-toggle="modal" data-target="#edit_highlight" data-id="{{$cat->id}}" data-title="{{$cat->name}}" data-description="{{$cat->description}}" >Edit</a>
                      <form id="delete-form-{{$cat->id}}" action="/admin/highlights/{{$cat->id}}" method="POST" style="display: inline">
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

  {{-- popup model for highlight add start --}}
  <div id="add_highlight" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Add New Highlight </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/highlights" enctype="multipart/form-data">
            @csrf
                
            <div class="form-group row">
              <label for="title" class="col-md-3 col-form-label">{{ __('Highlight Title') }}</label>

              <div class="col-md-9">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required >

                @error('title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="link" class="col-md-3 col-form-label">{{ __('Highlight Link') }}</label>

              <div class="col-md-9">
                <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') }}"  >

                @error('link')
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
  {{-- Popup Model For highlight Add End --}}

  {{-- popup model for highlight Edit start --}}
  <div id="edit_highlight" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Edit Highlights  </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/highlights" enctype="multipart/form-data">
            @csrf
            @method('PATCH')   

            <div class="form-group row">
              <label for="highlight_id" class="col-md-3 col-form-label">{{ __(' Highlight ID') }}</label>

              <div class="col-md-9">
                <input id="highlight_id" type="text" class="form-control @error('highlight_id') is-invalid @enderror" name="highlight_id" value="{{ old('highlight_id') }}" required readonly>

                @error('highlight_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="highlight_title" class="col-md-3 col-form-label">{{ __(' Highlight Title') }}</label>

              <div class="col-md-9">
                <input id="highlight_title" type="text" class="form-control @error('highlight_title') is-invalid @enderror" name="highlight_title" value="{{ old('highlight_title') }}" required >

                @error('highlight_title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="highlight_link" class="col-md-3 col-form-label">{{ __(' Highlight Link') }}</label>

              <div class="col-md-9">
                <input id="highlight_link" type="text" class="form-control @error('highlight_link') is-invalid @enderror" name="highlight_link" value="{{ old('highlight_link') }}" >

                @error('highlight_link')
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
  {{-- Popup Model For highlight Edit End --}}

  <script>
    $(document).on('click', '.edit_highlight', function(){

      $('#highlight_id').val("");
      $('#highlight_title').val("");
      $('#highlight_link').val("");

      const id=$(this).attr('data-id');
      const title=$(this).attr('data-title');
      const link=$(this).attr('data-description');
      
      $('#highlight_id').val(id);
      $('#highlight_title').val(title);
      $('#highlight_link').val(link);

    })
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

