@extends('admin.layouts.app')
@section('admin-title')
    Free Videos
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Free Videos</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Free Videos</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custon-table-header">
                            <h4 class="card-title">All Free Videos</h4>
                            <div class="text-right">
                                @if(auth()->user()->permission==50 || auth()->user()->permission==20 )
                                <a href="{{ ('/admin/free-videos/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Free Video </button></a>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="user-table">
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
                                    @foreach($videos as $video)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td class="text-wrap">{{$video->title}}</td>
                                        <td class="text-wrap">{{$video->link}}</td>

                                        <td class="classroom-btn" width="160">
                                            @if(auth()->user()->permission==50 || auth()->user()->permission==20 )
                                            <form id="delete-form-{{$video->id}}" action="/admin/free-videos/{{$video->id}}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$video->id}});" class="btn btn-warning">Delete</a>
                                            </form>
                                            @endif
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
                            <hr>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
