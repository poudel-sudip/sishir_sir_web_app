@extends('admin.layouts.app')
@section('admin-title')
    Exam Categories
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">All Exam Categories </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Exam Categories </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">All Exam Categories</h4>
              <div class="text-right">
                <a href="/admin/exam-category/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Category </button></a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered" id="advanced-desc-table">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Action</th>
                    <th>Category Title</th>
                    <th>Exams</th>
                    <th>Creator</th>
                  </tr>
                </thead>
                <tbody>
                  @php($i=1)
                  @foreach($categories as $cat)
                    <tr>
                      <td>{{$i}}</td>
                      <td class="text-wrap">
                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                <a href="#edit_category" cat-name="{{$cat->title}}"  cat-id="{{$cat->id}}" data-toggle="modal" data-target="#edit_category" class="edit-category text-warning dropdown-item">Edit</a>
                                <form id="delete-form-{{$cat->id}}" action="/admin/exam-category/{{$cat->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$cat->id}});" class="text-danger dropdown-item">Delete</a>
                                </form>
                            </div>
                        </div>
                      </td>
                      <td class="text-wrap">{{ucwords($cat->title)}}</td>
                      <td> <a href="/admin/exam-category/{{$cat->id}}/exams" class="btn-sm btn-info">Exams ( {{$cat->exams->count()}} ) </a> </td>
                      <td> {{$cat->creator->name ?? '-'}} </td>
                      
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

  {{-- for edit category model start--}}
  <div class="modal fade" id="edit_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Exam Category</h5>
                <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>

            <div class="modal-body enroll_form">
                <form method="POST" action="/admin/exam-category" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group row">
                      <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category ID') }}</label>

                      <div class="col-md-8">
                        <input id="category_id" type="text" class="form-control @error('category_id') is-invalid @enderror" name="category_id" value="{{ old('category_id') }}" required readonly>
                        @error('category_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="category_name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

                      <div class="col-md-8">
                        <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" required autofocus>
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
  {{-- for edit category model end--}}

  <script>

    $(document).ready(function(){
      $('.edit-category').click(function(){
        $('#category_id').attr('value','');
        $('#category_name').attr('value','');

        //fetch current data
        let fid = $(this).attr('cat-id');
        let fname = $(this).attr('cat-name');

        //set the value to edit model
        $('#category_id').attr('value',fid);
        $('#category_name').attr('value',fname);
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

