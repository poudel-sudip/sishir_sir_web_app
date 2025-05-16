@extends('admin.layouts.app')
@section('admin-title')
  Libraries @if($category) | {{$category->name}} @endif
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Libraries @if($category) | {{ucwords($category->name)}} @endif </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/admin/library') }}">Library</a></li>
          @if($category)
            @php 
            $cur = $category;
            $bcm = [];
            while($cur)
            {
              $c = (object)[
                'name' => $cur->name,
                'link' => '/admin/library/'.$cur->id.'/directories',
              ];
              array_push($bcm,$c);
              $cur = $cur->parent;
            } 
            $bcm = array_reverse($bcm);
            @endphp

            @foreach($bcm as $b)
              <li class="breadcrumb-item"><a href="{{$b->link}}">{{ucwords($b->name)}}</a></li>
            @endforeach

          @endif
          {{-- <li class="breadcrumb-item active" aria-current="page"> Libraries </li> --}}
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 ">
        <div class="card">
          <div class="card-body">
            <div class="custon-table-header">
              <h4 class="card-title">Libraries @if($category) | {{ucwords($category->name)}} @endif</h4>
            </div>
            <div class="chatroom-section">
              <div class="row chatroom-main-content align-items-center">
                
                @if(!$category || !$category->materials()->count())
                  <div class="col-md-3 text-center">
                    <button type="button" class="btn create-new-file border-warning" data-toggle="modal" data-target="#create_folder">
                      <i class="fa fa-plus text-warning" aria-hidden="true"> Folder</i>
                      <div class="file-upload-hover bg-warning" >+ Add New Folder</div>
                    </button>
                  </div>
                
                  @foreach($categories as $cat)
                  <div class="col-md-3 col-6 my-3">
                    <div>
                      <a href="/admin/library/{{$cat->id}}/directories" class="h1"><i class="fa fa-folder-open text-primary"></i></a>
                    </div>
                    <div class="h5">
                      <a href="/admin/library/{{$cat->id}}/directories" style="color:inherit;">{{ucwords($cat->name)}} <small>({{$cat->total_materials ?? '0'}} Files)</small></a>
                    </div>
                    <div>
                      <a class="edit-folder btn-sm btn-info" href="#edit_folder" folder-name="{{$cat->name}}"  folder-id="{{$cat->id}}" data-toggle="modal" data-target="#edit_folder">Edit</a>
                      <form class="d-inline" id="delete-form-{{$cat->id}}" action="/admin/library/{{$cat->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="parent" value={{$category->id ?? null}}>
                        <a class="btn-sm btn-danger" href="javascript:{}" onclick="javascript:deleteFolder({{$cat->id}});" title="Delete">Delete</a>
                      </form>
                    </div>
                  </div>
                      
                  @endforeach

                @endif

                @if($category && !$category->childs()->count())
                  <div class="col-md-3 text-center">
                    <a class="btn create-new-file" href="/admin/library/{{$category->id}}/materials/create">
                      <i class="fa fa-plus" aria-hidden="true"> File</i>
                      <div class="file-upload-hover">+ Add New File</div>
                    </a>
                  </div>

                  @foreach($category->materials()->orderBy('id')->get() as $material)
                    <div class="col-md-4 single-file col-6 my-3">
                      <div class="demo-file">
                        <a href="/admin/library/{{$category->id}}/materials/{{$material->id}}"><img src="/storage/{{$material->thumbnail}}" onerror="this.src='{{asset('images/default-post.png')}}'" class="img img-fluid" ></a>
                      </div>
              
                      <div class="user-files text-center">
                        <h4><a href="/admin/library/{{$category->id}}/materials/{{$material->id}}">{{$material->name}}</a></h4>
                      </div>
                      <div class="text-center">
                        <small class="upload-user text-primary">  Date: {{$material->created_at}}</small>
                        <p class="text-{{$material->status=='Active' ? 'info' : 'danger'}}">( {{$material->status}} )</p>
                        <div class="mt-2">
                          <a class="btn-sm btn-info" href="/admin/library/{{$category->id}}/materials/{{$material->id}}/edit" >Edit</a>
                          <form class="d-inline" id="delete-material-{{$material->id}}" action="/admin/library/{{$category->id}}/materials/{{$material->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a class="btn-sm btn-danger" href="javascript:{}" onclick="javascript:deleteData({{$material->id}});" title="Delete">Delete</a>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endforeach

                @endif
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    
  </div>

  {{-- for add folder model start--}}
  <div class="modal fade" id="create_folder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Folder</h5>
                <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>

            <div class="modal-body enroll_form">
                <form method="POST" action="/admin/library" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="folderName" class="col-md-4 col-form-label text-md-right">{{ __('Folder Name') }}</label>

                        <div class="col-md-8">
                            <input id="folderName" type="text" class="form-control @error('folderName') is-invalid @enderror" name="folderName" value="{{ old('folderName') }}" required autofocus>
                            <input type="hidden" name="parent" value={{$category->id ?? null}}>
                            @error('folderName')
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
  {{-- for add folder model end--}}

  {{-- for edit folder model start--}}
  <div class="modal fade" id="edit_folder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Folder</h5>
                <button type="button" class="close border-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>

            <div class="modal-body enroll_form">
                <form method="POST" action="/admin/library" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group row">
                      <label for="folder_id" class="col-md-4 col-form-label text-md-right">{{ __('Folder ID') }}</label>

                      <div class="col-md-8">
                          <input id="folder_id" type="text" class="form-control @error('folder_id') is-invalid @enderror" name="folder_id" value="{{ old('folder_id') }}" required readonly>
                          @error('folder_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="folder_name" class="col-md-4 col-form-label text-md-right">{{ __('Folder Name') }}</label>

                      <div class="col-md-8">
                          <input id="folder_name" type="text" class="form-control @error('folder_name') is-invalid @enderror" name="folder_name" value="{{ old('folder_name') }}" required autofocus>
                          @error('folder_name')
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
  {{-- for edit folder model end--}}


  {{-- <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Library Categories</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Library Categories </li>
        </ol>
      </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="custon-table-header">
                    <h4 class="card-title">Library Categories</h4>
                    <div class="text-right">
                        <a href="{{ ('/admin/library/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Library Category</button></a>
                    </div>
                </div>
                <div class="table-responsive table-responsive-md">
                  <table class="table table-bordered" id="advanced-desc-table">
                    <thead>
                      <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Order</th>
                        <th>Materials</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php($i=1)
                        @foreach($categories as $group)
                      <tr>
                        <td width="50">{{$i}}</td>
                        <td>{{$group->name}}</td>
                        <td>{{$group->order}}</td>
                        <td><a href="/admin/library/{{$group->id}}/materials">Materials ( {{$group->materials->count()}} ) </a></td>
                        <td>
                          @if($group->status == 'Inactive')
                            <span class="text-danger">{{$group->status}}</span>
                            @else
                            <span class="text-success">{{$group->status}}</span>
                          @endif
                        </td>
                        <td class="classroom-btn" width="100">
                          <a href="/admin/library/{{$group->id}}/edit" class="btn btn-warning">Edit</a>
                          <form id="delete-form-{{$group->id}}" action="/admin/library/{{$group->id}}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:{}" onclick="javascript:deleteData({{$group->id}});" class="btn btn-danger">Delete</a>
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
  </div> --}}

  <script type="text/javascript">
    function deleteFolder(id)
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
    // this script is used to prompt edit model
    $(document).ready(function(){
      $('.edit-folder').click(function(){
        //clear previous data
        $('#folder_id').attr('value','');
        $('#folder_name').attr('value','');

        //fetch current data
        let fid = $(this).attr('folder-id');
        let fname = $(this).attr('folder-name');

        //set the value to edit model
        $('#folder_id').attr('value',fid);
        $('#folder_name').attr('value',fname);
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
              document.getElementById('delete-material-'+id).submit();
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

