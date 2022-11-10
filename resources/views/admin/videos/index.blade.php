@extends('admin.layouts.app')
@section('admin-title')
    Videos
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Videos</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Videos</li>
              </ol>
          </nav>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Videos</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission==50 || auth()->user()->permission==20 )
                                <a href="{{ ('/admin/videos/upload') }}"><button type="button" class="btn btn-sm ml-3 btn-success">Upload Video</button></a>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="video-table">
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
                                    @foreach($videos as $video)
                                    <tr>
                                        <td> {{$video->id}} </td>
                                        <td class="text-wrap">{{$video->filename}}</td>
                                        <td class="text-wrap">{{$video->url}}</td>
                                        <td>{{date('Y-m-d',strtotime($video->created_at))}}</td>
                                        <td>
                                            @if(auth()->user()->permission==50 || auth()->user()->permission==20 )
                                            <form id="delete-form-{{$video->id}}" action="/admin/videos/{{$video->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$video->id}});" class="btn btn-warning">Delete</a>
                                            </form>
                                            @endif
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
