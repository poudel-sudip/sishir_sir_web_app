@extends('admin.layouts.app')
@section('admin-title')
    Batches
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">All Batches</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Batches</li>
              </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                      <div class="custon-table-header">
                          <h4 class="card-title">Batch table</h4>
                          <div class="text-right">
                            @if(auth()->user()->permission>=20)
                              <a href="{{ ('/admin/batches/create') }}"><button type="button" class="btn btn-sm ml-3 btn-success"> Add Batch </button></a>
                            @endif
                          </div>
                      </div>
                      <div class="table-responsive table-responsive-md">
                        <table class="table table-bordered" id="batches-table">
                          <thead>
                            <tr>
                                <th>ID</th>
                                <th>Batch Name</th>
                                <th>Course Name</th>
                                <th>Duration </th>
                                {{-- <th>Start Date</th> --}}
                                <th>Class Status</th>
                                <th>Time Slot</th>
                                <th>Status</th>
                                <th>Classroom</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($batches as $batch)
                            <tr>
                                <td>{{$batch->id}}</td>
                                <td>{{$batch->name}}</td>
                                <td>{{$course::find($batch->course_id)->name}}</td>
                                <td>{{$batch->duration}} {{$batch->durationType}}</td>
                                {{-- <td>{{date('Y-m-d',strtotime($batch->startDate))}}</td> --}}
                                <td>
                                  @if($batch->class_status == 'No Class')
                                    <span class="text-danger">{{$batch->class_status}}</span>
                                  @else
                                    <span class="text-primary">{{$batch->class_status}}</span>
                                  @endif
                                </td>
                                <td>{{$batch->timeSlot}}</td>
                                <td>
                                  @if($batch->status == 'Active')
                                  <span class="text-success">{{$batch->status}}</span>
                                  @elseif($batch->status == 'Inactive')
                                  <span class="text-danger">{{$batch->status}}</span>
                                  @elseif($batch->status == 'No Class')
                                  <span class="text-danger">{{$batch->status}}</span>
                                  @elseif($batch->status == 'Closed')
                                  <span class="text-warning">{{$batch->status}}</span>
                                  @else
                                  <span class="text-info">{{$batch->status}}</span>
                                  @endif
                                </td>
                                <td class="classroom-btn">
                                  @if(auth()->user()->permission>=20)
                                    <a href="/classroom/chat/{{$batch->id}}" class="btn btn-primary">View</a>
                                  @endif
                                </td>
                              <td>
                                <div class="dropdown">
                                  <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                                      <a href="/admin/batches/{{$batch->id}}" class="text-primary dropdown-item">Show</a>
                                      @if(auth()->user()->permission>=20)
                                      <a href="/admin/batches/{{$batch->id}}/edit" class="text-danger dropdown-item">Edit</a>
                                      <form id="delete-form-{{$batch->id}}" action="/admin/batches/{{$batch->id}}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <a href="javascript:{}" onclick="javascript:deleteData({{$batch->id}});" class="text-warning dropdown-item">Delete</a>
                                      </form>
                                      @endif
                                      <a href="/admin/batches/{{$batch->id}}/bookings/" class="text-success dropdown-item">Bookings</a>
                                      <a href="/admin/batch/{{$batch->id}}/followup/all" class="text-primary dropdown-item">Follow Up</a>
                                      <a href="/admin/batches/{{$batch->id}}/exams" class="text-danger dropdown-item">MCQ Exams</a>
                                      <a href="/admin/batches/{{$batch->id}}/assignments" class="text-warning dropdown-item">Assignments</a>
                                      <a href="/admin/batches/{{$batch->id}}/written-exams" class="text-success dropdown-item">Written Exams</a>
                                      <a href="/admin/batches/{{$batch->id}}/schedules" class="text-info dropdown-item">Schedules</a>
                                      <a href="/admin/batches/{{$batch->id}}/units" class="text-danger dropdown-item">Units</a>

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
<script>
    import App from "../../../../public/js/app";
    export default {
        components: {App}
    }
</script>
