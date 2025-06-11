@extends('admin.layouts.app')
@section('admin-title')
  Health Day Slogans
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Health Day Slogan</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/health-days') }}">Health Days</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Slogans </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title"> {{$healthDay->title}} </h4>
              <div class="text-right">
                <a class="btn btn-sm ml-3 btn-success" href="#add_slogan" data-bs-toggle="modal" data-bs-target="#add_slogan" data-toggle="modal" data-target="#add_slogan">Add Slogan</a>
              </div>
            </div>
            <div class="table-responsive table-responsive-md">
              <table class="table table-bordered" id="advanced-asc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Year</th>
                    <th>Slogan Title</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($slogans as $cat)
                  <tr>
                    <td width="100">{{$i}}</td>
                    <td class="text-wrap">{{$cat->name}}</td>
                    <td class="text-wrap">{{$cat->description}}</td>
                    
                    <td class="classroom-btn" width="100">
                      <a class="edit_slogan btn btn-warning" href="#edit_slogan" slogan-id="{{$cat->id}}" slogan-year="{{$cat->name}}" slogan-title="{{$cat->description}}" data-bs-toggle="modal" data-bs-target="#edit_slogan" data-toggle="modal" data-target="#edit_slogan">Edit</a>
                      <form id="delete-form-{{$cat->id}}" action="/admin/health-days/{{$healthDay->id}}/slogans/{{$cat->id}}" method="POST" style="display: inline">
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

  {{-- popup model for Slogan add start --}}
  <div id="add_slogan" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Add New Slogan </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/health-days/{{$healthDay->id}}/slogans" enctype="multipart/form-data">
            @csrf
                
            <div class="form-group row my-0">
              <label for="health_day" class="col-md-4 col-form-label">{{ __('Day') }}</label>

              <div class="col-md-8">
                <input id="health_day" type="text" class="form-control @error('health_day') is-invalid @enderror" name="health_day" value="{{ old('health_day') ?? $healthDay->title }}" required >

                @error('health_day')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
              <label for="year" class="col-md-4 col-form-label">{{ __(' Slogan Year') }}</label>

              <div class="col-md-8">
                <input id="year" type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" required >

                @error('year')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
              <label for="slogan" class="col-md-4 col-form-label">{{ __(' Slogan Title') }}</label>

              <div class="col-md-8">
                <input id="slogan" type="text" class="form-control @error('slogan') is-invalid @enderror" name="slogan" value="{{ old('slogan') }}" required >

                @error('slogan')
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
  {{-- Popup Model For slogan Add End --}}


  {{-- popup model for slogan Edit start --}}
  <div id="edit_slogan" class="modal fade">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Edit Health Day Slogan </h5>
          <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/health-days/{{$healthDay->id}}/slogans" enctype="multipart/form-data">
            @csrf
            @method('PATCH')   

            <div class="form-group row my-0">
              <label for="slogan_day" class="col-md-4 col-form-label">{{ __('Day') }}</label>

              <div class="col-md-8">
                <input id="slogan_day" type="text" class="form-control @error('slogan_day') is-invalid @enderror" name="slogan_day" value="{{ old('slogan_day') ?? $healthDay->title }}" required readonly>

                @error('slogan_day')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
              <label for="slogan_id" class="col-md-4 col-form-label">{{ __(' Slogan ID') }}</label>

              <div class="col-md-8">
                <input id="slogan_id" type="text" class="form-control @error('slogan_id') is-invalid @enderror" name="slogan_id" value="{{ old('slogan_id') }}" required readonly>

                @error('slogan_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
              <label for="slogan_year" class="col-md-4 col-form-label">{{ __(' Slogan Year') }}</label>

              <div class="col-md-8">
                <input id="slogan_year" type="number" class="form-control @error('slogan_year') is-invalid @enderror" name="slogan_year" value="{{ old('slogan_year') }}" required >

                @error('slogan_year')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row my-0">
              <label for="slogan_title" class="col-md-4 col-form-label">{{ __(' Slogan Title') }}</label>

              <div class="col-md-8">
                <input id="slogan_title" type="text" class="form-control @error('slogan_title') is-invalid @enderror" name="slogan_title" value="{{ old('slogan_title') }}" required >

                @error('slogan_title')
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
  {{-- Popup Model For slogan Edit End --}}


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
    $(document).on('click', '.edit_slogan', function(){
      const id=$(this).attr('slogan-id');
      const year=$(this).attr('slogan-year');
      const title=$(this).attr('slogan-title');
      $('#slogan_id').val("");
      $('#slogan_year').val("");
      $('#slogan_title').val("");
      
      $('#slogan_id').val(id);
      $('#slogan_year').val(year);
      $('#slogan_title').val(title);
    })
  </script> 
@endsection

