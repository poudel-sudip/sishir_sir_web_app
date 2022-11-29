@extends('admin.layouts.app')
@section('admin-title')
    Batches
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Batches</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/courses') }}">Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Batches </li>
                </ol>
            </nav>
        </div> 
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Batches | {{$course->name}}</h4>
                          <div class="text-right">
                              <a href="{{ ('/admin/batches/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Create Batch </button></a>
                          </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table table-bordered" id="course-batch-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Batch Name</th>
                                <th>Duration </th>
                                <th>Time Slot</th>
                                <th>Status</th>
                                <th>Classroom</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($course->batches as $batch)
                            <tr>
                                <td>{{$batch->id}}</td>
                                <td>{{$batch->name}}</td>
                                <td>{{$batch->duration}} {{$batch->durationType}}</td>
                                <td>{{$batch->timeSlot}}</td>
                                <td>
                                    @if($batch->status == 'Active')
                                    <span class="text-success">{{$batch->status}}</span>
                                    @elseif($batch->status == 'Inactive')
                                    <span class="text-danger">{{$batch->status}}</span>
                                    @elseif($batch->status == 'Closed')
                                    <span class="text-warning">{{$batch->status}}</span>
                                    @else
                                    <span class="text-info">{{$batch->status}}</span>
                                    @endif
                                  </td>
                                <td> 
                                    <a href="/classroom/chat/{{$batch->id}}" class="text-primary">View</a> 
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                            <a href="/admin/batches/{{$batch->id}}" class="text-primary dropdown-item">Show</a>
                                            <a href="/admin/batches/{{$batch->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                            <form id="delete-form-{{$batch->id}}" action="/admin/batches/{{$batch->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:{}" onclick="javascript:deleteData({{$batch->id}});" class="text-warning dropdown-item">Delete</a>
                                            </form>
                                            <br>
                                            <a href="/admin/batches/{{$batch->id}}/bookings" class="text-info dropdown-item">Bookings</a>
                                            <a href="/admin/batches/{{$batch->id}}/exams" class="text-danger dropdown-item">MCQ Exams</a>
                                            {{-- <a href="/admin/batches/{{$batch->id}}/schedules" class="text-info dropdown-item">Schedules</a> --}}
                                            <a href="/admin/batches/{{$batch->id}}/units" class="text-info dropdown-item">Units</a>
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
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
