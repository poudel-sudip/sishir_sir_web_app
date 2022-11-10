@extends('admin.layouts.app')
@section('admin-title')
    Video Chapters | {{$course->name}}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Chapters | {{$course->name}} </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Chapters </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Chapters | {{$course->name}}</h4>
                        <div class="text-right">
                            <a href="/admin/video-course/{{$course->id}}/chapters/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Chapter </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Videos</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters as $chapter)
                          <tr>
                            <td>{{$chapter->sn}}</td>
                            <td>{{$chapter->name}}</td>
                            <td>
                            @if($chapter->status == 'Inactive')
                              <span class="text-danger">{{$chapter->status}}</span>
                              @else
                              <span class="text-success">{{$chapter->status}}</span>
                            @endif
                            </td>

                            <td><a href="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/videos">Videos({{$chapter->videos->count()}})</a></td>

                            <td class="classroom-btn" width="160">
                              <a href="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}/edit" class="btn btn-warning">Edit</a>
                              <form id="delete-form-{{$chapter->id}}" action="/admin/video-course/{{$course->id}}/chapters/{{$chapter->id}}" method="POST" style="display: inline">
                                  @csrf
                                  @method('DELETE')
                                  <a href="javascript:{}" onclick="javascript:deleteData({{$chapter->id}});" class="btn btn-danger">Delete</a>
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

