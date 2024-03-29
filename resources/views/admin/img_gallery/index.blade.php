@extends('admin.layouts.app')
@section('admin-title')
  Image Gallery
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Image Gallery</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Image Gallery </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Image Gallery </h4>
                        <div class="text-right">
                            <a class="btn btn-sm ml-3 btn-success" href="#add_image" data-bs-toggle="modal" data-bs-target="#add_image" data-toggle="modal" data-target="#add_image">Add Image</a>
                        </div>
                    </div>
                    <hr>

                    <div class="d-flex justify-content-center align-items-center flex-wrap">

                      @foreach($images as $row)
                        <div class="m-2 text-center border border-primary rounded p-2" style="max-width: 300px;">
                          <a target="_blank" href="/storage/{{$row->image}}"><img src="/storage/{{$row->image}}" class="img img-fluid" alt="img_error" style="max-height: 200px;"></a>
                          <div class="mt-2 h6 text-wrap">{{$row->caption}}</div>
                          <div class="text-primary text-small">  {{$row->created_at}}</div>

                          <div class="text-center text-small mt-1">
                            <strong>
                              <a class="edit_image" href="javascript:{}" data-toggle="modal" data-target="#edit_image" data-image-id="{{$row->id}}" data-image-caption="{{$row->caption}}">Edit</a>
                              <form class="d-inline" id="delete-form-{{$row->id}}" action="/admin/image-gallery/{{$row->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a class="text-danger" href="javascript:{}" onclick="javascript:deleteData({{$row->id}});" title="Delete">Delete</a>
                              </form>
                            </strong>
                          </div>
                        </div>
                      @endforeach
                    </div>
                      
                    <div>
                      {{$images->onEachSide(1)->links('paginator.bootstrap')}}
                    </div>

                  </div>
                </div>
              </div>
        </div>
    </div>

    {{-- popup model for image add start --}}
    <div id="add_image" class="modal fade">
      <div class="modal-dialog ">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title"> Add New Image </h5>
                  <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form method="POST" action="/admin/image-gallery" enctype="multipart/form-data">
                      @csrf
                          
                      <div class="form-group row">
                        <label for="image" class="col-md-3 col-form-label">{{ __('Image') }}</label>
  
                        <div class="col-md-9">
                          <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required >
  
                          @error('image')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="caption" class="col-md-3 col-form-label">{{ __('Caption') }}</label>
  
                        <div class="col-md-9">
                          <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption') }}"  >
  
                          @error('caption')
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
    {{-- Popup Model For image Add End --}}

    
    {{-- popup model for image Edit start --}}
    <div id="edit_image" class="modal fade">
      <div class="modal-dialog ">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title"> Edit Image Caption  </h5>
                  <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form method="POST" action="/admin/image-gallery" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')   

                      <div class="form-group row">
                        <label for="image_id" class="col-md-3 col-form-label">{{ __(' Image ID') }}</label>
  
                        <div class="col-md-9">
                          <input id="image_id" type="text" class="form-control @error('image_id') is-invalid @enderror" name="image_id" value="{{ old('image_id') }}" required readonly>
  
                          @error('image_id')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="image_caption" class="col-md-3 col-form-label">{{ __(' Image Caption') }}</label>
  
                        <div class="col-md-9">
                          <input id="image_caption" type="text" class="form-control @error('image_caption') is-invalid @enderror" name="image_caption" value="{{ old('image_caption') }}" required >
  
                          @error('image_caption')
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
    {{-- Popup Model For image Edit End --}}

  <script>
    $(document).on('click', '.edit_image', function(){
      const id=$(this).attr('data-image-id');
      const caption=$(this).attr('data-image-caption');
      $('#image_id').val("");
      $('#image_caption').val("");
      
      $('#image_id').val(id);
      $('#image_caption').val(caption);

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

