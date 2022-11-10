@extends('admin.layouts.app')
@section('admin-title')
    Video Tutors | {{$course->name}} 
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
        <h3 class="page-title">Video Tutors | {{$course->name}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/video-course') }}">Video Courses</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Tutors </li>
            </ol>
        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="custon-table-header">
                        <h4 class="card-title">Video Tutors | {{$course->name}}</h4>
                        <div class="text-right">
                            <a href="/admin/video-course/{{$course->id}}/tutors/create"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Tutor </button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="category-table">
                        <thead>
                          <tr>
                            <th>SN</th>
                            <th>Course</th>
                            <th>Tutor Name</th>
                            <th>Tutor Email</th>
                            <th>Tutor Contact</th>
                            <th>Tutor Percentage</th>
                            <th>Tutor Paid Amount</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($tutors as $tutor)
                          <tr>
                            <td>{{$i}}</td>
                            <td class="text-wrap">{{$course->name}}</td>
                            <td class="text-wrap">{{ $tutor->tutor->name ?? '' }}</td>
                            <td class="text-wrap">{{ $tutor->tutor->user->email ?? '' }}</td>
                            <td class="text-wrap">{{ $tutor->tutor->user->contact ?? '' }}</td>
                            <td class="text-wrap">{{ $tutor->percent ?? '0' }} %</td>
                            <td class="text-wrap">Rs. {{ $tutor->paidAmount ?? '0' }}</td>
                            <td class="classroom-btn" width="160">
                              <a href="/admin/video-course/{{$course->id}}/tutors/{{$tutor->id}}/edit" class="btn btn-info">Edit</a>
                              <form id="delete-form-{{$tutor->id}}" action="/admin/video-course/{{$course->id}}/tutors/{{$tutor->id}}" method="POST" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:{}" onclick="javascript:deleteData({{$tutor->id}});" class="btn btn-danger">Delete</a>
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
    </div>
@endsection

