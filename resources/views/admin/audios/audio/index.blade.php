@extends('admin.layouts.app')
@section('admin-title')
    Uploaded Audios | {{ucwords($category->name)}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Audios | {{ucwords($category->name)}}</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/audios') }}">Audio Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Audios</li>
              </ol>
          </nav>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">Audios | {{ucwords($category->name)}}</h4>
                            <div class="text-right">
                                <a href="/admin/audios/{{$category->id}}/files/upload"><button type="button" class="btn btn-sm ml-3 btn-success">Upload Audio</button></a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-md">
                            <table class="table table-bordered" id="advanced-desc-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Filename</th>
                                        <th>URL</th>
                                        <th>Uploaded Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($audios as $audio)
                                    <tr>
                                        <td> {{$audio->id}} </td>
                                        <td class="text-wrap">{{$audio->filename}}</td>
                                        <td class="text-wrap">{{$audio->url}}</td>
                                        <td>{{date('Y-m-d',strtotime($audio->created_at))}}</td>
                                        <td>
                                            <form id="delete-form-{{$audio->id}}" action="/admin/audios/{{$category->id}}/files/{{$audio->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$audio->id}});" class="btn btn-warning">Delete</a>
                                            </form>
                                        </td>
                                    </tr>
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
    </div>
@endsection
