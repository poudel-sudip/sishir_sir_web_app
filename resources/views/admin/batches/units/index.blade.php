@extends('admin.layouts.app')
@section('admin-title')
    Class Units
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Units | {{$batch->name}}</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/batches') }}">Batches</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Units </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
                <h4 class="card-title">Units Table | {{$batch->name}}</h4>
                <div class="text-right">
                    <a href="#add_unit" class="btn btn-success" data-toggle="modal" data-bs-toggle="modal" data-target="#add_unit" data-bs-target="#add_unit"> Add Unit</a>
                </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-desc-table">
                <thead>
                  <tr>
                    <th width="50">SN</th>
                    <th>Name</th>
                    <th width="250">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($units as $unit)
                    <tr>
                      <td width="50">{{$i}}</td>
                      <td>{{$unit->name}}</td>
                      
                      <td class="classroom-btn" width="250">
                        <a href="/classroom/files/{{$batch->id}}/unit/{{$unit->id}}" class="btn btn-primary">Files</a>
                        <a href="/classroom/videos/{{$batch->id}}/unit/{{$unit->id}}" class="btn btn-info">Videos</a>
                        <a href="#edit_unit" class="edit_unit_btn btn btn-warning" unit-id="{{$unit->id}}" unit-name="{{$unit->name}}" data-toggle="modal" data-bs-toggle="modal" data-target="#edit_unit" data-bs-target="#edit_unit">Edit</a>
                        <form id="delete-form-{{$unit->id}}" action="/admin/batches/{{$batch->id}}/units/{{$unit->id}}" method="POST" style="display: inline">
                          @csrf
                          @method('DELETE')
                          <a href="javascript:{}" onclick="javascript:deleteData({{$unit->id}});" class="btn btn-danger">Delete</a>
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

  {{-- Popup Model For Adding Unit Start --}}
    <div id="add_unit" class="modal fade">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title"> Add Unit </h5>
              <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="/admin/batches/{{$batch->id}}/units" enctype="multipart/form-data">
              @csrf

              <div class="form-group row">
                <label for="batch" class="col-md-3 col-form-label">{{ __(' Batch') }}</label>

                <div class="col-md-9">
                  <input id="batch" type="text" class="form-control @error('batch') is-invalid @enderror" name="batch" value="{{ $batch->name }}" readonly>

                  @error('batch')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="unit" class="col-md-3 col-form-label">{{ __(' Unit Name') }}</label>

                <div class="col-md-9">
                  <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit') }}" required>

                  @error('unit')
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
  {{-- Popup Model For Adding Unit End--}}

  {{-- Popup Model For Adding Unit Start --}}
    <div id="edit_unit" class="modal fade">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title"> Edit Unit </h5>
              <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="/admin/batches/{{$batch->id}}/units" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="form-group row">
                <label for="unit_id" class="col-md-3 col-form-label">{{ __(' Unit ID') }}</label>

                <div class="col-md-9">
                  <input id="unit_id" type="text" class="form-control @error('unit_id') is-invalid @enderror" name="unit_id" value="{{ old('unit_id') }}" readonly required>

                  @error('unit_id')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="batch_name" class="col-md-3 col-form-label">{{ __(' Batch') }}</label>

                <div class="col-md-9">
                  <input id="batch_name" type="text" class="form-control @error('batch_name') is-invalid @enderror" name="batch_name" value="{{ $batch->name }}" readonly>

                  @error('batch_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="unit_name" class="col-md-3 col-form-label">{{ __(' Unit Name') }}</label>

                <div class="col-md-9">
                  <input id="unit_name" type="text" class="form-control @error('unit_name') is-invalid @enderror" name="unit_name" value="{{ old('unit_name') }}" required>

                  @error('unit_name')
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
  {{-- Popup Model For Adding Unit End--}}

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

  <script>
    $(document).on('click', '.edit_unit_btn', function(){
        const id=$(this).attr('unit-id');
        const name=$(this).attr('unit-name');
        $('#unit_id').val("");
        $('#unit_name').val("");
        
        $('#unit_id').val(id);
        $('#unit_name').val(name);
    })
  </script>

@endsection

