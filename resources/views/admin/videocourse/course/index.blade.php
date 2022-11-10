@extends('admin.layouts.app')
@section('admin-title')
    Video Course
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Video Courses</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Video Courses</li>
              </ol>
          </nav>
        </div>  
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Video Course table</h4>
                        <div class="text-right">
                            <a href="{{ ('/admin/video-course/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Course </button></a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-md">
                      <table class="table table-bordered" id="table-courses">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Category</th>
                            <th>Pinned</th>
                            <th>Order</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                          <tr>
                            <td>{{$course->id}}</td>
                            <td class="text-wrap">{{$course->name}}</td>
                            <td class="text-wrap">{{$course->category->name ?? '-'}}</td>
                            <td>{{$course->isPinned}}</td>
                            <td>{{$course->order}}</td>
                            <td>{{$course->fee ?? 0}} - {{$course->discount ?? 0}} = {{$course->fee - $course->discount}}</td>
                            <td>
                              @if($course->status == 'Inactive')
                              <span class="text-danger">{{$course->status}}</span>
                              @else
                              <span class="text-success">{{$course->status}}</span>
                              @endif
                            </td>
                            <td>
                              <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                  <a href="/admin/video-course/{{$course->id}}" class="text-primary dropdown-item">Show</a>
                                  <a href="/admin/video-course/{{$course->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                  <form id="delete-form-{{$course->id}}" action="/admin/video-course/{{$course->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$course->id}});" class="text-warning dropdown-item">Delete</a>
                                  </form>
                                  <br>
                                  <a href="/admin/video-course/{{$course->id}}/chapters" class="text-info dropdown-item">Chapters</a>
                                  <a href="/admin/video-course/{{$course->id}}/exams" class="text-primary dropdown-item">MCQ Exams</a>
                                  <a href="/admin/video-course/{{$course->id}}/cqc" class="text-warning dropdown-item">CQQ</a>
                                  <a href="/admin/video-course/{{$course->id}}/tutors" class="text-danger dropdown-item">Tutors</a>
                                  <a href="/admin/video-course/{{$course->id}}/booking" class="text-success dropdown-item">Bookings</a>
                                </div>
                              </div>
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
                    <hr>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    
@endsection
