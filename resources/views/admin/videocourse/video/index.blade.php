@extends('admin.layouts.app')
@section('admin-title')
    Video Posts | {{$chapter->name}} | {{$course->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Videos | {{$chapter->name}} | {{$course->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
              <li class="breadcrumb-item"><a href="/admin/video-course/{{$course->id}}/chapters">Chapters</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Videos </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Videos | {{$chapter->name}} | {{$course->name}}</h4>
                        <div class="text-right">
                            <a href="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Video </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $vid)
                          <tr>
                            <td>{{$vid->id}}</td>
                            <td class="text-wrap">{{$vid->title}}</td>
                            <td class="text-wrap">{{ url($vid->link) }}</td>
                            <td>
                            @if($vid->status == 'Inactive')
                              <span class="text-danger">{{$vid->status}}</span>
                              @else
                              <span class="text-success">{{$vid->status}}</span>
                            @endif
                            </td>
                              <td class="classroom-btn" width="160">
                                <a href="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos/{{$vid->id}}" class="btn btn-primary">Show</a>
                                <a href="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos/{{$vid->id}}/edit" class="btn btn-warning">Edit</a>
                                <form id="delete-form-{{$vid->id}}" action="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos/{{$vid->id}}" method="POST" style="display: inline">
                                      @csrf
                                      @method('DELETE')
                                      <a href="javascript:{}" onclick="javascript:deleteData({{$vid->id}});" class="btn btn-danger">Delete</a>
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

